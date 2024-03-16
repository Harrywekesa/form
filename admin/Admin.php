<?php
class Admin
{
    // register
    // login
    // reset password
    public $connection;
    public $post;
    public $queryStatus;
    public $fieldsOkay;
    public $passwordStatus;

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


    // check pass length
    //


    function checkPasswordLength()
    {
        return strlen(trim($this->post['password'])) >= 8; // returns true if len >= 8
    }

    function confirmPassword()
    {
        return trim($this->post['password']) == trim($this->post['confirm_password']);
    }

    function hashPassword()
    {
        return password_hash(trim($this->post['password']), CRYPT_BLOWFISH);
    }

    function registerAdmin()
    {
        if ($this->fieldsOkay) {
            if (!$this->userExists()) {
                if ($this->confirmPassword()) {
                    if ($this->checkPasswordLength()) {
                        $this->post['password'] = $this->hashPassword();
                        unset($this->post['confirm_password']);
                        unset($this->post['submit']);
                        try {
                            $sql = "INSERT INTO admin (firstname, lastname, second_name, email_address, phone_number, id_number, password) VALUES (:firstname, :lastname, :second_name, :email_address, :phone_number, :id_number, :password)";
                            $stmt = $this->connection->prepare($sql);
                            $result = $stmt->execute($this->post);
                            if ($result != false) {
                                //SUCCESS
                                // $this->createLog(); // log to be created during login 
                                $this->queryStatus = 0;
                                return true;
                            } else {
                                // SOMETHING WENT WRONG
                                $this->queryStatus = 1;
                                return false;
                            }
                        } catch (Exception $e) {
                            echo $e->getMessage();
                            return false;
                        }
                    } else {
                        $this->queryStatus = 2; //pass length
                        return false;
                    }
                } else {
                    $this->queryStatus = 3; // pass dont match
                    return false;
                }
            } else {
                $this->queryStatus = 4; // user alreasy exists
                return false;
            }
        } else {
            $this->queryStatus = 5; // fields not okay
            return false;
        }
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

    function loginAdmin()
    {
        if ($this->userExists()) {
            if ($this->verifyPassword()) {
                $this->queryStatus = 0; // success
                $this->startSession();
                $this->createLog(); // create a log
                return true;
            } else {
                $this->queryStatus = 1;  // wrong password
            }
        } else {
            $this->queryStatus = 2; // user does not exist
            return false;
        }
    }

    function resetPassword()
    {
        if ($this->fieldsOkay) {
            if ($this->userExists()) {
                if ($this->confirmPassword()) {
                    if ($this->checkPasswordLength()) {
                        $this->post['password'] = $this->hashPassword();
                        unset($this->post['confirm_password']);
                        unset($this->post['submit']);
                        try {
                            $sql = "UPDATE admin SET password = :password WHERE id_number = :id_number AND email_address = :email_address";
                            $stmt = $this->connection->prepare($sql);
                            $result = $stmt->execute($this->post);
                            if ($result != false) {
                                // success
                                $this->queryStatus = 0;
                                return true;
                            } else {
                                $this->queryStatus = 1;
                                return false;
                            }
                        } catch (Exception $e) {
                            echo $e->getMessage();
                            return false;
                        }
                    } else {
                        // password less than 8
                        $this->queryStatus = 2;
                        return false;
                    }
                } else {
                    // pass does not match
                    $this->queryStatus = 3;
                    return false;
                }
            } else {
                // user does not exist
                $this->queryStatus = 4;
                return false;
            }
        } else {
            // field are not okay
            $this->queryStatus = 5;
            return false;
        }
    }


    function startSession()
    {
        session_start();
        $_SESSION['id'] = $this->post['id_number'];
    }

    function verifyPassword()
    {
        try {
            $sql = "SELECT password FROM admin WHERE id_number = :id_number ";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute(['id_number' => $this->post['id_number']]);
            $hash = $stmt->fetchColumn();
            return  password_verify(trim($this->post['password']), $hash);
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function userExists()
    {
        // $sql = "SELECT COUNT(*) FROM admin WHERE email_address = :email_address OR phone_number = :phone_number OR id_number = :id_number";
        $sql = "SELECT COUNT(*) FROM admin WHERE id_number = :id_number";
        $stmt = $this->connection->prepare($sql);
        // $stmt->execute(['email_address' => $this->post['email_address'], 'phone_number' => $this->post['phone_number'], 'id_number' => $this->post['id_number']]);
        $stmt->execute(['id_number' => $this->post['id_number']]);
        $count = $stmt->fetchColumn();
        return $count >= 1 ? true : false;
    }

    public function selectAll()
    {
        $sql = "SELECT * FROM admin";
        $result = $this->connection->query($sql);
        $records = $result->fetchAll(PDO::FETCH_ASSOC);
        return $records;
    }

    function selectById()
    {
        $sql = "SELECT * FROM admin WHERE id = :id"; # named parameters
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
            $pdo = new PDO('sqlite:./log.db', null, null, array(PDO::ATTR_PERSISTENT => true)); // ensure permission is set 
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
            $sql = 'INSERT INTO log (id, date, time) VALUES (:id,  :date, :time)';
            $id = $this->post['id_number'];
            $stmt = $pdo->prepare($sql);
            $date = date("d-m-Y");
            $time = date("H:i:s");
            $result =  $stmt->execute(["id" => $id, "date" => $date, "time" => $time]);
            if ($result != false) {
                return true;
            }
            return $result;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
