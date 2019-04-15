<?php

class Model extends Database
{
    public function all()
    {
        $stmt = $this->query('SELECT * FROM ' . $this->dbTable);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function get()
    {

    }

    public function where()
    {

    }

    public function first()
    {

    }

    public function insert()
    {

    }

    public function update()
    {

    }
}