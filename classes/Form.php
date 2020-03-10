<?php
require 'DB.php';

class Form
{
    private $id;
    private $nome;
    private $email;
    private $telefone;

    public function __construct($id = null)
    {
        if($id)
        {
            $this->populate(self::find($id));
        }

        return $this;
    }

    public function populate($dados)
    {
        foreach($dados as $attr => $valor)
        {
            $this->{$attr} = $valor;
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     * @return Form
     */
    public function setNome($nome)
    {
        $this->nome = trim($nome);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return Form
     */
    public function setEmail($email)
    {
        $this->email = trim($email);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * @param mixed $telefone
     * @return Form
     */
    public function setTelefone($telefone)
    {
        $this->telefone = trim($telefone);

        return $this;
    }

    public static function find($id)
    {
        $cadastro = new Form();

        $sql = <<<SQL
    SELECT * FROM cadastros WHERE id = '{$id}'
SQL;
        $dados = (new DB())->select($sql);
        if($dados)
        {
            $dados = current($dados); // pega a primeira linha do array
            $cadastro->id = $dados['id'];
            $cadastro->nome = $dados['nome'];
            $cadastro->email = $dados['email'];
            $cadastro->telefone = $dados['telefone'];
        }

        return $cadastro;
    }

    public static function all()
    {
        $sql = <<<SQL
    SELECT * FROM cadastros
SQL;
        return (new DB())->select($sql);
    }

    public function validade()
    {
        if (empty($this->nome))
        {
            throw new Exception('Nome não informado.');
        }
        if (!preg_match("/^[a-zA-Z ]*$/", $this->nome)) // regex letras maiúsculas/minúsculas e espaço em branco
        {
            throw new Exception('O Nome pode conter somente letras e espaços em branco.');
        }

        if (empty($this->email))
        {
            throw new Exception('Endereço de e-mail não informado.');
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) // validação nativa PHP
        {
            throw new Exception('O endereço de e-mail informado é inválido.');
        }

        if (empty($this->telefone))
        {
            throw new Exception('Telefone não informado.');
        }
        if (!preg_match("/^[\d\(\)\- ]*$/", $this->telefone)) // regex somente números, espaço em branco, traço e parenteses()
        {
            throw new Exception('Telefone informado inválido.');
        }

        return true;
    }

    public function save()
    {
        $this->validade();

        if(isset($this->id))
        {
            $cadastro = self::find($this->id);
            if($cadastro)
            {
                return $this->update();
            }
        }

        return $this->insert();
    }

    private function insert()
    {
        $sql = <<<SQL
    INSERT INTO cadastros(nome, email, telefone)
         VALUES ('{$this->nome}', '{$this->email}', '{$this->telefone}')
SQL;
        $id = (new DB())->insert($sql);

        return self::find($id);
    }

    private function update()
    {
        $sql = <<<SQL
         UPDATE cadastros
            SET nome = '{$this->nome}',
                email = '{$this->email}',
                telefone = '{$this->telefone}'
          WHERE id = '{$this->id}'
SQL;
        (new DB())->update($sql);

        return self::find($this->id);
    }

    private function delete()
    {
        return true;
    }
}