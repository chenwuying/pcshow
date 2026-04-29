<?php
// config.php
// 数据库配置 - 使用 PDO 连接 MySQL
$host = '127.0.0.1';
$dbname = 'pc_showcase';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("数据库连接失败: " . $e->getMessage());
}