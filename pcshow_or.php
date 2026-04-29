<?php
// admin-actions.php
require_once __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('仅支持POST请求');
}

$type = $_POST['type'] ?? '';

if ($type === 'add_category') {
    $name = trim($_POST['name'] ?? '');
    if ($name === '') {
        exit('分类名称不能为空');
    }
    $stmt = $pdo->prepare("INSERT INTO categories (name, sort) VALUES (?, 0)");
    $stmt->execute([$name]);
    header('Location: admin.php?success=1');
    exit;
}

if ($type === 'add_product') {
    $category_id = (int)($_POST['category_id'] ?? 0);
    $code = trim($_POST['code'] ?? '');
    $cpu = trim($_POST['cpu'] ?? '');
    $motherboard = trim($_POST['motherboard'] ?? '');
    $ram = trim($_POST['ram'] ?? '');
    $storage = trim($_POST['storage'] ?? '');
    $case_name = trim($_POST['case_name'] ?? '');
    $psu = trim($_POST['psu'] ?? '');
    $cooler = trim($_POST['cooler'] ?? '');
    $remark = trim($_POST['remark'] ?? '');
    $price = (float)($_POST['price'] ?? 0);
    $main_image = '';

    // 处理图片上传
    if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $ext = pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION);
        $filename = uniqid('pc_') . '.' . $ext;
        $destination = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['main_image']['tmp_name'], $destination)) {
            $main_image = 'uploads/' . $filename;
        }
    }

    $stmt = $pdo->prepare("INSERT INTO products (category_id, code, cpu, motherboard, ram, storage, case_name, psu, cooler, remark, price, main_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$category_id, $code, $cpu, $motherboard, $ram, $storage, $case_name, $psu, $cooler, $remark, $price, $main_image]);
    header('Location: admin.php?success=1');
    exit;
}

http_response_code(400);
echo '无效请求';