<?php
session_start();

require 'functions.php';

$email = $_POST['email'];
$password = $_POST['password'];

$result = login($email, $password);

if($result) {
    redirect_to('/users.php');
} else {
    set_flash_message('danger', 'Пользователь не найден или пароль неверный');
    redirect_to('/page_login.php');
}



