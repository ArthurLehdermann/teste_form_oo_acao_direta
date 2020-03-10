<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require '../classes/Form.php';

$cadastros = Form::all();

header('Content-Type: application/json');
echo json_encode($cadastros);