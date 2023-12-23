<?php
include_once '../db.php';
header('Content-Type: application/json');

$login = trim($_POST['login'] ?? '');
$password = trim($_POST['password'] ?? '');

if (empty($login) || empty($password) || !preg_match('/^[a-zA-Z0-9]+$/', $login) || !preg_match('/^[a-zA-Z0-9]+$/', $password)) {
    echo json_encode(['success' => false, 'error' => 'Неверно заполены поля.']);
    exit;
}

$isLogined = loginUser($login, $password);

if (!$isLogined) {
    echo json_encode(['success' => false, 'error' => 'Неправильный логин или пароль.']);
    exit;
}

echo json_encode(['success' => true]);
