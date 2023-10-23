<?php
session_start();

require 'functions.php';
require 'db.php';

$pdo = getPDO();

$email = $_POST['email'];
$password = $_POST['password'];

$username = $_POST['username'];
$job = $_POST['job'];
$phone = $_POST['phone'];
$address = $_POST['address'];

$user_id =  $_SESSION['user']['id'];

$user = get_user_by_id($user_id, $pdo);


edit_user($username, $job, $phone, $address, $user_id, $pdo);

set_flash_message('success', 'Профиль успешно обновлен!');

redirect_to('/edit.php');


