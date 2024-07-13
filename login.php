<?php
session_start();

$title = 'Login';

require_once __DIR__ ."/vendor/autoload.php";
require_once __DIR__ ."/incs/db.php";
require_once __DIR__ ."/incs/functions.php";

if(check_auth() == true) {
  redirect("index.php");
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
	$data = load(['email', 'password']);
	
	$v = new \Valitron\Validator($data);
    $v->rules([
        'required' => ['email', 'password'],
        'email' => ['email'],
    ]);

    if ($v->validate()) {
        if(login($data)) {
          redirect('index.php');
        } else {
          redirect('login.php');
        }
    } else {
        $_SESSION['errors'] = get_errors($v->errors());
    }
}

require_once __DIR__ ."/views/login.tpl.php";