// Event listener for DOM content loaded
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const searchQuery = urlParams.get('q');
    loadCategory();
    loadProducts(searchQuery);
    updateSearchResultHeading(searchQuery);
    
    // Add event listener to the search form submit button
    document.querySelector('.search-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const searchTerm = document.getElementById('search-quick').value;
        loadProducts(searchTerm);
        updateSearchResultHeading(searchTerm);
    });
   

    function showNewArrivals() {
        const products = document.querySelectorAll('.product'); 

        products.forEach(product => {
            const creationDate = product.getAttribute('data-created'); 
            const daysSinceCreation = getDays(creationDate); 
            
            if (daysSinceCreation <= 14) {
                product.classList.remove('hidden'); 
            } else {
                product.classList.add('hidden'); 
            }
        });
    }

    // Add event listener to the "NEW ARRIVAL" link
    document.getElementById('newArrivalLink').addEventListener('click', (event) => {
        event.preventDefault(); // Prevent the default link behavior
        showNewArrivals(); // Call the function to filter new products
    });
});
// Function to update the search result heading
function updateSearchResultHeading(searchTerm) {
    const searchResultHeading = document.querySelector('.cartegory-right-top-item h3');
    if (searchTerm) {
        searchResultHeading.textContent = `Kết Quả Tìm Kiếm Theo "${searchTerm}"`;
    } else {
        searchResultHeading.textContent = 'Kết Quả Tìm Kiếm Theo';
    }
}

function getCookie(name) {
    let cookieArr = document.cookie.split(";");
    for (let i = 0; i < cookieArr.length; i++) {
        let cookiePair = cookieArr[i].split("=");
        if (name === cookiePair[0].trim()) {
            return decodeURIComponent(cookiePair[1]);
        }
    }
    return null;
}
const toastContainer = $('#toast-container');

    function showToast(message) {
        const toastMessage = `<div class="toast toast-info" aria-live="polite" style="display: block;">
                                <div class="toast-message">${message}</div>
                              </div>`;
    
        toastContainer.html(toastMessage);
        toastContainer.show();
    
        // Tự động ẩn toast sau 3 giây
        setTimeout(function() {
            toastContainer.fadeOut();
        }, 3000);
    }
// Hàm định dạng số thành tiền tệ VND
function formatCurrency(amount) {
    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
}
function addToFavorites(ma_san_pham) {
    
    // Kiểm tra cookie 'account'
    var accountCookie = getCookie('account');
    if (!accountCookie) {
        showToast('Bạn cần đăng nhập để thực hiện chức năng này!');
        return;
    }

    // Lấy action từ biểu tượng yêu thích
    const favourite = $(`.favourite[data-id="${ma_san_pham}"]`);
    const action = favourite.find('.fa').hasClass('fa-heart-o') ? 'add' : 'remove';

    // Gửi yêu cầu đến server
    $.ajax({
        type: 'POST',
        url: 'php/addToFavorites.php',
        data: { productId: ma_san_pham, action: action },
        dataType: 'json',
        success: function(response) {
            console.log('Success:', response);
            if (response.status) {
                if (action === 'add') {
                    favourite.find('.fa').removeClass('fa-heart-o').addClass('fa-heart');
                    showToast('Bạn đã thêm thành công vào danh sách yêu thích!');
                } else {
                    favourite.find('.fa').removeClass('fa-heart').addClass('fa-heart-o');
                }
            } else {
                console.error(response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

// Hàm để lấy dữ liệu yêu thích
function fetchFavorites() {
    return fetch('php/listCount.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => data.yeu_thich_counts)
        .catch(error => {
            console.error('Lỗi khi lấy dữ liệu yêu thích:', error);
            return {};
        });
}

// Hàm để lấy dữ liệu đơn hàng
function fetchOrders() {
    return fetch('php/listCount.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => data.order_counts)
        .catch(error => {
            console.error('Lỗi khi lấy dữ liệu đơn hàng:', error);
            return {};
        });
}
// Function to load products with search term
function loadProducts(productName = null) {
    let url = 'php/searchProducts.php';

    if (productName) {
        url += `?q=${productName}`;
    }

    // Sử dụng Promise.all để gọi đồng thời cả ba API
    Promise.all([fetch(url), fetchFavorites(), fetchOrders()])
        .then(responses => {
            const [productsResponse, favoritesCounts, ordersCounts] = responses;
            if (!productsResponse.ok) {
                throw new Error('Network response was not ok');
            }
            return Promise.all([productsResponse.json(), favoritesCounts, ordersCounts]);
        })
        .then(([products, favoritesCounts, ordersCounts]) => {
            const productList = document.querySelector('.list-products');
            let productHTML = '';

            // Nhóm các sản phẩm theo mã số sản phẩm (ma_so)
            const groupedProducts = products.reduce((acc, product) => {
                if (!acc[product.ma_so]) {
                    acc[product.ma_so] = [];
                }
                acc[product.ma_so].push(product);
                return acc;
            }, {});

            // Duyệt qua từng nhóm sản phẩm và tạo HTML
            Object.keys(groupedProducts).forEach(ma_so => {
                const productGroup = groupedProducts[ma_so];
                const product = productGroup[0];
                const muc_giam = parseInt(product.muc_giam) || 0;
                const gia_khuyen_mai = product.gia * (1 - muc_giam / 100);

                const usedColors = new Set();
                const usedSizes = new Set();

                const colorsHTML = productGroup.map(p => {
                    const ma_mau_sac = maColor(p.ma_mau_sac);
                    if (!usedColors.has(ma_mau_sac)) {
                        usedColors.add(ma_mau_sac);
                        return `
                            <li class="bg-light">
                                <a>
                                    <img src="assets/images/icon/0${ma_mau_sac}.png" alt="0${ma_mau_sac}" data-color="0${ma_mau_sac}" class="owl-lazy" style="opacity: 1;">
                                </a>
                            </li>
                        `;
                    }
                    return '';
                }).join('');

                const sizesHTML = productGroup.map(p => {
                    const ma_kich_co = maSize(p.ma_kich_co);
                    if (!usedSizes.has(ma_kich_co)) {
                        usedSizes.add(ma_kich_co);
                        return `
                            <li data-product-sub-id="${p.ma_kich_co}">
                                <button class="btn bt-large">${ma_kich_co}</button>
                            </li>
                        `;
                    }
                    return '';
                }).join('');

                productHTML += `
                    <div class="item-cat-product">
                        <div class="product" data-date="${product.ngay_tao}" data-status="${product.trang_thai}">
                            ${product.trang_thai == 0 ? `<div class="info-ticket ticket-news">NEW</div>` : ''}
                            ${muc_giam < 100 ? `<span class="badget badget_0${maDiscount(muc_giam)}" data-discount="${maDiscount(muc_giam)}">-${muc_giam}<span>%</span></span>` : 
                                `<span class="badget ticket-sale" data-discount="${maDiscount(muc_giam)}">${muc_giam}<span>K</span></span>`}
                            <div class="thumb-product">
                                <a href="productdetails.php?product_id=${product.ma_so}">
                                    <img src="${product.hinh_anh}" alt="${product.ten_san_pham}" class="lazy">
                                </a>
                            </div>
                            <div class="info-product">
                                <div class="list-color">
                                    <ul>
                                        ${colorsHTML}
                                    </ul>
                                    <div class="favourite" data-fav="${favoritesCounts[product.ma_so] || 0}">
                                        <i class="fa fa-heart-o"></i>
                                    </div>
                                </div>
                                <h3 class="title-product" data-id="${product.ma_so}">
                                    <a href="productdetails.php?product_id=${product.ma_so}">${product.ten_san_pham}</a>
                                </h3>
                                <div class="price-product" data_price="${gia_khuyen_mai}">
                                    <ins>
                                        <span>${formatCurrency(gia_khuyen_mai)}</span>
                                    </ins>
                                    ${muc_giam > 0 ? `<del><span>${formatCurrency(product.gia)}</span></del>` : ''}
                                </div>
                            </div>
                            <div class="add-to-cart" data-sales="${ordersCounts[product.ma_so] || 0}">
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

            const addToCartButtons = document.querySelectorAll('.add-to-cart a');
            addToCartButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const listSize = this.closest('.product').querySelector('.list-size');
                    listSize.classList.toggle('open');
                });
            });

            const favouriteIcon = document.querySelectorAll('.favourite');
            favouriteIcon.forEach(favourite => {
                favourite.addEventListener('click', function(event) {
                    event.preventDefault();
                    const productId = favourite.getAttribute('data-id');
                    addToFavorites(productId);
                });
            });
        })
        .catch(error => console.error('Lỗi khi tải sản phẩm:', error));
}



// Hàm tải danh mục sản phẩm từ server và hiển thị trên trang
function loadCategory() {
    const categoryLists = document.querySelectorAll('.category-list');

    categoryLists.forEach(list => {
        const plusIcon = list.querySelector('.fa-plus-circle');
        const minusIcon = list.querySelector('.fa-minus-circle');
        const categoryItems = list.querySelector('.category-items');
        const categoryGroup = list.getAttribute('data-category');

        plusIcon.addEventListener('click', function() {
            fetch(`admin/php/theloai.php?event=get_categories`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(categories => {
                    console.log('Fetched categories:', categories); // Log dữ liệu nhận được

                    categoryItems.innerHTML = ''; // Xóa nội dung hiện tại

                    categories.forEach(category => {
                        if (category.nhom === categoryGroup) {
                            const listItem = document.createElement('li');
                            listItem.innerHTML = `<a href="cartegory.php?category=${category.ma_so}" data-category-id="${category.ma_so}"><span>${category.ten_the_loai}</span></a>`;
                            categoryItems.appendChild(listItem);

                            // Thêm sự kiện click để load sản phẩm theo danh mục
                            listItem.querySelector('a').addEventListener('click', function(event) {
                                event.preventDefault(); // Ngăn chặn hành động mặc định của thẻ <a>
                                const categoryId = this.getAttribute('data-category-id');
                                console.log("Category ID:", categoryId); // Log để kiểm tra giá trị categoryId
                                loadProducts(categoryId);
                                window.history.pushState({}, '', `cartegory.php?category=${categoryId}`);
                                updateBreadcrumb(categoryId);
                            });
                        }
                    });

                    if (categoryItems.children.length > 0) {
                        categoryItems.style.display = 'block';
                        plusIcon.style.display = 'none';
                        minusIcon.style.display = 'inline';
                    }
                })
                .catch(error => console.error('Lỗi khi tải thể loại:', error));
        });

        minusIcon.addEventListener('click', function() {
            categoryItems.style.display = 'none';
            plusIcon.style.display = 'inline';
            minusIcon.style.display = 'none';
        });
    });
}

function updateBreadcrumb(categoryId) {
    fetch("admin/php/theloai.php?event=get_categories")
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(categories => {
            const breadcrumbList = document.querySelector('.breadcrumb__list');
            const categoryTitle = document.querySelector('.cartegory-right-top-item h3');
            breadcrumbList.innerHTML = ""; // Xóa nội dung cũ của breadcrumb trước khi cập nhật
            
            breadcrumbList.innerHTML = `
                <li class="breadcrumb__item"><a class="breadcrumb__link" href="index.html">Trang chủ</a></li>
                <li class="breadcrumb__item"><a href="cartegory.php" class="breadcrumb__link" title="Tất cả sản phẩm">Tất cả sản phẩm</a></li>
            `;
            
            if (categoryId) {
                const currentCategory = categories.find(category => category.ma_so == categoryId);
                if (currentCategory) {
                    breadcrumbList.innerHTML += `
                        <li class="breadcrumb__item"><a href="cartegory.php?category=${currentCategory.ma_so}" class="breadcrumb__link" title="${currentCategory.ten_the_loai}">${currentCategory.ten_the_loai}</a></li>
                    `;
                    categoryTitle.textContent = currentCategory.ten_the_loai; // Cập nhật tên thể loại
                } else {
                    categoryTitle.textContent = "Tất cả sản phẩm"; // Đặt tiêu đề mặc định nếu không tìm thấy danh mục
                }
            } else {
                categoryTitle.textContent = "Tất cả sản phẩm"; // Đặt tiêu đề mặc định
            }
        })
        .catch(error => {
            console.error("Lỗi khi lấy dữ liệu:", error);
            fetch("admin/php/theloai.php?event=get_categories")
                .then(response => response.text())
                .then(data => console.log("Phản hồi từ server:", data));
        });
}

$(document).ready(function() {
    // Xử lý sự kiện khi chọn một tùy chọn sắp xếp
    $('.sel-order-option').on('click', function(event) {
        event.stopPropagation(); // Ngăn chặn sự kiện click lan tỏa lên

        // Lấy giá trị và text của tùy chọn sắp xếp
        var sortText = $(this).text().trim();
        var sortValue = $(this).data('value');

        // Cập nhật UI cho phần chọn sắp xếp
        $('.hi').html('Sắp xếp theo ' + sortText + ' <i class="fa fa-chevron-down"></i>');
        $('.list-number-row').removeClass('open');

        // Đặt giá trị sắp xếp vào input hidden
        $('input[name="sel_order"]').val(sortValue);

        // Gọi hàm sắp xếp sản phẩm
        sortProducts(sortValue);
    });

    // Hàm sắp xếp sản phẩm
    function sortProducts(order) {
        var products = $('.item-cat-product .product').toArray();

        // Sắp xếp mảng sản phẩm dựa trên tiêu chí order
        products.sort(function(a, b) {
            var idA = parseInt($(a).find('.title-product').attr('data-id'), 10);
            var idB = parseInt($(b).find('.title-product').attr('data-id'), 10);
            var priceA = parseInt($(a).find('.price-product').attr('data_price').replace(/[^0-9]/g, ''), 10);
            var priceB = parseInt($(b).find('.price-product').attr('data_price').replace(/[^0-9]/g, ''), 10);
            var dateA = new Date($(a).attr('data-date'));
            var dateB = new Date($(b).attr('data-date'));
            var salesA = parseInt($(a).find('.add-to-cart').attr('data-sales'), 10);
            var salesB = parseInt($(b).find('.add-to-cart').attr('data-sales'), 10);
            var favA = parseInt($(a).find('.favourite').attr('data-fav'), 10);
            var favB = parseInt($(b).find('.favourite').attr('data-fav'), 10);

            switch (order) {
                case 'latest':
                    return dateB - dateA;
                case 'best_seller':
                    return salesB - salesA;
                case 'favourite':
                    return favB - favA;
                case 'price_desc':
                    return priceB - priceA;
                case 'price_asc':
                    return priceA - priceB;
                default:
                    // Mặc định sắp xếp theo data-id
                    return idA - idB;
            }
        });

        // Đặt lại thứ tự hiển thị của các sản phẩm
        var productContainer = $('.item-cat-product').parent();
        productContainer.empty(); // Xóa nội dung hiện tại

        // Thêm lại từng sản phẩm đã được sắp xếp vào container
        products.forEach(function(product) {
            productContainer.append($(product).parent()); // Thêm sản phẩm vào container
        });
    }
});

function formatCurrency(amount) {
    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
}

function maColor(ma_mau_sac) {
    return ma_mau_sac < 10 ? '0' + ma_mau_sac : ma_mau_sac.toString();
}
function maSize(ma_kich_co) {
    switch(ma_kich_co) {
        case "1":
            return "S";
        case "2":
            return "M";
        case "3":
            return "L";
        case "4":
            return "XL";
        case "5":
            return "XXL";
        default:
            return "S";
    }
}

function maDiscount(muc_giam) {
    if (muc_giam < 30) {
        return 1; 
    } else if (muc_giam >= 30 && muc_giam < 50) {
        return 2; 
    } else if (muc_giam >= 50 && muc_giam < 70) {
        return 3; 
    } else if (muc_giam >= 70) {
        return 4; 
    } else if (muc_giam === 299) {
        return 5; 
    } else {
        return 0; 
    }
}
function maPrice(gia_khuyen_mai) {
    if (gia_khuyen_mai > 0) {
        return 1; 
    } else if (gia_khuyen_mai > 0 && gia_khuyen_mai < 1000000) {
        return 2; 
    } else if (gia_khuyen_mai >= 1000000 && muc_giam < 2000000) {
        return 3; 
    } else if (gia_khuyen_mai >= 2000000 && muc_giam < 3000000) {
        return 4; 
    } else if (gia_khuyen_mai >= 3000000 && muc_giam < 5000000) {
        return 5; 
    } else if (gia_khuyen_mai >= 5000000 ) {
        return 4; 
    } else {
        return 0; 
    }
}

function getDays(creationDate) {
    const currentDate = new Date();
    
    const createdDate = new Date(creationDate);
    
    const differenceInMillis = currentDate - createdDate;
    
    const differenceInDays = Math.floor(differenceInMillis / (1000 * 60 * 60 * 24));
    
    return differenceInDays;
}

$(document).ready(function() {
    function updateCartItemCount() {
        $.ajax({
            type: 'GET',
            url: 'php/getCartCount.php',
            success: function(response) {
                const cartItemCount = $('.number-cart');
                const count = parseInt(response);

                if (count === 0) {
                    cartItemCount.hide();
                } else {
                    cartItemCount.show();
                    cartItemCount.text(count);
                }
            }
        });
    }

    // Initial call to update cart item count
    updateCartItemCount();
});
