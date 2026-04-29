<?php
// index.php
require_once __DIR__ . '/config.php';
// 简易路由：?page=detail&id=1 显示详情，否则显示主页
$page = $_GET['page'] ?? 'home';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PC Showcase - 电脑配置展示平台</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="header">
    <div class="logo">💻 PC Showcase</div>
    <div class="search-box">
        <input type="text" id="searchInput" placeholder="搜索电脑配置...">
        <button id="searchBtn">🔍</button>
    </div>
</div>

<div class="content">
    <?php if ($page === 'detail' && $id > 0): ?>
        <!-- 详情页 -->
        <div id="detail-container" class="detail-container">
            <p>加载中...</p>
        </div>
    <?php else: ?>
        <!-- 主页 -->
        <div class="category-bar">
            <button class="cat-btn active" data-catid="">全部</button>
            <?php
            $cats = $pdo->query("SELECT id, name FROM categories ORDER BY sort ASC")->fetchAll();
            foreach ($cats as $cat) {
                echo '<button class="cat-btn" data-catid="' . $cat['id'] . '">' . htmlspecialchars($cat['name']) . '</button>';
            }
            ?>
        </div>
        <div id="productList" class="product-grid">
            <p>加载中...</p>
        </div>
    <?php endif; ?>
</div>

<footer class="footer">
    <p>© PC Showcase 开源项目 - 快速部署电脑配置展示系统</p>
</footer>

<script src="script.js"></script>
</body>
</html>