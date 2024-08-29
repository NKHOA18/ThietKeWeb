document.addEventListener("DOMContentLoaded", function() {
    // Tải danh sách sản phẩm và thể loại khi trang được tải lên
    
    loadUsers();
    // document.querySelector('.capnhat_sanpham').disabled = true;
    // // Thêm sự kiện click vào nút "Thêm"
    // const addButton = document.querySelector('.them_sanpham');
    // addButton.addEventListener('click', function() {
    //     addProduct(); // Gọi hàm để thêm sản phẩm mới
    // });
    // const updateButton = document.querySelector('.capnhat_sanpham');
    // updateButton.addEventListener('click', function() {
    //     const ma_so = document.querySelector('.txtmasp').value; // Lấy mã số từ trường nhập liệu
        
    //     updateProduct(ma_so); // Truyền mã số vào hàm để cập nhật thể loại
    // });
});

function loadUsers() {
    fetch("php/user.php?event=get_users")
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById("tableBodyuser");
            tableBody.innerHTML = ""; // Xóa nội dung cũ của bảng trước khi cập nhật
            data.forEach(user => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${user.ma_so}</td>
                    <td>${user.ho_nguoi_dung}&nbsp;${user.ten_nguoi_dung}</td>
                    <td>${user.dia_chi}</td>
                    <td>${user.so_dien_thoai}</td>
                    <td>${user.email}</td>
                    <td>${user.ngay_tao}</td>
                    <td>${user.gioi_tinh}</td>
                    <td>${user.ngay_sinh}</td>
                    <td>${getRole(user.ma_quyen)}</td>
                    <td>
                        <button class='btn btn-primary' onclick='editUser(this, event)'>Sửa</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        })
        .catch(error => console.error("Lỗi khi lấy dữ liệu:", error));
}

function getRole(roleId) {
    switch (roleId) {
        case "1":
            return "ADMIN";
        case "0":
            return "Khách hàng";
        default:
            return "Không xác định";
    }
}