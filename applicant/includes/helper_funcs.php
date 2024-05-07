<?php
function upload($file)
{
    if (isset($_FILES[$file])) {
        $birthCertificate = new FileUpload($file);
        $birthCertificate->uploadFile();
        $uploadStatus =  $birthCertificate->uploadStatus;
        switch ($uploadStatus) {
            case 0:
                $message = "File uploaded successifully";
                return $message;
            case 1:
                $message = "File upload failure";
                return $message;
            case 2:
                $message = "File upload failed, file destination error";
                return $message;
            case 3:
                $message = "File upload fail, problem changing the file name";
                return $message;
            case 4:
                $message = "File upload fail, applicant name is not set (to be used as file name)";
                return $message;
            case 5:
                $message = "File upload fail, file size exceeds 2MB, note your upload files should be less than 2MB";
                return $message;
            case 6:
                $message = "File upload fail, upload already exists, please delete the existing document before uploading";
                return $message;
            default:
                $message = "Upload Error, contact the admin";
                return $message;
        }
    }
    return ""; // for debug
}

function delete()
{

    if (isset($_GET['filename'])) {
        $name = $_GET['filename'];
        $uploaded = new FileUpload($name);
        $uploaded->delete();
        $deleteStatus = $uploaded->deleteStatus;
        switch ($deleteStatus) {
            case  0:
                $message =  "File deleted Successfully";
                return $message;
            case  1:
                $message =  "File delete fail !";
                return $message;
            case  2:
                $message =  "File delete fail, deleting record failed"; // for debug
                return $message;
            case  3:
                $message =  "File delete fail, record does not exist"; // for debug
                return $message;
            case  4:
                $message =  "File delete fail, file does not exist"; // for debug
                return $message;
            default:
                $message = "Error";
                return $message;
        }
    }
}

function refresh($url, $time)
{
    header("refresh:$time;" . $url);
}

function redirect($url): void
{
    header("Location:" . $url);
}
