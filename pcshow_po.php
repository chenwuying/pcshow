<?php
// api.php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/config.php';

$action = $_GET['action'] ?? '';

try {
    switch ($action) {
        case 'categories':
            // 获取所有分类
            $stmt = $pdo->query("SELECT id, name FROM categories ORDER BY sort ASC");
            echo json_encode($stmt->fetchAll());
            break;

        case 'products':
            // 产品列表，支持分类和搜索
            $cat_id = $_GET['cat_id'] ?? '';
            $keyword = $_GET['keyword'] ?? '';
            $sql = "SELECT p.id, p.code, p.cpu, p.motherboard, p.ram, p.storage, p.price, p.main_image, c.name AS category_name 
                    FROM products p JOIN categories c ON p.category_id = c.id WHERE 1=1";
            $params = [];
            if ($cat_id !== '') {
                $sql .= " AND p.category_id = ?";
                $params[] = (int)$cat_id;
            }
            if ($keyword !== '') {
                $sql .= " AND (p.code LIKE ? OR p.cpu LIKE ? OR p.motherboard LIKE ? OR p.ram LIKE ? OR p.storage LIKE ? OR p.case_name LIKE ? OR p.remark LIKE ?)";
                $like = "%$keyword%";
                $params = array_merge($params, [$like, $like, $like, $like, $like, $like, $like]);
            }
            $sql .= " ORDER BY p.created_at DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            echo json_encode($stmt->fetchAll());
            break;

        case 'product':
            // 单个产品详情
            $id = $_GET['id'] ?? 0;
            $stmt = $pdo->prepare("SELECT p.*, c.name AS category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.id = ?");
            $stmt->execute([(int)$id]);
            $product = $stmt->fetch();
            if ($product) {
                echo json_encode($product);
            } else {
                http_response_code(404);
                echo json_encode(['error' => '产品不存在']);
            }
            break;

        default:
            http_response_code(400);
            echo json_encode(['error' => '未知操作']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => '服务器错误']);
}