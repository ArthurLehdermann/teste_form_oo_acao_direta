<?php

class DB
{
    private $servername = 'localhost';
    private $database = 'lehderma_acaodire';
    private $username = 'lehderma_acaodire';
    private $password = '1QW23ER45T@';
    private $connection;

    public function __construct()
    {
        return $this->connect();
    }

    public function connect()
    {
        // Create connection
        $this->connection = mysqli_connect($this->servername, $this->username, $this->password, $this->database);

        // Check connection
        if(!$this->connection)
        {
            die('Falha na conexão com o banco de dados: ' . mysqli_connect_error());
        }

        return $this->connection;
    }

    public function disconnect()
    {
        mysqli_close($this->connection);
    }

    public function insert($sql)
    {
        if($this->query($sql))
        {
            $id = $this->connection->insert_id;
            $this->disconnect();
            return $id;
        }

        return false;
    }

    public function update($sql)
    {
        $result = $this->query($sql);
        $this->disconnect();
        return $result;
    }

    public function select($sql)
    {
        $result = $this->connection->query($sql);

        $error = $this->connection->connect_error;

        $this->disconnect();

        if($error)
        {
            throw new Exception('Error: ' . $sql . '' . $this->connection->connect_error);
        }

        $data = [];
        while($row = $result->fetch_assoc()){
            $data[] = $row;
        }

        return $data;
    }

    private function query($sql)
    {
        $result = $this->connection->query($sql);
        if (!$result)
        {
            throw new Exception('Error: '.$sql.''.$this->connection->connect_error);
        }

        return $result;
    }
}