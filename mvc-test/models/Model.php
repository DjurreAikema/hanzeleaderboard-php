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

    public function find()
    {

    }

    public function first()
    {

    }

    public function where()
    {

    }

    public function create()
    {

    }

    public function update()
    {

    }

    public function createOrUpdate()
    {

    }

    public function save()
    {

    }
}