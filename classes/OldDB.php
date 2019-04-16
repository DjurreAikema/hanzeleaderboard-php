<?php

// Using the singleton pattern
// TODO All the querying functionality should be improved cuz its shit right now
// TODO This class is getting pretty big
// TODO Have a look at how laravel does this shit for inspiration
class OldDB
{
    private static $_conn = null;
    private $_pdo, $_query, $_results, $_count = 0, $_error = false;

    // Connects to the database
    private function __construct()
    {
        try {
            //TODO Improve this code
            $this->_pdo = new PDO('mysql:host=' . OldConfig::get('mysql/host') . ';dbname=' . OldConfig::get('mysql/db') . '',
                OldConfig::get('mysql/username'),
                OldConfig::get('mysql/password'));
        } catch (PDOException $e) {
            // TODO Better error handling
            die($e->getMessage());
        }
    }

    // Returns the database connection
    public static function conn()
    {
        if (!isset(self::$_conn)) {
            self::$_conn = new OldDB();
        }
        return self::$_conn;
    }

    // Executes a query on the db
    // TODO This function is too long
    // TODO Make query more flexible
    public function query($sql, $params = array())
    {
        $this->_error = false;
        if ($this->_query = $this->_pdo->prepare($sql)) {
            $i = 1;
            if (count($params)) {
                foreach ($params as $param) {
                    $this->_query->bindValue($i, $param);
                    $i++;
                }
            }

            if ($this->_query->execute()) {
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            } else {
                $this->_error = true;
            }
        }

        return $this;
    }

    // Query with a where clause
    // TODO Make action more flexible
    public function action($action, $table, $where = array())
    {
        if (count($where) === 3) {
            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];

            $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
            if (!$this->query($sql, array($value))->error()) {
                return $this;
            }
        }
        // TODO better error handling
        return false;
    }

    // Get from table with a where clause
    // TODO Improve get functionality
    public function get($table, $where)
    {
        return $this->action('SELECT *', $table, $where);
    }

    // Delete from table with a where clause
    public function delete($table, $where)
    {
        return $this->action('DELETE', $table, $where);
    }

    // Insert into fields into specified table
    // TODO This whole function is shit
    public function insert($table, $fields = array())
    {
        $keys = array_keys($fields);
        $values = null;
        $x = 1;

        // TODO Wtf is this foreach?
        foreach ($fields as $field) {
            $values .= "?";
            if ($x < count($fields)) {
                $values .= ', ';
            }
            $x++;
        }

        $sql = "INSERT INTO {$table} (`" . implode('`, `', $keys) . "`) VALUES ({$values})";
        if (!$this->query($sql, $fields)->error()) {
            return true;
        }
        return false;
    }

    // Update specified record
    // TODO This whole function is shit
    public function update($table, $id, $fields)
    {
        $set = '';
        $x = 1;

        // TODO Wtf is this foreach?
        foreach ($fields as $name => $value) {
            $set .= "{$name} = ?";
            if ($x < count($fields)) {
                $set .= ', ';
            }
            $x++;
        }

        $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";
        if (!$this->query($sql, $fields)->error()) {
            return true;
        }
        return false;
    }

    // Return the query results
    public function results()
    {
        return $this->_results;
    }

    // Return the first query result
    public function first()
    {
        return $this->results()[0];
    }

    // Returns all errors
    public function error()
    {
        return $this->_error;
    }

    // Returns the count value
    public function count()
    {
        return $this->_count;
    }
}