<?php
class Form
{
    public $connection;
    public $post;
    public $queryStatus;
    public $fieldsOkay;

    // db connection
    // check if the fields are okay, incase client side refuses to work
    public function __construct()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") { // what would be a solution for very many fields?
            $this->post = $_POST;
            $this->checkFields($this->post);
        }
        $this->connection = $this->createDbConnection();
    }

    public function checkFields($array) // post or get
    {
        foreach ($array as $value) {
            if (empty(trim($value))) {
                $this->fieldsOkay = false;
                return false;
            }
        }
        $this->fieldsOkay = true;
        return true;
    }

    public function createDbConnection()
    {
        $dsn = "mysql:host=localhost;port=3307;dbname=form";
        $username = "admin";
        $password = "admin2024";
        try {
            $pdo = new PDO($dsn, $username, $password);
            return $pdo;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function register()
    {
        if ($this->fieldsOkay) {
            if ($this->checkIfUserExists() == false) {
                try {
                    $sql = "INSERT INTO application_form (firstname, lastname, email_address, phone_number) VALUES (:firstname, :lastname, :email_address, :phone_number)";
                    $stmt = $this->connection->prepare($sql);
                    $result = $stmt->execute($this->post);
                    if ($result != false) {
                        //SUCCESS
                        $this->createLog();
                        $this->queryStatus = 0;
                        return true;
                    } else {
                        // SOMETHING WENT WRONG
                        $this->queryStatus = 1;
                        return false;
                    }
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            } else {
                // USER ALREADY EXISTS
                $this->queryStatus = 2;
                return false;
            }
        } else {
            $this->queryStatus = 3;
            return false;
        }
    }

    public function checkIfUserExists()
    {
        $sql = "SELECT COUNT(*) FROM application_form WHERE email_address = :email_address OR phone_number = :phone_number";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['email_address' => $this->post['email_address'], 'phone_number' => $this->post['phone_number']]);
        $count = $stmt->fetchColumn();
        return $count >= 1 ? true : false;
    }

    public function selectAll()
    {
        $sql = "SELECT * FROM application_form";
        $result = $this->connection->query($sql);
        $records = $result->fetchAll(PDO::FETCH_ASSOC);
        return $records;
    }

    function selectById()
    {
        $sql = "SELECT * FROM application_form WHERE id = :id"; # named parameters
        $stmt = $this->connection->prepare($sql);
        if ($stmt->execute($_GET)) {
            $record = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $record;
        } else {
            return null;
        }
    }

    function selectDocumentsById()
    {
        $sql = "SELECT * FROM applicant_documents WHERE applicant_id = :id"; # named parameters
        $stmt = $this->connection->prepare($sql);
        if ($stmt->execute($_GET)) {
            $record = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $record;
        } else {
            return null;
        }
    }

    function showLogs()
    {
        // create a log to sqlite db 
        // admin can view logs online
        try {
            //code...
            $pdo = new PDO('sqlite:./log.db', null, null, array(PDO::ATTR_PERSISTENT => true));
            $sql = "SELECT * FROM log";
            $result = $pdo->query($sql);
            $records = $result->fetchAll(PDO::FETCH_ASSOC);
            return $records;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function createLog()
    {
        try {
            $pdo = new PDO('sqlite:./log.db', null, null, array(PDO::ATTR_PERSISTENT => true));
            $sql = 'INSERT INTO log (name, date, time) VALUES (:name,  :date, :time)';
            $name = $this->post['firstname'] . ' ' . $this->post['lastname'];
            $stmt = $pdo->prepare($sql);
            $date = date("d-m-Y");
            $time = date("H:i:s");
            $result =  $stmt->execute(["name" => $name, "date" => $date, "time" => $time]);
            if ($result != false) {
                return true;
            }
            return $result;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
