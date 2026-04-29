// script.js
document.addEventListener('DOMContentLoaded', () => {
    // 主页逻辑
    const productList = document.getElementById('productList');
    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.getElementById('searchBtn');
    const catButtons = document.querySelectorAll('.cat-btn');
    let currentCatId = '';
    let currentKeyword = '';

    function loadProducts() {
        if (!productList) return;
        productList.innerHTML = '<p>加载中...</p>';
        let url = 'api.php?action=products';
        if (currentCatId) url += '&cat_id=' + currentCatId;
        if (currentKeyword) url += '&keyword=' + encodeURIComponent(currentKeyword);
        fetch(url)
            .then(res => res.json())
            .then(data => {
                if (data.length === 0) {
                    productList.innerHTML = '<p>暂无产品</p>';
                    return;
                }
                productList.innerHTML = data.map(p => `
                    <div class="product-card" onclick="location.href='index.php?page=detail&id=${p.id}'">
                        <img src="${p.main_image || 'placeholder.jpg'}" alt="${p.code}" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\\'http://www.w3.org/2000/svg\\' width=\\'300\\' height=\\'200\\'%3E%3Crect width=\\'300\\' height=\\'200\\' fill=\\'%23ddd\\'/%3E%3Ctext x=\\'50%25\\' y=\\'50%25\\' dominant-baseline=\\'middle\\' text-anchor=\\'middle\\' fill=\\'%23999\\'%3E无图片%3C/text%3E%3C/svg%3E';">
                        <div class="info">
                            <h3>${p.code}</h3>
                            <p>${p.cpu} | ${p.ram} | ${p.storage}</p>
                            <p class="price">¥${p.price}</p>
                        </div>
                    </div>
                `).join('');
            })
            .catch(() => productList.innerHTML = '<p>加载失败</p>');
    }

    if (productList) {
        catButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                catButtons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                currentCatId = btn.dataset.catid;
                loadProducts();
            });
        });
        searchBtn.addEventListener('click', () => {
            currentKeyword = searchInput.value.trim();
            loadProducts();
        });
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                currentKeyword = searchInput.value.trim();
                loadProducts();
            }
        });
        // 初始加载
        loadProducts();
    }

    // 详情页逻辑
    const detailContainer = document.getElementById('detail-container');
    if (detailContainer) {
        const urlParams = new URLSearchParams(window.location.search);
        const id = urlParams.get('id');
        if (id) {
            fetch(`api.php?action=product&id=${id}`)
                .then(res => res.json())
                .then(p => {
                    detailContainer.innerHTML = `
                        <div class="main-image">
                            <img src="${p.main_image || 'placeholder.jpg'}" alt="${p.code}" onerror="this.src='data:image/svg+xml,...'">
                        </div>
                        <div class="specs">
                            <h2>${p.code}</h2>
                            <table>
                                <tr><td>编号</td><td>${p.code}</td></tr>
                                <tr><td>CPU</td><td>${p.cpu}</td></tr>
                                <tr><td>主板</td><td>${p.motherboard}</td></tr>
                                <tr><td>内存</td><td>${p.ram}</td></tr>
                                <tr><td>硬盘</td><td>${p.storage}</td></tr>
                                <tr><td>机箱</td><td>${p.case_name}</td></tr>
                                <tr><td>电源</td><td>${p.psu}</td></tr>
                                <tr><td>散热</td><td>${p.cooler}</td></tr>
                                <tr><td>备注</td><td>${p.remark || '-'}</td></tr>
                                <tr><td>价格</td><td style="color:#e74c3c; font-weight:bold;">¥${p.price}</td></tr>
                            </table>
                            <a href="index.php" class="back-link">← 返回列表</a>
                        </div>`;
                })
                .catch(() => detailContainer.innerHTML = '<p>加载失败</p>');
        } else {
            detailContainer.innerHTML = '<p>产品ID无效</p>';
        }
    }
});