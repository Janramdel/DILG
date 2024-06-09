<?php

require_once("config.php");

class Database
{
    private $conn;
    private $error_no = 0;
    private $error_msg = '';
    private $magic_quotes_active;
    private $real_escape_string_exists;

    public function __construct()
    {
        $this->open_connection();
        $this->magic_quotes_active = get_magic_quotes_gpc();
        $this->real_escape_string_exists = function_exists("mysqli_real_escape_string");
    }

    public function open_connection()
    {
        $this->conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function setQuery($sql = '')
    {
        $this->sql_string = $sql;
    }

    public function executeQuery()
    {
        $result = $this->conn->query($this->sql_string);
        $this->confirm_query($result);
        return $result;
    }

    private function confirm_query($result)
    {
        if (!$result) {
            $this->error_no = $this->conn->errno;
            $this->error_msg = $this->conn->error;
            die("Query failed: " . $this->error_msg);
        }
    }

    function loadResultList($key = '')
    {
        $cur = $this->executeQuery();

        $array = array();
        while ($row = $cur->fetch_object()) {
            if ($key) {
                $array[$row->$key] = $row;
            } else {
                $array[] = $row;
            }
        }
        $cur->free_result();
        return $array;
    }

    function loadSingleResult()
    {
        $cur = $this->executeQuery();

        while ($row = $cur->fetch_object()) {
            $data = $row;
        }
        $cur->free_result();
        return $data;
    }

    function getFieldsOnOneTable($tbl_name)
    {
        $this->setQuery("DESC " . $tbl_name);
        $rows = $this->loadResultList();

        $f = array();
        foreach ($rows as $row) {
            $f[] = $row->Field;
        }

        return $f;
    }

    public function fetch_array($result)
    {
        return $result->fetch_array();
    }

    //gets the number of rows
    public function num_rows($result_set)
    {
        return $result_set->num_rows;
    }

    public function insert_id()
    {
        // get the last id inserted over the current db connection
        return $this->conn->insert_id;
    }

    public function affected_rows()
    {
        return $this->conn->affected_rows;
    }

    public function escape_value($value)
    {
        if ($this->real_escape_string_exists) { // PHP v4.3.0 or higher
            // undo any magic quote effects so mysqli_real_escape_string can do the work
            if ($this->magic_quotes_active) {
                $value = stripslashes($value);
            }
            $value = $this->conn->real_escape_string($value);
        } else { // before PHP v4.3.0
            // if magic quotes aren't already on then add slashes manually
            if (!$this->magic_quotes_active) {
                $value = addslashes($value);
            }
            // if magic quotes are active, then the slashes already exist
        }
        return $value;
    }

    public function close_connection()
    {
        if (isset($this->conn)) {
            $this->conn->close();
            unset($this->conn);
        }
    }
}

$mydb = new Database();
?>
