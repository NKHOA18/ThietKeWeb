// Xử lý khi trang web được tải lên
window.onload = function() {
    // Kiểm tra xem có cookie ghi nhớ đăng nhập không
    var rememberMe = getCookie("rememberMe");
    if (rememberMe) {
        // Nếu có, điền tự động thông tin đăng nhập vào biểu mẫu
        var account = getCookie("account");
        var password = getCookie("password");
        if (account && password) {
            document.getElementsByName("account")[0].value = account;
            document.getElementsByName("password")[0].value = password;
        }
    }
}

// Xử lý khi người dùng nhấn nút đăng nhập
document.getElementById("login-form").onsubmit = function(event) {
    // Lấy thông tin đăng nhập từ biểu mẫu
    var rememberCheckbox = document.getElementsByName("customer_remember")[0];
    var account = document.getElementsByName("account")[0].value;
    var password = document.getElementsByName("password")[0].value;

    // Nếu người dùng chọn "Ghi nhớ đăng nhập"
    if (rememberCheckbox.checked) {
        // Thiết lập thời gian hết hạn của cookie là 30 ngày sau thời điểm hiện tại
        var expirationDate = new Date();
        expirationDate.setDate(expirationDate.getDate() + 30);

        // Lưu thông tin đăng nhập vào cookie
        document.cookie = "account=" + account + "; expires=" + expirationDate.toUTCString() + "; path=/";
        document.cookie = "password=" + password + "; expires=" + expirationDate.toUTCString() + "; path=/";
        document.cookie = "rememberMe=true; expires=" + expirationDate.toUTCString() + "; path=/";
    }
}

// Hàm lấy cookie
function getCookie(name) {
    var value = "; " + document.cookie;
    var parts = value.split("; " + name + "=");
    if (parts.length == 2) return parts.pop().split(";").shift();
}

// Hàm xóa cookie
function deleteCookie(name) {
    document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/";
}

// Xử lý khi người dùng đăng xuất
function onLogout() {
    deleteCookie("account");
    deleteCookie("password");
    deleteCookie("rememberMe");
}
