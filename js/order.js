$(document).ready(function() {
    function formatCurrency(amount) {
        return new Intl.NumberFormat('vi-VN').format(amount) + 'đ';
    }

    function loadCartData() {
        $.ajax({
            url: 'php/getCartData.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    const cartItems = response.cartItems;
                    const totalNotDiscount = response.totalNotDiscount;
                    const totalOrderPrice = response.totalOrderPrice;

                    updateCartItems(cartItems);
                    updateOrderSummary(totalNotDiscount, totalOrderPrice);
                } else {
                    console.error(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Lỗi khi lấy dữ liệu giỏ hàng:', xhr.responseText);
            }
        });
    }

    function loadUserInfo() {

        $.ajax({
            url: 'php/getUserInfo.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    const user = response.data;
                    $('.buttons').addClass('d-none');
                    $('.ds__item__contact-info').attr('value', user.user_id);
                    $('input[name="customer_display_name"]').val(user.user_firstname +" "+ user.user_name).prop('disabled', true);
                    $('input[name="customer_phone"]').val(user.user_phone).prop('disabled', true);
                    $('input[name="customer_address"]').val(user.user_address).prop('disabled', true);
                } else {
                    console.error('Lỗi: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Lỗi khi gửi yêu cầu: ' + xhr.responseText);
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

    function updateCartItems(cartItems) {
        const cartItemsContainer = $('.cart__table tbody');
        cartItemsContainer.empty();
    
        cartItems.forEach((item) => {
            const discountPrice = item.productPrice * (item.productDiscount / 100);
            const finalPrice = (item.productPrice - discountPrice) * item.productQuantity;
    
            // Thực hiện Ajax để kiểm tra sự tồn tại của mã số thuộc tính
            checkAttributeId(colorId(item.productColor), sizeId(item.productSize), function(ma_so) {
                // Tạo các mục cho giỏ hàng
                const cartItem = `
                    <tr>
                        <td>
                            <div class="cart__product-item" data-id="${item.productAttributeId}">
                                <div class="cart__product-item__img">
                                    <a href="productdetails.php?product_id=${item.productId}">
                                        <img src="${item.productImage}" alt="${item.productName}">
                                    </a>
                                </div>
                                <div class="cart__product-item__content">
                                    <a href="productdetails.php?product_id=${item.productId}">
                                        <h3 class="cart__product-item__title">${item.productName}</h3>
                                    </a>
                                    <div class="cart__product-item__properties">
                                        <p>Màu sắc: <span>${item.productColor}</span></p>
                                        <p>Size: <span>${item.productSize}</span></p>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="cart-sale-price">
                            <p>${formatCurrency(discountPrice)}</p>
                            <p class="cart-sale_item">(-${item.productDiscount}%)</p>
                        </td>
                        <td>
                            <div class="product-detail__quantity-input">
                                <input type="number" value="${item.productQuantity}" disabled readonly>
                            </div>
                        </td>
                        <td>
                            <div class="cart__product-item__price">${formatCurrency(finalPrice)}</div>
                        </td>
                    </tr>`;
                cartItemsContainer.append(cartItem);
            });
        });
    }
    
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
    function updateOrderSummary(totalNotDiscount, totalOrderPrice) {
        const shippingFee = 50000;
        const totalPayment = totalOrderPrice + shippingFee;

        $('.cart-summary__overview__item:nth-child(2) p:nth-child(2)').text(formatCurrency(totalNotDiscount));
        $('.cart-summary__overview__item:nth-child(3) p:nth-child(2)').text(formatCurrency(totalOrderPrice));
        $('.cart-summary__overview__item:nth-child(4) p:nth-child(2)').text(formatCurrency(shippingFee));
        $('.cart-summary__overview__item:nth-child(5) p:nth-child(2)').text(formatCurrency(totalPayment));
    }

    loadCartData();
    loadUserInfo();

    $('input[name="payment_method"]').change(function() {
        if ($('#payment_method_3').is(':checked')) {
            $('#momoButton').show();
            $('#moneyButton').hide();
            $('#atmButton').hide();
        } else if ($('#payment_method_2').is(':checked')) {
            $('#atmButton').show();
            $('#moneyButton').hide();
            $('#momoButton').hide();
        } else if ($('#payment_method_4').is(':checked')) {
            $('#moneyButton').show();
            $('#momoButton').hide();
            $('#atmButton').hide();
        } else {
            $('#momoButton').hide();
            $('#atmButton').hide();
            $('#moneyButton').hide();
        }
    });
    function gatherCartItems() {
        var cartItems = [];
        $('#cart-items tr').each(function() {
            var productName = $(this).find('.cart__product-item__title').text().trim();
            var discount = $(this).find('.cart-sale-price p').first().text().trim();
            var quantity = $(this).find('.product-detail__quantity-input input').val();
            var totalPrice = $(this).find('.cart__product-item__price').text().trim();

            var item = {
                name: productName,
                discount: discount,
                quantity: quantity,
                totalPrice: totalPrice
            };
            cartItems.push(item);
        });

        return cartItems;
    }

    // Update hidden input fields before form submission
    $('#paymentForm').submit(function(event) {
        var cartItems = gatherCartItems();
        var totalPrice = $('#totalPrice').text().trim();
        var subtotalPrice = $('#subtotalPrice').text().trim();
        var totalPayment = $('#totalPayment').text().trim();

        $('#cartItems').val(JSON.stringify(cartItems));
        $('#hiddenTotalPrice').val(totalPrice);
        $('#hiddenSubtotalPrice').val(subtotalPrice);
        $('#hiddenTotalPayment').val(totalPayment);
    });

    
    // Trigger change event to set the initial state
    $('input[name="payment_method"]:checked').trigger('change');
    

    $('button[name="btn_continue_step2"]').on('click', function() {
        let notification = $('#notification');
        let errors = [];
        
        let userId = $('.ds__item__contact-info').attr('value');
        let displayName = $('input[name="customer_display_name"]').val().trim();
        let phone = $('input[name="customer_phone"]').val().trim();
        let address = $('input[name="customer_address"]').val().trim();
        let statusPayment = $('input[name="payment_method"]:checked').val();
    
        // Kiểm tra từng trường và thêm thông báo lỗi nếu cần
        if (displayName === '') {
            errors.push('<strong>Lỗi!</strong> Vui lòng nhập Họ tên');
        }
        if (phone === '') {
            errors.push('<strong>Lỗi!</strong> Vui lòng nhập Số điện thoại');
        } else if (!validatePhone(phone)) {
            errors.push('<strong>Lỗi!</strong> Số điện thoại không hợp lệ');
        }
        if (address === '') {
            errors.push('<strong>Lỗi!</strong> Vui lòng nhập Địa chỉ');
        }
         
        // Hiển thị hoặc ẩn thông báo lỗi
        if (errors.length > 0) {
            $('#error-messages').html(errors.join('<br>'));
            $('#error-alert').removeClass('d-none');
        } else {
            $('#error-alert').addClass('d-none');
            console.log(userId, // Include userId
                displayName,
                 phone,
               address,
                statusPayment);
            // Gửi dữ liệu lên máy chủ
            $.ajax({
                url: 'php/insertOrder.php',
                type: 'POST',
                data: {
                    userId: userId, // Include userId
                    customer_display_name: displayName,
                    customer_phone: phone,
                    customer_address: address,
                    statusPayment: statusPayment
                },
                success: function(response) {
                    if (response.status === 'success') {
                        console.log('Server response:', response);
                        notification.show();
                        // Xóa giỏ hàng nếu chèn đơn hàng thành công
                        $.ajax({
                            url: 'php/clearCart.php',
                            type: 'POST',
                            success: function(clearResponse) {
                                console.log('Clear cart response:', clearResponse);
                            },
                            error: function(xhr, status, error) {
                                console.error('Lỗi khi xóa giỏ hàng:', error);
                            }
                        });
    
                        // Hide notification after 2 seconds
                        setTimeout(function() {
                            notification.hide();

                                window.location.href = 'orderdetail.php?orderId=' + response.orderId;
                            
                        }, 2000);
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi
                    console.error('Lỗi khi gửi dữ liệu:', error);
                }
            });
        }
        
    });    

    $('#error-alert .close').on('click', function(e) {
        e.preventDefault();
        $('#error-alert').addClass('d-none');
    });

    function validatePhone(phone) {
        const re = /((09|03|07|08|05)+([0-9]{8})\b)/g;
        return re.test(String(phone));
    }
    

    var viewMoreButton = document.querySelector('.view-more-product');

    viewMoreButton.addEventListener('click', function(event) {
        event.preventDefault();
        var cartElement = document.querySelector('.checkout-my-cart');

        if (cartElement.style.display === 'none') {
            cartElement.style.display = 'block';
        } else {
            cartElement.style.display = 'none';
        }
    });

});