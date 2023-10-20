<?php
session_start();

require 'functions.php';
require 'db.php';

$pdo = getPDO();

$email = $_POST['email'];
$password = $_POST['password'];

$user = get_user_by_email($email, $pdo);


if (!empty($user)) {

    set_flash_message('danger', 'Этот эл. адрес уже занят другим пользователем.');

   redirect_to('page_register.php');

}

add_user($email, $password, $pdo);

set_flash_message('success', 'Регистрация успешно завершена');

redirect_to('page_login.php');



