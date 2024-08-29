$(document).ready(function() {
    // Xử lý sự kiện submit form tìm kiếm
    $('#search-button').on('click', function() {
        var searchTerm = $('#search-input').val().trim().toLowerCase();

        // Lọc sản phẩm dựa trên giá trị nhập vào
        $('.item-cat-product .product').each(function() {
            var productName = $(this).find('.title-product a').text().trim().toLowerCase();

            // Kiểm tra xem tên sản phẩm có chứa từ khóa tìm kiếm hay không
            if (productName.includes(searchTerm)) {
                $(this).closest('.item-cat-product').show(); // Hiển thị sản phẩm nếu tìm thấy
            } else {
                $(this).closest('.item-cat-product').hide(); // Ẩn sản phẩm nếu không tìm thấy
            }
        });
    });

    // Xử lý sự kiện khi nhấn Enter trong input tìm kiếm
    $('#search-input').on('keyup', function(event) {
        if (event.keyCode === 13) { // Kiểm tra phím Enter
            $('#search-button').click(); // Gọi sự kiện click của nút tìm kiếm
        }
    });

    // Toggle dropdown sắp xếp khi nhấn vào nút hoặc chữ "Sắp xếp theo"
    $('.fa-chevron-down, .hi').on('click', function(event) {
        event.stopPropagation(); // Ngăn chặn sự kiện click lan tỏa lên
        $('.list-number-row').toggleClass('open');
    });

   

    // Đóng dropdown nếu click bất kỳ nơi nào ngoài dropdown
    $(document).on('click', function() {
        $('.list-number-row').removeClass('open');
    });

    // Lấy tham chiếu đến các nút "Lọc" và "Bỏ lọc"
    const filterButton = document.querySelector('.but_filter_product');
    const resetButton = document.querySelector('.but_filter_remove');
    const sizeInputs = document.querySelectorAll('input[name="att_size[]"]');
    const colorInputs = document.querySelectorAll('input[name="att_color[]"]');
    const discountInputs = document.querySelectorAll('input[name="att_discount"]');
    const priceInputs = document.querySelectorAll('input[name="att_price"]');

    // Hàm lấy giá trị của các bộ lọc
    function getFilterValues() {
        const size = document.querySelector('input[name="att_size[]"]:checked')?.value || '';
        const color = document.querySelector('input[name="att_color[]"]:checked')?.value || '';
        const discount = document.querySelector('input[name="att_discount"]:checked')?.value || '';
        const price = Array.from(document.querySelectorAll('input[name="att_price"]:checked')).map(input => input.value);

        return { size, color, discount, price };
    }

    // Hàm lọc sản phẩm
    function filterProducts() {
        const filters = getFilterValues();
    
        // Lấy danh sách sản phẩm hiện tại
        const products = document.querySelectorAll('.item-cat-product .product');
    
        products.forEach(product => {
            let isVisible = true;
    
            const productSizes = Array.from(product.querySelectorAll('.list-size .btn.bt-large')).map(sizeBtn => sizeBtn.textContent.trim().toLowerCase());
            const productColors = Array.from(product.querySelectorAll('.list-color img')).map(colorImg => colorImg.getAttribute('data-color'));
            const productDiscount = product.querySelector('.badget')?.getAttribute('data-discount') || '';
            const productPrice = product.querySelector('.price-product').getAttribute('data_price').replace(/[^0-9]/g, '');
    
            // Kiểm tra từng tiêu chí lọc
            if (filters.size && !productSizes.includes(filters.size)) {
                isVisible = false;
            }
    
            if (filters.color && !productColors.includes(filters.color)) {
                isVisible = false;
            }
    
            if (filters.discount && productDiscount !== filters.discount) {
                isVisible = false;
            }
    
            // Kiểm tra lọc theo giá
            if (filters.price.length > 0) {
                const price = parseInt(productPrice, 10);
    
                if (filters.price.includes('2') && (price < 0 || price > 1000000)) {
                    isVisible = false;
                }
                if (filters.price.includes('3') && (price < 1000000 || price > 2000000)) {
                    isVisible = false;
                }
                if (filters.price.includes('4') && (price < 2000000 || price > 3000000)) {
                    isVisible = false;
                }
                if (filters.price.includes('5') && (price < 3000000 || price > 5000000)) {
                    isVisible = false;
                }
                if (filters.price.includes('6') && price <= 5000000) {
                    isVisible = false;
                }
            }
    
            // Hiển thị hoặc ẩn sản phẩm
            if (isVisible) {
                product.parentElement.style.display = 'block';
            } else {
                product.parentElement.style.display = 'none';
            }
        });
    }

    // Hàm xử lý sự kiện khi nhấn nút "Bỏ lọc"
    function handleResetFilters() {
        // Đặt lại tất cả các input về trạng thái không chọn
        sizeInputs.forEach(input => input.checked = false);
        colorInputs.forEach(input => {
            input.checked = false;
            input.closest('.item-sub-list').querySelector('.item-sub-pr').classList.remove('active'); // Xóa lớp active của label cha
        });
        discountInputs.forEach(input => {
            input.checked = false;
            input.closest('.item-sub-list').querySelector('.item-sub-pr').classList.remove('active'); // Xóa lớp active của span trong label cha
        });
        priceInputs.forEach(input => input.checked = false); // Đặt lại giá trị của input giá về rỗng
    }

    // Thêm sự kiện cho nút "Lọc"
    filterButton.addEventListener('click', function() {
        filterProducts();
    });

    // Thêm sự kiện lắng nghe cho nút "Bỏ lọc"
    resetButton.addEventListener('click', function() {
        handleResetFilters();
        filterProducts();
    });

    // Thêm sự kiện cho các bộ lọc để tự động lọc khi thay đổi giá trị
    document.querySelectorAll('.field-cat, .le-readio').forEach(input => {
        input.addEventListener('change', function() {
            filterProducts();
        });
    });

    // Sử dụng Array.from để chuyển NodeList thành mảng
var checkboxes = Array.from(document.querySelectorAll('.le-readio'));

checkboxes.forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        if (this.checked) {
            // Loại bỏ chọn tất cả các checkbox khác
            checkboxes.forEach(function(otherCheckbox) {
                if (otherCheckbox !== checkbox) {
                    otherCheckbox.checked = false;
                }
            });
        }
    });
});

    
});




