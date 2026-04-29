-- database.sql
-- 创建数据库
CREATE DATABASE IF NOT EXISTS pc_showcase DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pc_showcase;

-- 分类表
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    sort INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 产品表
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    code VARCHAR(50) NOT NULL,
    cpu VARCHAR(100) NOT NULL,
    motherboard VARCHAR(100) NOT NULL,
    ram VARCHAR(100) NOT NULL,
    storage VARCHAR(100) NOT NULL,
    case_name VARCHAR(100) NOT NULL,
    psu VARCHAR(100) NOT NULL,
    cooler VARCHAR(100) NOT NULL,
    remark TEXT,
    price DECIMAL(10,2) NOT NULL,
    main_image VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 初始分类数据
INSERT INTO categories (name, sort) VALUES
('显卡', 1),
('显示器', 2),
('硬盘', 3),
('内存', 4),
('外设', 5);

-- 初始产品数据（示例）
INSERT INTO products (category_id, code, cpu, motherboard, ram, storage, case_name, psu, cooler, remark, price, main_image) VALUES
(1, 'PC-001', 'Intel i5-13400F', 'B760M', '16GB DDR5', '1TB NVMe', '侧透中塔', '650W金牌', '风冷', '主流游戏配置', 6599.00, 'uploads/pc1.jpg'),
(2, 'PC-002', 'AMD R5 7600', 'A620M', '32GB DDR5', '2TB NVMe', '白色海景房', '750W金牌', '240水冷', '高颜值办公娱乐', 7999.00, 'uploads/pc2.jpg'),
(3, 'PC-003', 'Intel i9-13900K', 'Z790', '64GB DDR5', '4TB NVMe', '全塔静音', '1000W白金', '360水冷', '顶级生产力', 15999.00, NULL);