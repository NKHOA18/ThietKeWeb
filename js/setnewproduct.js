
    function loadProducts(group) {
        fetch('php/getProducts.php')
            .then(response => response.json())
            .then(data => {
                let products = [];
                if (group === 'women') {
                    products = data.women;
                } else if (group === 'men') {
                    products = data.men;
                } else if (group === 'kids') {
                    products = data.kids;
                }

                const productList = document.querySelector(`#tab-${group} .list-products`);
                let productHTML = ''; // Biến tích lũy HTML của sản phẩm

                if (!products.length) {
                    productList.innerHTML = "<p>Không có sản phẩm</p>";
                    return;
                }

                products.forEach(product => {
                    const muc_giam = parseInt(product.muc_giam) || 0;
                    const gia_khuyen_mai = product.gia * (1 - muc_giam / 100);

                    // Set để lưu trữ các mã màu và kích cỡ đã sử dụng
                    const usedColors = new Set();
                    const usedSizes = new Set();

                    // Tạo danh sách màu sắc
                    const colorsHTML = products.map(p => {
                        const ma_mau_sac = maColor(p.ma_mau_sac);
                        if (!usedColors.has(ma_mau_sac)) {
                            usedColors.add(ma_mau_sac);
                            return `
                                <li>
                                    <a>
                                        <img src="assets/images/icon/0${ma_mau_sac}.png" alt="0${ma_mau_sac}" data-color="0${ma_mau_sac}" class="owl-lazy" style="opacity: 1;">
                                    </a>
                                </li>
                            `;
                        }
                        return ''; // Trả về chuỗi rỗng nếu mã màu đã có trong Set
                    }).join('');

                    // Tạo danh sách kích thước
                    const sizesHTML = products.map(p => {
                        const ma_kich_co = maSize(p.ma_kich_co);
                        if (!usedSizes.has(ma_kich_co)) {
                            usedSizes.add(ma_kich_co);
                            return `
                                <li data-product-sub-id="${p.ma_kich_co}">
                                    <button class="btn bt-large">${ma_kich_co}</button>
                                </li>
                            `;
                        }
                        return ''; // Trả về chuỗi rỗng nếu mã kích cỡ đã có trong Set
                    }).join('');

                    // Tạo HTML cho từng sản phẩm
                    productHTML += `
                        <div class="item-new-product">
                            <div class="product">
                                ${muc_giam > 0 ? `<span class="badget badget_0${maDiscount(muc_giam)}">-${muc_giam}%</span>` : ''}
                                <div class="thumb-product">
                                    <a href="/nkstore/productdetails.php?product_id=${product.ma_so}">
                                        <img src="/nkstore/${product.hinh_anh}" alt="${product.ten_san_pham}" class="lazy">
                                    </a>
                                </div>
                                <div class="info-product">
                                    <div class="list-color">
                                        <ul>
                                            ${colorsHTML}
                                        </ul>
                                        <div class="favourite" data-id="${product.ma_so}">
                                            <i class="fa fa-heart"></i>
                                        </div>
                                    </div>
                                    <h3 class="title-product">
                                        <a href="/nkstore/productdetails.php?product_id=${product.ma_so}">${product.ten_san_pham}</a>
                                    </h3>
                                    <div class="price-product">
                                        <ins><span>${gia_khuyen_mai.toLocaleString()}₫</span></ins>
                                        ${muc_giam > 0 ? `<del><span>${product.gia.toLocaleString()}₫</span></del>` : ''}
                                    </div>
                                </div>
                                <div class="add-to-cart">
                                    <a href="javascript:void(0)"><i class="fa fa-shopping-bag"></i></a>
                                </div>
                                <div class="list-size">
                                    <ul>
                                        ${sizesHTML}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    `;
                });

                productList.innerHTML = productHTML;
            })
            .catch(error => {
                console.error('There has been a problem with your fetch operation:', error);
            });
    }

    // Gọi hàm load sản phẩm khi trang được tải
    document.addEventListener('DOMContentLoaded', () => {
        loadProducts('women'); // Load sản phẩm mặc định cho nhóm "women"
    });

    // Gọi hàm load sản phẩm khi click vào các tab khác
    document.querySelectorAll('.tabs').forEach(tab => {
        tab.addEventListener('click', (e) => {
            const group = e.target.dataset.categoryId;
            document.querySelector('.tabs.active').classList.remove('active');
            e.target.classList.add('active');

            // Ẩn tất cả các tab
            document.querySelectorAll('.exclusive-inner').forEach(inner => inner.style.display = 'none');

            // Hiển thị tab được chọn
            document.querySelector(`#tab-${group}`).style.display = 'block';

            loadProducts(group);
        });
    });

