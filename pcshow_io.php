<?php
// admin.php
require_once __DIR__ . '/config.php';
// 简单保护：实际使用请添加密码验证
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>管理后台 - PC Showcase</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-container { max-width: 800px; margin: 40px auto; padding: 30px; background: white; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .admin-form { margin-bottom: 40px; }
        .admin-form h2 { border-bottom: 2px solid #007bff; padding-bottom: 8px; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 4px; font-weight: 600; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 8px 12px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; }
        .form-group textarea { height: 80px; }
        .btn { background: #007bff; color: white; padding: 10px 24px; border: none; border-radius: 6px; cursor: pointer; font-size: 16px; }
        .btn:hover { background: #0056b3; }
        .success-msg { background: #d4edda; color: #155724; padding: 12px; border-radius: 6px; margin-bottom: 20px; }
    </style>
</head>
<body>
<div class="admin-container">
    <h1>PC Showcase 管理后台</h1>
    <p><a href="index.php">← 返回前台</a></p>
    <?php if (isset($_GET['success'])): ?>
        <div class="success-msg">操作成功！</div>
    <?php endif; ?>

    <!-- 添加分类 -->
    <div class="admin-form">
        <h2>添加分类</h2>
        <form action="admin-actions.php" method="post">
            <input type="hidden" name="type" value="add_category">
            <div class="form-group">
                <label>分类名称</label>
                <input type="text" name="name" required>
            </div>
            <button type="submit" class="btn">添加分类</button>
        </form>
    </div>

    <!-- 添加产品 -->
    <div class="admin-form">
        <h2>添加电脑配置</h2>
        <form action="admin-actions.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="type" value="add_product">
            <div class="form-group">
                <label>所属分类</label>
                <select name="category_id" required>
                    <option value="">请选择分类</option>
                    <?php
                    $cats = $pdo->query("SELECT id, name FROM categories ORDER BY sort ASC")->fetchAll();
                    foreach ($cats as $cat) {
                        echo "<option value='{$cat['id']}'>{$cat['name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group"><label>编号</label><input type="text" name="code" required></div>
            <div class="form-group"><label>CPU</label><input type="text" name="cpu" required></div>
            <div class="form-group"><label>主板</label><input type="text" name="motherboard" required></div>
            <div class="form-group"><label>内存</label><input type="text" name="ram" required></div>
            <div class="form-group"><label>硬盘</label><input type="text" name="storage" required></div>
            <div class="form-group"><label>机箱</label><input type="text" name="case_name" required></div>
            <div class="form-group"><label>电源</label><input type="text" name="psu" required></div>
            <div class="form-group"><label>散热</label><input type="text" name="cooler" required></div>
            <div class="form-group"><label>备注</label><textarea name="remark"></textarea></div>
            <div class="form-group"><label>价格 (元)</label><input type="number" name="price" step="0.01" required></div>
            <div class="form-group"><label>外观主图</label><input type="file" name="main_image" accept="image/*"></div>
            <button type="submit" class="btn">添加配置</button>
        </form>
    </div>
</div>
</body>
</html>