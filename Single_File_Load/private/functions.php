<?php

class Database
{
    private function connect()
    {
        //connect to database
        // Old Method
        // if (!$con = mysqli_connect("localhost", "root", "", "security_db")) {
        //     die("could not connect to the database");
        // }

        //Prepared Statements
        //PDO php data object
        try {
            $string = "mysql:host=localhost;dbname=security_db";
            $con = new PDO($string, "root", "");
        } catch (PDOException $e) {
            if ($_SERVER['HTTP_HOST'] == "localhost") {
                die($e->getMessage());
            } else {
                die("Could not connect to the database");
            }
        }
        return $con;
    }

    public function db_read($query, $data = array())
    {
        $con = $this->connect();
        $stmt = $con->prepare($query);

        //get posts
        if ($stmt) {

            // PDO
            $check = $stmt->execute($data);
            if ($check) {
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (is_array($result) && count($result) > 0) {
                    return $result;
                }
            }
        }
        return false;

        //SQL
        // $result = mysqli_query($con, $query);

        // if ($result && mysqli_num_rows($result) > 0) {
        //     $data[] = array();

        //     while ($row = mysqli_fetch_assoc($result)) {
        //         $data[] = $row;
        //     }
        //     return $data;
        // }
        // return false;

    }

    public function db_write($query, $data = array())
    {
        $con = $this->connect();
        $stmt = $con->prepare($query);

        //get posts
        if ($stmt) {
            // PDO
            $check = $stmt->execute($data);
            if ($check) {
                return $result;
            }
        }
        return false;
    }
}

class Posts extends Database
{
    public function get_home_posts()
    {
        //get posts
        $query = "select * from posts order by id desc";
        $result = $this->db_read($query);

        return $result;
    }

    //Validation for SQL GEt Injection
    public function get_one_post($id)
    {
        //get posts
        $id = (int)$id;
        $id = addslashes($id);
        $arr = array();
        $arr['id'] = (int)$id;
        $query = "select * from posts where id = :id limit 1";

        $result = $this->db_read($query, $arr);

        return $result;
    }
}

class User extends Database
{
    public function login($POST)
    {

        if (count($POST) > 0) {
            $Error = "";

            //validate
            //email
            if (!filter_var($POST['email'], FILTER_VALIDATE_EMAIL)) {
                $Error = "wrong email";
            }

            //password
            if (empty($POST['password'])) {
                $Error = "wrong password";
            }


            if ($Error == "") {
                $arr = array();
                $arr['email']    = addslashes($POST['email']);
                $arr['password']    = addslashes($POST['password']);

                //get user
                $query = "select * from users where email = :email && password = :password ";
                $result = $this->db_read($query, $arr);
                if ($result) {
                    $row = $result[0];

                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['user_rank'] = $row['rank'];

                    return "";
                } else {
                    $Error = "Wrong email or password";
                }
            }

            return $Error;
        }
    }

    public function get_one_user($id)
    {
        //get posts
        $id = (int)$id;
        $id = addslashes($id);
        $arr = array();
        $arr['id'] = (int)$id;
        $query = "select * from users where id = :id limit 1";

        $result = $this->db_read($query, $arr);

        return $result;
    }
}

function access($need_rank)
{
    $user_rank = isset($_SESSION['user_rank']) ? $_SESSION['user_rank'] : "";

    switch ($need_rank) {
        case 'admin':
            $allowed[] = "editor";
            $allowed[] = "user";

            return (in_array($user_rank, $allowed));
            break;
        case 'editor':
            $allowed[] = "editor";
            $allowed[] = "user";

            return (in_array($user_rank, $allowed));
            break;
        case 'user':
            $allowed[] = "admin";
            $allowed[] = "editor";
            $allowed[] = "user";

            return (in_array($user_rank, $allowed));
            break;
        default:
            break;
    }

    return false;
}
