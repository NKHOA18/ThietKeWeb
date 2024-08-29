$(document).ready(function() {
    const toastContainer = $('#toast-container');

    // Sự kiện xóa sản phẩm
    $('#cart-items-container').on('click', '.remove-item-cart', function(e) {
        e.preventDefault();
        var productIndex = $(this).data('product-index');

        $.ajax({
            url: 'php/removeFromCart.php',
            type: 'POST',
            dataType: 'json',
            data: { productIndex: productIndex },
            success: function(response) {
                if (response.status === 'success') {
                    // Cập nhật số lượng sản phẩm trong giỏ hàng
                    $('.cart-total').text(response.cartTotal);
                    updateCartItemCount();
                    $('.total-product').text(response.cartTotal);
                    
                    // Cập nhật tổng thành tiền
                    $('.total-not-discount').text(response.totalNotDiscount + 'đ');
                    $('.order-price-total').text(response.totalOrderPrice + 'đ');
                    
                    updateCartItems(response.cartItems);
                    // Hiển thị thông báo toast
                    showToast('Đã xóa sản phẩm khỏi giỏ hàng!');
                } else {
                    // Hiển thị thông báo lỗi
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                // Xử lý lỗi
                console.error(xhr.responseText);
            }
        });
    });

    function formatCurrency(amount) {
        return new Intl.NumberFormat('vi-VN').format(amount);
    }

    function updateCartItems(cartItems) {
        const cartItemsContainer = $('#cart-items-container');
        cartItemsContainer.empty(); // Xóa các sản phẩm hiện có trong giỏ hàng từ DOM
    
        if (cartItems.length > 0) {
            cartItems.forEach((item, index) => {
                const cartItem = `
                    <tr>
                        <td>
                            <div class="cart__product-item">
                                <div class="cart__product-item__img">
                                    <a href="productdetails.php?product_id=${item.productId}">
                                        <img src="${item.productImage}" alt="${item.productName}">
                                    </a>
                                </div>
                                <div class="cart__product-item__content">
                                    <a href="">
                                        <h3 class="cart__product-item__title">${item.productName}</h3>
                                    </a>
                                    <div class="cart__product-item__properties">
                                        <p>Màu sắc: <span>${item.productColor}</span></p>
                                        <p>Size: <span class="text-uppercase">${item.productSize}</span></p>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="cart-sale-price">
                            <p>-${formatCurrency(item.productDiscount * item.productPrice / 100)}đ</p>
                            <p class="cart-sale_item">( -${item.productDiscount}%)</p>
                        </td>
                        <td>
                            <div class="product-detail__quantity-input" data-product-sub-id="${item.productId}">
                                <input type="number" value="${item.productQuantity}" min="0" data-product-index="${index}">
                                <div class="product-detail__quantity--increase">+</div>
                                <div class="product-detail__quantity--decrease">-</div>
                            </div>
                        </td>
                        <td>
                            <div class="cart__product-item__price">${formatCurrency((item.productPrice - (item.productDiscount * item.productPrice / 100)) * item.productQuantity)}đ</div>
                        </td>
                        <td>
                            <a href="" class="remove-item-cart" data-product-index="${index}">
                                <span class="fa fa-trash" aria-hidden="true"></span>
                            </a>
                        </td>
                    </tr>`;
                cartItemsContainer.append(cartItem);
            });

        } 
    }

    function showToast(message) {
        const toastMessage = `<div class="toast toast-warning" aria-live="assertive" style="display: block;">
                                <div class="toast-message">${message}</div>
                             </div>`;

        toastContainer.html(toastMessage);
        toastContainer.show();

        // Tự động ẩn toast sau 3 giây
        setTimeout(function() {
            toastContainer.fadeOut();
        }, 3000);
    }

    // Hàm cập nhật số lượng sản phẩm trong giỏ hàng
    function updateCartItemCount() {
        $.ajax({
            type: 'GET',
            url: 'php/getCartCount.php',
            success: function(response) {
                const cartItemCount = $('.number-cart');
                const purchaseButton = $('.cart-summary__button .btn');
                const count = parseInt(response);
    
                if (count === 0) {
                    cartItemCount.hide();
                    purchaseButton.addClass('d-none');
                } else {
                    cartItemCount.show();
                    cartItemCount.text(count);
                    purchaseButton.removeClass('d-none');
                }
            },
            error: function() {
                console.error('Lỗi khi cập nhật số lượng sản phẩm trong giỏ hàng.');
            }
        });
    }

    // Initial call to update cart item count
    updateCartItemCount();

    
    $('#cart-items-container').on('click', '.product-detail__quantity--increase', function() {
        const quantityInput = $(this).prev('input[type="number"]');
        let currentValue = parseInt(quantityInput.val());
        quantityInput.val(currentValue + 1);
        updateCartItemQuantity(quantityInput);
    });

    $('#cart-items-container').on('click', '.product-detail__quantity--decrease', function() {
        const quantityInput = $(this).prev().prev('input[type="number"]');
        let currentValue = parseInt(quantityInput.val());
    
        if (currentValue > 0) {
            quantityInput.val(currentValue - 1);
            updateCartItemQuantity(quantityInput);
        }
    
        // Kiểm tra nếu giá trị hiện tại là 0 sau khi giảm
        if (currentValue === 1) {
            const productIndex = quantityInput.data('product-index');
    
            $.ajax({
                url: 'php/removeFromCart.php',
                type: 'POST',
                dataType: 'json',
                data: { productIndex: productIndex },
                success: function(response) {
                    if (response.status === 'success') {
                        // Cập nhật số lượng sản phẩm trong giỏ hàng 
                        $('.cart-total').text(response.cartTotal);                  
                        updateCartItemCount();
                        $('.total-product').text(response.cartTotal);
    
                        // Cập nhật tổng thành tiền
                        $('.total-not-discount').text(response.totalNotDiscount + 'đ');
                        $('.order-price-total').text(response.totalOrderPrice + 'đ');
    
                        updateCartItems(response.cartItems);
    
                        // Hiển thị thông báo toast
                        showToast('Đã xóa sản phẩm khỏi giỏ hàng!');
                    } else {
                        // Hiển thị thông báo lỗi
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi
                    console.error(xhr.responseText);
                }
            });
        }
    });
    

    function updateCartItemQuantity(inputElement) {
        const productIndex = $(inputElement).data('product-index'); // Get product index from inputElement
        const newQuantity = $(inputElement).val(); // Get new quantity from the input element
    
        $.ajax({
            url: 'php/updateCartItemQuantity.php',
            type: 'POST',
            dataType: 'json',
            data: { productIndex: productIndex, newQuantity: newQuantity },
            success: function(response) {
                if (response.status === 'success') {
                    // Update cart items count
                    updateCartItemCount();
    
                    // Update total not discount and order price
                    $('.total-not-discount').text(response.totalNotDiscount + 'đ');
                    $('.order-price-total').text(response.totalOrderPrice + 'đ');
    
                    // Update cart items display
                    updateCartItems(response.cartItems);
                } else {
                    // Show error message if update fails
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error('Error updating cart item quantity:', xhr.responseText);
            }
        });
    }
    


});
