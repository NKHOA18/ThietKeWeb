$(document).ready(function() {
    // Kiểm tra cookie khi trang tải
    checkRememberedLogin();

    $("#login-form").submit(function(event) {
        event.preventDefault();
        validateLoginForm();
    });
});

function checkRememberedLogin() {
    // Lấy giá trị cookie
    const rememberedAccount = getCookie("account");
    const rememberedPassword = getCookie("password");

    if (rememberedAccount && rememberedPassword) {
        // Tự động đăng nhập
        loginUser(rememberedAccount, rememberedPassword, true);
    }
}

function validateLoginForm() {
    const account = $("input[name='account']").val().trim();
    const password = $("input[name='password']").val().trim();
    const remember = $("input[name='customer_remember']").is(":checked");

    let errors = [];

    if (account === "" || password === "") {
        errors.push("Vui lòng nhập đầy đủ thông tin đăng nhập");
    }

    displayErrors(errors);

    if (errors.length === 0) {
        // Không có lỗi, gửi dữ liệu bằng AJAX và lưu cookie nếu cần
        loginUser(account, password, remember);
    }
}

function displayErrors(errors) {
    const errorDiv = $(".errorMessages");
    errorDiv.empty();

    if (errors.length > 0) {
        let errorHtml = '<div class="col-md-12"><div class="alert alert-warning alert-dismissible" role="alert" style="background-color: #f3e8e9;color: red; font-size: 14px;line-height: 24px">';
        errorHtml += '<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>';
        errors.forEach(error => {
            errorHtml += `<strong>Lỗi! </strong> ${error}<br>`;
        });
        errorHtml += '</div></div>';
        errorDiv.append(errorHtml);
    }

    // Thêm sự kiện click cho nút đóng
    $(".alert .close").click(function() {
        $(this).parent().parent().remove(); // Ẩn thông báo lỗi khi click vào nút đóng
    });
}

function loginUser(account, password, remember) {
    $.ajax({
        url: 'dangnhap.php',
        method: 'POST',
        data: { account: account, password: password, but_login_email: true },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // Xác định thời gian lưu trữ của cookie
                const days = remember ? 15 : 1;

                if (remember) {
                    // Lưu cookie trong 15 ngày nếu ghi nhớ đăng nhập được chọn
                    setCookie("account", account, days);
                    setCookie("password", password, days);
                } else {
                    // Lưu cookie trong 1 ngày nếu không ghi nhớ đăng nhập
                    setCookie("account", account, days);
                    setCookie("password", password, days);
                }
                window.location.href = response.redirect;
            } else {
                if (response.errorCode === 'INVALID_CREDENTIALS') {
                    displayErrors(['Lỗi! Tên đăng nhập hoặc mật khẩu không hợp lệ']);
                } else {
                    displayErrors([response.message]);
                }
            }
        },
        error: function(error) {
            console.log('Error logging in:', error);
            displayErrors(['Có lỗi xảy ra khi đăng nhập. Vui lòng thử lại sau.']);
        }
    });
}


function setCookie(name, value, days) {
    let expires = "";
    if (days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

function getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

function deleteCookie(name) {
    document.cookie = name + "=; Max-Age=-99999999;";
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
