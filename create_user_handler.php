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
$status = $_POST['status'];
$vk = $_POST['vk'];
$telegram = $_POST['telegram'];
$instagram = $_POST['instagram'];

$data = [
    ':username' => $username,
    ':job_title' => $job,
    ':phone' => $phone,
    ':address' => $address,
    ':status' => $status,
    ':vk' => $vk,
    ':telegram' => $telegram,
    ':instagram' => $instagram,
];

$user = get_user_by_email($email, $pdo);

if (!empty($user)) {
    set_flash_message('danger', 'Этот эл. адрес уже занят другим пользователем.');
    redirect_to('create_user.php');
}

$user_id = add_user($email, $password, $pdo);

edit_user($data, $user_id, $pdo);

$fileName = uploadImage($_FILES['image']);

upload_avatar($fileName, $user_id, $pdo);

set_flash_message('success', 'Пользователь успешно добавлен!');

redirect_to('/users.php');


