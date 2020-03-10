<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

if(!isset($_POST) || empty($_POST))
{
    header('Location: index.html');
}

require 'classes/Form.php';

session_start();

try
{
    $cadastro = (new Form())
        ->setNome($_POST['nome'])
        ->setEmail($_POST['email'])
        ->setTelefone($_POST['telefone'])
        ->save();

    $_SESSION['messages']['success'] = 'Dados enviados com sucesso!';
    header('Location: index.php');
}
catch( Exception $exception)
{
    $_SESSION['messages']['danger'] = $exception->getMessage();
    $_SESSION['old'] = $_POST;
    header('Location: index.php');
}