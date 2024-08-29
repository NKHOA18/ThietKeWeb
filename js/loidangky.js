let registeredEmails = [];
let registeredPhones = []; // Thêm biến để lưu trữ danh sách số điện thoại đã đăng ký
$(document).ready(function() {
    fetchRegisteredData();
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

// Lấy danh sách email và số điện thoại đã đăng ký từ máy chủ
function fetchRegisteredData() {
    $.ajax({
        url: 'get_data.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            registeredEmails = data.emails;
            registeredPhones = data.phones; // Lưu trữ danh sách số điện thoại
            console.log(registeredEmails);
            console.log(registeredPhones);
        },
        error: function(error) {
            console.log('Error fetching data:', error);
        }
    });
}

        

function validateForm(event) {
    event.preventDefault();
    const form = document.forms['frm_register'];
    const firstname = form['firstname'].value.trim();
    const displayname = form['displayname'].value.trim();
    const email = form['email'].value.trim();
    const phone = form['phone'].value.trim();
    const birthday = form['birthday'].value.trim();
    const gender = form['gender'].value.trim();
    const address = form['address'].value.trim();
    const password1 = form['pass1'].value.trim();
    const password2 = form['pass2'].value.trim();

    let errors = [];

    if (firstname === '' || displayname === '') errors.push('Vui lòng nhập Họ Tên');
    if (!validateEmail(email)) errors.push('Email không hợp lệ');
    if (!validatePhone(phone)) errors.push('Số điện thoại không hợp lệ');
    if (birthday === '') errors.push('Vui lòng nhập Ngày sinh nhật');
    if (gender === '') errors.push('Vui lòng chọn Giới tính');
    if (address === '') errors.push('Vui lòng nhập Địa chỉ');
    if (password1.length < 7 || password1.length > 32) errors.push('Vui lòng nhập mật khẩu độ dài từ 7 tới 32 ký tự');
    if (password1 !== password2) errors.push('Mật khẩu không giống nhau');
 
    // Kiểm tra email đã tồn tại
    if (registeredEmails.includes(email)) {
        errors.push('Email đã có người sử dụng rồi');
    }
    if (registeredPhones.includes(phone)) {
        errors.push('Số điện thoại đã có người sử dụng rồi');
    }

    removeErrorMessages();

    if (errors.length > 0) {
        displayErrors(errors);
        return false; // Ngăn chặn form submit nếu có lỗi
    }
    form.setAttribute('action', 'dangky.php');
    form.submit(); // Submit form
    return true;
}

function removeErrorMessages() {
    const errorMessages = document.querySelectorAll('.alert.alert-danger');
    errorMessages.forEach(errorMessage => {
        errorMessage.remove();
    });
}

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(String(email).toLowerCase());
}

function validatePhone(phone) {
    const re = /((09|03|07|08|05)+([0-9]{8})\b)/g;
    return re.test(String(phone));
}

function displayErrors(errors) {
    const errorDiv = document.createElement('div');
    errorDiv.className = 'alert alert-danger alert-dismissable';
    errorDiv.style = 'margin-bottom: 10px; margin-top: 10px; margin-left: 65px; margin-right: 65px; background-color: #f3e8e9; color: #ff070f; padding: 10px; font-size: 14px';

    let errorHtml = '<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>';
    errors.forEach(error => {
        errorHtml += `<strong>Lỗi! </strong> ${error}<br>`;
    });
    errorDiv.innerHTML = errorHtml;

    const titleDiv = document.querySelector('.order-block__title');
    const authDiv = document.querySelector('.auth.auth-forgotpass');
    titleDiv.parentNode.insertBefore(errorDiv, authDiv);

    const closeButton = errorDiv.querySelector('.close');
    // Gán sự kiện click cho nút đóng
    closeButton.addEventListener('click', function() {
        errorDiv.style.display = 'none'; // Ẩn thông báo lỗi khi click vào nút đóng
    });
}

// Tạo một đối tượng XMLHttpRequest
const xhr = new XMLHttpRequest();
// Xác định URL của tệp PHP để gửi yêu cầu
const url = "dangky.php";
// Khai báo phương thức và URL
xhr.open("POST", url, true);
// Thiết lập tiêu đề yêu cầu
xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
// Định nghĩa hàm xử lý khi yêu cầu hoàn thành
xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
        console.log(xhr.responseText); // Hiển thị kết quả trả về từ PHP
    }
};
// Chuẩn bị dữ liệu để gửi
const params = "firstname=" + firstname + "&displayname=" + displayname + "&email=" + email + "&phone=" + phone + "&birthday=" + birthday + "&gender=" + gender + "&address=" + address + "&pass1=" + password1 + "&pass2=" + password2;
// Gửi yêu cầu với dữ liệu đã chuẩn bị
xhr.send(params);

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
