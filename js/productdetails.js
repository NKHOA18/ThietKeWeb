$(document).ready(function(){
    $('#main-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '#thumbnail-slider'
    });
    $('#thumbnail-slider').slick({
            slidesToShow: 5,
            slidesToScroll: 1,
            asNavFor: '#main-slider',
            dots: false,
            centerMode: false,
            focusOnSelect: true
        });
});
$(document).ready(function(){
    // Event listener for when a size option is clicked
    $('.clicktrig').change(function(){
        // Hide all img-check images
        $('.img-check').hide();
        
        // Show img-check image of the selected radio button
        $(this).closest('.swatch-element').find('.img-check').show();
    });
});

$(document).ready(function(){
    // Increase quantity
    $('.product-detail__quantity--increase').click(function(){
        var quantityInput = $('#quantityInput');
        var currentValue = parseInt(quantityInput.val());
        var maxQuantity = parseInt(quantityInput.attr('max'));
        
        if(currentValue < maxQuantity) {
            quantityInput.val(currentValue + 1);
        }
    });
    
    // Decrease quantity
    $('.product-detail__quantity--decrease').click(function(){
        var quantityInput = $('#quantityInput');
        var currentValue = parseInt(quantityInput.val());
        
        if(currentValue > 1) {
            quantityInput.val(currentValue - 1);
        }
    });
});

$(document).ready(function(){
    $('.tab-item').click(function(){
        // Remove 'active' class from all tab items
        $('.tab-item').removeClass('active');
        
        // Add 'active' class to the clicked tab item
        $(this).addClass('active');
        
        // Hide all tab contents
        $('.tab-content').hide();
        
        // Show the corresponding tab content based on the clicked tab
        var tabIndex = $(this).index();
        $('.tab-content').eq(tabIndex).show();
    });
    $('.show-more').click(function(e){
        e.preventDefault(); // Prevent default link behavior
        
        // Toggle visibility of the tab contents
        $('.product-detail__tab-body .tab-content').toggleClass('showContent');
        
        // Toggle image display
        $('.show-more .image-down, .show-more .image-up').toggleClass('hideImg');
    });
});
$(document).ready(function() {
    const colorInputs = document.querySelectorAll('input[name="color"]');
    const selectedColorText = document.getElementById('selected-color');

    colorInputs.forEach(input => {
        input.addEventListener('change', function() {
            selectedColorText.textContent = this.value;
        });
    });
});

$(document).ready(function() {
    const notification = $('#notification');
    const toastContainer = $('#toast-container');

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

    function addToCart(event) {
        event.preventDefault();
    
        // Collect product information
        const productId = $('.product-detail__sub-info span').text();
        const productName = $('.product-detail__information h1').text();
        const productImage = $('.slick-main .product-img1 img').attr('src');
        const productColor = $('input[name="color"]:checked').val();
        const productSize = $('input[name="size"]:checked').val();
        const productDiscount = parseInt($('.product-detail__price-sale').text().replace('-', '').replace('%', '').trim());
        const productQuantity = parseInt($('#quantityInput').val());
        const productPrice = parseInt($('input[name="hid_product_price_not_format"]').val());
    
        if (!productSize) {
            // Show error message or alert the user
            showToast('Bạn chưa chọn size!');
            return;
        } else if (productSize === ' ') {
            showToast('Sản phẩm đã hết hàng Online. Bạn có thể "Tìm tại cửa hàng" !');
            return;
        }
    
        checkAttributeId(colorId(productColor), sizeId(productSize), function(productAttributeId) {
            // Send AJAX request to save product in session
            $.ajax({
                type: 'POST',
                url: 'php/addToCart.php',
                data: JSON.stringify({
                    productId: productId,
                    productAttributeId: productAttributeId,
                    productName: productName,
                    productImage: productImage,
                    productColor: productColor,
                    productSize: productSize,
                    productDiscount: productDiscount,
                    productQuantity: productQuantity,
                    productPrice: productPrice
                }),
                contentType: 'application/json',
                success: function(response) {
                    // Show success notification
                    notification.show();
    
                    // Hide notification after 2 seconds
                    setTimeout(function() {
                        notification.hide();
                    }, 2000);
    
                    // Update cart item count
                    updateCartItemCount();
    
                    // If the click event target was the purchase button, redirect to order page
                    if ($(event.target).closest('#purchase').length) {
                        window.location.href = 'order.html'; // Thay 'order_page_url' bằng URL của trang đặt hàng của bạn
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error adding to cart:', error);
                    showToast('Đã xảy ra lỗi khi thêm vào giỏ hàng. Vui lòng thử lại sau.');
                }
            });
        });
    }
    
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
    
    // Attach click event listener to add-to-cart buttons
    $('.add-to-cart-detail').on('click', addToCart);
    $('#purchase').on('click', addToCart);
    
    // Initial call to update cart item count
    updateCartItemCount();
    

    function checkAttributeId(colorId, sizeId, callback) {
        $.ajax({
            url: 'php/checkAttributeId.php',
            type: 'GET',
            dataType: 'json',
            data: {
                ma_mau_sac: colorId,
                ma_kich_co: sizeId
            },
            success: function(response) {
                if (response.exists) {
                    let ma_so = response.ma_so;
                    console.log('Mã số thuộc tính tồn tại:', ma_so);
                    callback(ma_so); // Gọi callback để truyền mã số thuộc tính vào
                } else {
                    let ma_so = 1;
                    console.log('Mã số thuộc tính không tồn tại');
                    callback(ma_so);
                }
            },
            error: function(xhr, status, error) {
                console.error('Lỗi khi kiểm tra sự tồn tại của mã số thuộc tính:', error);
            }
        });
    }
    function sizeId(ma_kich_co) {
        switch(ma_kich_co) {
            case "s":
                return "1";
            case "m":
                return "2";
            case "l":
                return "3";
            case "xl":
                return "4";
            case "xxl":
                return "5";
            default:
                return "1";
        }
    }    
    function colorId(ten_mau_sac) {
        switch(ten_mau_sac) {
            case "Trắng":
                return "1";
            case "Be":
                return "4";
            case "Cam":
                return "11";
            case "Hồng":
                return "15";
            case "Đỏ":
                return "31";
            case "Tím":
                return "33";
            case "Xanh lá":
                return "35";
            case "Xanh dương":
                return "38";
            case "Đen":
                return "49";
            case "Xám":
                return "52";
            case "Vàng":
                return "54";
            case "Nâu":
                return "64";
            default:
                return "1"; // Mặc định trả về mã cho màu Trắng nếu không tìm thấy
        }
    }
});





$(document).ready(function(){
    $('.product-list').slick({
            slidesToShow: 5,
            slidesToScroll: 1,
            arrows: false,
            autoplay: true,
            autoplaySpeed: 3000
    });
});