document.addEventListener("DOMContentLoaded", function() {
    // Tải danh sách thể loại ban đầu khi trang được tải lên
    loadCategories();
    document.querySelector('.capnhat_theloai').disabled = true;
    // Thêm sự kiện click vào nút "Thêm"
    const addButton = document.querySelector('.them_theloai');
    addButton.addEventListener('click', function() {
        addCategory(); // Gọi hàm để thêm thể loại mới
    });

    // Thêm sự kiện click vào nút "Cập nhật"
    const updateButton = document.querySelector('.capnhat_theloai');
    updateButton.addEventListener('click', function() {
        const ma_so = document.querySelector('.txtmatl').value; // Lấy mã số từ trường nhập liệu
        
        updateCategory(ma_so); // Truyền mã số vào hàm để cập nhật thể loại
    });
});


function loadCategories() {
    fetch("php/theloai.php?event=get_categories")
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById("tableBody");
            tableBody.innerHTML = ""; // Xóa nội dung cũ của bảng trước khi cập nhật
            data.forEach(category => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${category.ma_so}</td>
                    <td>${category.ten_the_loai}</td>
                    <td>${getGroup(category.nhom)}</td>
                    <td>
                        <button class='btn btn-primary' onclick='editCategory(this)'>Sửa</button>
                        <button class='btn btn-danger' onclick='deleteCategory(${category.ma_so})'>Xóa</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        })
        .catch(error => console.error("Lỗi khi lấy dữ liệu:", error));
}

function addCategory() {
    // Lấy dữ liệu từ các trường nhập liệu
    const ma_so = document.querySelector('.txtmatl').value.trim();
    const ten_the_loai = document.querySelector('.txttentheloai').value;
    const nhom = document.querySelector('.cbnhom').value;

    // Kiểm tra dữ liệu đầu vào
    if (!ma_so.match(/^[0-9]+$/)) {
        alert('Mã số thể loại không hợp lệ. Vui lòng chỉ sử dụng các số.');
        document.querySelector('.txtmatl').focus();
        return;
    }

    checkMaTheLoai(ma_so).then(isDuplicate => {
        if (isDuplicate) {
            alert('Mã số thể loại đã tồn tại. Vui lòng nhập mã số khác.');
            document.querySelector('.txtmatl').focus();
            return;
        }

        const formData = new FormData();
        formData.append('ma_so', ma_so);
        formData.append('ten_the_loai', ten_the_loai);
        formData.append('nhom', nhom);

        fetch('php/theloai.php?event=add_category', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
            alert(data);
            document.querySelector('.txtmatl').value = "";
            document.querySelector('.txttentheloai').value = "";
            loadCategories(); // Tải lại danh sách thể loại sau khi thêm thành công
        })
        .catch(error => console.error('Lỗi khi thêm thể loại:', error));
    });
}

function getGroup(groupId) {
    switch (groupId) {
        case "1":
            return "Nữ";
        case "2":
            return "Nam";
        case "3":
            return "Bé trai";
        case "4":
            return "Bé gái";
        default:
            return "Không xác định";
    }
}
function setGroup(groupId) {
    switch (groupId) {
        case "Nữ":
            return "1";
        case "Nam":
            return "2";
        case "Bé trai":
            return "3";
        case "Bé gái":
            return "4";
        default:
            return "Không xác định";
    }
}

function editCategory(button) {
    document.querySelector('.capnhat_theloai').disabled = false;
    const row = button.closest('tr'); // Lấy hàng (row) chứa nút "Sửa" được click
    const ma_so = row.cells[0].innerText; // Lấy mã số từ cột đầu tiên trong hàng
    const ten_the_loai = row.cells[1].innerText; // Lấy tên thể loại từ cột thứ ba trong hàng
    const nhom = row.cells[2].innerText; // Lấy nhóm từ cột thứ tư trong hàng

    // Hiển thị thông tin thể loại vào form
    document.querySelector('.txtmatl').value = ma_so;
    document.querySelector('.txtmatl').disabled = true; // Vô hiệu hóa trường nhập liệu cho mã số
    document.querySelector('.txttentheloai').value = ten_the_loai;
    document.querySelector('.cbnhom').value = setGroup(nhom);
    document.querySelector('.them_theloai').disabled = true;
}


function updateCategory(ma_so) {
    // Lấy thông tin từ các trường nhập liệu
    const ten_the_loai = document.querySelector('.txttentheloai').value;
    const nhom = document.querySelector('.cbnhom').value;

    // Tạo đối tượng dữ liệu FormData để gửi yêu cầu cập nhật thông tin thể loại
    const formData = new FormData();
    formData.append('ma_so', ma_so);
    formData.append('ten_the_loai', ten_the_loai);
    formData.append('nhom', nhom);

    // Gửi yêu cầu POST đến server để cập nhật thông tin thể loại
    fetch('php/theloai.php?event=update_category', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log(data); // Log kết quả trả về từ server
        alert(data);
        // Xóa dữ liệu trong các trường nhập liệu
        document.querySelector('.txtmatl').disabled = false;
        document.querySelector('.txtmatl').value = "";
        document.querySelector('.txttentheloai').value = "";
        // Sau khi cập nhật thành công, tải lại danh sách thể loại
        loadCategories();
        document.querySelector('.them_theloai').disabled = false;
        document.querySelector('.capnhat_theloai').disabled = true;
    })
    .catch(error => console.error('Lỗi khi cập nhật thể loại:', error));
}

function deleteCategory(categoryId) {
    if (confirm("Bạn có chắc chắn muốn xóa thể loại này không?")) {
        // Kiểm tra thể loại có sản phẩm tham chiếu không
        fetch(`php/theloai.php?event=check_products&ma_so=${categoryId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Có lỗi xảy ra khi kiểm tra sản phẩm');
                }
                return response.json();
            })
            .then(data => {
                if (data.hasOwnProperty('hasProducts') && data.hasOwnProperty('product_count')) {
                    if (data.hasProducts) {
                        // Thể loại có sản phẩm tham chiếu, hiển thị cảnh báo
                        const productCount = data.product_count;
                        if (confirm(`Thể loại này đang có ${productCount} sản phẩm tham chiếu. Bạn phải xóa các sản phẩm đó, bạn vẫn muốn tiếp tục?`)) {
                            // Thực hiện yêu cầu xóa tất cả các sản phẩm tham chiếu
                            fetch(`php/theloai.php?event=delete_products&ma_so=${categoryId}`, {
                                method: 'DELETE'
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Có lỗi xảy ra khi xóa sản phẩm');
                                }
                                // Nếu xóa sản phẩm thành công, thực hiện yêu cầu xóa thể loại
                                return fetch(`php/theloai.php?event=delete_category&ma_so=${categoryId}`, {
                                    method: 'DELETE'
                                });
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Có lỗi xảy ra khi xóa thể loại');
                                }
                                return response.text();
                            })
                            .then(data => {
                                console.log(data); // Log kết quả trả về từ server
                                alert(data); // Hiển thị thông báo từ server
                                // Sau khi xóa thành công, tải lại danh sách thể loại
                                loadCategories();
                            })
                            .catch(error => console.error('Lỗi khi xóa thể loại:', error.message));
                        }
                    } else {
                        // Không có sản phẩm tham chiếu, tiến hành xóa thể loại
                        fetch(`php/theloai.php?event=delete_category&ma_so=${categoryId}`, {
                            method: 'DELETE'
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Có lỗi xảy ra khi xóa thể loại');
                            }
                            return response.text();
                        })
                        .then(data => {
                            console.log(data); // Log kết quả trả về từ server
                            alert(data); // Hiển thị thông báo từ server
                            // Sau khi xóa thành công, tải lại danh sách thể loại
                            loadCategories();
                        })
                        .catch(error => console.error('Lỗi khi xóa thể loại:', error.message));
                    }
                } else {
                    throw new Error('Dữ liệu không hợp lệ từ máy chủ');
                }
            })
            .catch(error => console.error('Lỗi khi kiểm tra sản phẩm:', error.message));
    }
}

function checkMaTheLoai(ma_so) {
    return fetch(`php/theloai.php?event=check_ma_the_loai&ma_so=${ma_so}`)
        .then(response => response.json())
        .then(data => {
            return data.hasCategoryId;
        })
        .catch(error => {
            console.error('Lỗi khi kiểm tra mã số thể loại:', error);
            return false;
        });
}





