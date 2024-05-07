<?php
class FileUpload extends Applicant // inherits from Applicant
{
    public $file;
    public $fileKey;
    public $fileTmpName;
    public $fileName;
    public $fileSize;
    public $fileExtension;
    public $applicantName;
    public $applicantId;
    public $destination;
    public $uploadStatus;
    public $deleteStatus;
    public $uploadRecord;
    public $filePath;

    public $maxFileSize = 2 * 1023 * 1023;
    public $uploadDir = "./uploads/";


    public function __construct($fileKey)
    {
        $this->fileKey = $fileKey;
        if (isset($_FILES[$fileKey])) {
            $this->file = $_FILES[$fileKey];
            $this->fileTmpName =  $this->file['tmp_name'];
            $this->fileName =  $this->file['name'];
            $this->fileSize =  $this->file['size'];
            $this->fileExtension = pathinfo($this->fileName, PATHINFO_EXTENSION);
        }
        $this->connection = parent::createDbConnection();
        $this->setApplicantName();
        $this->uploadRecordExists();
    }

    public function fileSizeOkay()  // check file size
    {
        return $this->fileSize <= $this->maxFileSize;
    }

    public function setApplicantName() // set applicant name,
    {
        $applicant = $this->selectApplicantByPhoneNumber($_SESSION['id'])[0]; // get the first record
        $this->applicantId = $applicant['id'];
        $this->applicantName = $applicant['lastname'] . "_" . $applicant['firstname'];
        return $this->applicantName;
    }

    public function getApplicantId() //find applicant_id in documents uploads
    {
        try {
            $sql = "SELECT applicant_id FROM applicant_documents WHERE applicant_id = :applicant_id";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute(["applicant_id" => $this->applicantId]);
            $applicantId = $stmt->fetchColumn(); // capture the upload record (from db)
            return $applicantId;
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function changeFileName() // change the file name
    {
        return $this->fileName = $this->applicantName . "_" . $this->fileKey . "." . $this->fileExtension;
    }

    public function setDestination() // set file destination
    {
        $this->destination = $this->uploadDir . $this->fileName;
        return $this->destination;
    }

    public function upload()  // move the file
    {
        return move_uploaded_file($this->fileTmpName, $this->destination);
    }

    public function uploadFile()
    {
        if ($this->fileSizeOkay()) {
            //file size okay
            if (!empty($this->setApplicantName())) {
                // applicant name is set
                if (!empty($this->changeFileName())) {
                    // file name has been changed
                    if (!empty($this->setDestination())) {
                        // destination is set
                        // ==> check whether the record exists
                        if (!$this->uploadRecordExists()) {
                            // upload record does not record exists
                            if ($this->upload() && $this->createUploadRecord()) {
                                $this->uploadStatus = 0;
                                return true;
                            } else {
                                // upload fail
                                $this->uploadStatus = 1;
                                return false;
                            }
                        } else {
                            // upload record already exists
                            $this->uploadStatus = 6;
                            return false;
                        }
                    } else {
                        // problem setting destination
                        $this->uploadStatus = 2;
                        return false;
                    }
                } else {
                    // problem changing the file name
                    $this->uploadStatus = 3;
                    return false;
                }
            } else {
                // applicant name is not set
                $this->uploadStatus = 4;
                return false;
            }
        } else {
            // file size more than 2 MB
            $this->uploadStatus = 5;
            return false;
        }
    }

    public function deleteRecord() // dele record from db
    {
        try {
            // $sql = "DELETE FROM applicant_documents WHERE $this->fileKey = " . "'" . $this->uploadRecord . "'";
            // UPDATE items SET name = '' WHERE id = 3 ;
            $sql = "UPDATE applicant_documents SET $this->fileKey = :$this->fileKey WHERE applicant_id = :applicant_id";
            $stmt = $this->connection->prepare($sql);
            // $stmt->execute();
            $results = $stmt->execute([$this->fileKey => "", "applicant_id" => $this->getApplicantId()]);
            // $deleted = $stmt->rowCount();
            if ($results != false) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getFilePath()
    {
        $this->filePath = "$this->uploadDir/$this->uploadRecord";
        return $this->filePath;
    }

    function fileExists() // check if file exists in directory
    {
        return file_exists($this->filePath);
    }

    function deleteFile() // delete file for from directory
    {
        return unlink($this->filePath);
    }

    public function delete() // delete method
    {
        $this->getFilePath(); // get the path of the file
        if ($this->fileExists()) {
            if ($this->uploadRecordExists()) {
                // echo "ready to delete";
                if ($this->deleteRecord()) {
                    // echo "deleting record";
                    if ($this->deleteFile()) {
                        // success 
                        $this->deleteStatus = 0;
                        return true;
                    } else {
                        // unlink failed
                        $this->deleteStatus = 1;
                        return false;
                    }
                } else {
                    // deleting failed, deleting record db
                    $this->deleteStatus = 2;
                    return false;
                }
            } else {
                // deleting failed, record does not exist
                $this->deleteStatus = 3;
                return false;
            }
        } else {
            // deleting failed, file does not exist
            $this->deleteStatus = 4;
            return false;
        }
    }

    public function createUploadRecord() // create upload record in db 
    {
        try {
            if (empty($this->getApplicantId())) {
                $sql = "INSERT INTO applicant_documents (applicant_id, $this->fileKey) VALUES (:applicant_id, :$this->fileKey)";
                $stmt = $this->connection->prepare($sql);
                $results = $stmt->execute(["applicant_id" => $this->applicantId, $this->fileKey => $this->fileName]);
                if ($results != false) {
                    return true;
                }
            } else {
                $sql = "UPDATE applicant_documents SET $this->fileKey = :$this->fileKey WHERE applicant_id = :applicant_id";
                $stmt = $this->connection->prepare($sql);
                $results = $stmt->execute([$this->fileKey => $this->fileName, "applicant_id" => $this->applicantId]);
                if ($results != false) {
                    return true;
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function uploadRecordExists() // check if upload record 
    {
        try {
            $sql = "SELECT $this->fileKey FROM applicant_documents WHERE applicant_id = :applicant_id";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute(["applicant_id" => $this->applicantId]);
            $this->uploadRecord = $stmt->fetchColumn(); // capture the upload record (from db)
            return !empty($this->uploadRecord);
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
