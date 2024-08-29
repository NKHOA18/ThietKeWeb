document.addEventListener("DOMContentLoaded", function() {
    // Tải danh sách thể loại ban đầu khi trang được tải lên
    loadSizes();
    document.querySelector('.capnhat_kichco').disabled = true;
    // Thêm sự kiện click vào nút "Thêm"
    const addButton = document.querySelector('.them_kichco');
    addButton.addEventListener('click', function() {
        addSize(); // Gọi hàm để thêm thể loại mới
    });

    // Thêm sự kiện click vào nút "Cập nhật"
    const updateButton = document.querySelector('.capnhat_kichco');
    updateButton.addEventListener('click', function() {
        const ma_so = document.querySelector('.txtmakc').value; // Lấy mã số từ trường nhập liệu
        
        updateSize(ma_so); // Truyền mã số vào hàm để cập nhật thể loại
    });
});


function loadSizes() {
    fetch("php/size.php?event=get_sizes")
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById("tableBodysize");
            tableBody.innerHTML = ""; // Xóa nội dung cũ của bảng trước khi cập nhật
            data.forEach(size => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${size.ma_so}</td>
                    <td>${size.ten_kich_co}</td>
                    <td>
                        <button class='btn btn-primary' onclick='editSize(this)'>Sửa</button>
                        <button class='btn btn-danger' onclick='deleteSize(${size.ma_so})'>Xóa</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        })
        .catch(error => console.error("Lỗi khi lấy dữ liệu:", error));
}

function addSize() {
    // Lấy dữ liệu từ các trường nhập liệu
    const ma_so = document.querySelector('.txtmakc').value.trim();
    const ten_kich_co = document.querySelector('.txttenkichco').value;

    // Kiểm tra dữ liệu đầu vào
    if (!ma_so.match(/^[0-9]+$/)) {
        alert('Mã số thể loại không hợp lệ. Vui lòng chỉ sử dụng các số.');
        document.querySelector('.txtmakc').focus();
        return;
    }

    checkMaMausac(ma_so).then(isDuplicate => {
        if (isDuplicate) {
            alert('Mã số màu sắc đã tồn tại. Vui lòng nhập mã số khác.');
            document.querySelector('.txtmakc').focus();
            return;
        }

        const formData = new FormData();
        formData.append('ma_so', ma_so);
        formData.append('ten_kich_co', ten_kich_co);


        fetch('php/size.php?event=add_size', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
            alert(data);
            document.querySelector('.txtmakc').value = "";
            document.querySelector('.txttenkichco').value = "";
            loadSizes(); // Tải lại danh sách thể loại sau khi thêm thành công
        })
        .catch(error => console.error('Lỗi khi thêm thể loại:', error));
    });
}


function editSize(button) {
    document.querySelector('.capnhat_kichco').disabled = false;
    const row = button.closest('tr'); // Lấy hàng (row) chứa nút "Sửa" được click
    const ma_so = row.cells[0].innerText; // Lấy mã số từ cột đầu tiên trong hàng
    const ten_kich_co = row.cells[1].innerText; // Lấy tên thể loại từ cột thứ ba trong hàng

    // Hiển thị thông tin thể loại vào form
    document.querySelector('.txtmakc').value = ma_so;
    document.querySelector('.txtmakc').disabled = true; // Vô hiệu hóa trường nhập liệu cho mã số
    document.querySelector('.txttenkichco').value = ten_kich_co;
    document.querySelector('.cbnhom').value = setGroup(nhom);
    document.querySelector('.them_kichco').disabled = true;
}


function updateSize(ma_so) {
    // Lấy thông tin từ các trường nhập liệu
    const ten_kich_co = document.querySelector('.txttenkichco').value;

    // Tạo đối tượng dữ liệu FormData để gửi yêu cầu cập nhật thông tin thể loại
    const formData = new FormData();
    formData.append('ma_so', ma_so);
    formData.append('ten_kich_co', ten_kich_co);

    // Gửi yêu cầu POST đến server để cập nhật thông tin thể loại
    fetch('php/size.php?event=update_size', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log(data); // Log kết quả trả về từ server
        alert(data);
        // Xóa dữ liệu trong các trường nhập liệu
        document.querySelector('.txtmakc').disabled = false;
        document.querySelector('.txtmakc').value = "";
        document.querySelector('.txttenkichco').value = "";
        // Sau khi cập nhật thành công, tải lại danh sách thể loại
        loadSizes();
        document.querySelector('.them_kichco').disabled = false;
        document.querySelector('.capnhat_kichco').disabled = true;
    })
    .catch(error => console.error('Lỗi khi cập nhật thể loại:', error));
}
function deleteSize(sizeId) {
    if (confirm("Bạn có chắc chắn muốn xóa màu sắc này không?")) {
        fetch(`php/size.php?event=delete_size&ma_so=${sizeId}`, {
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
            loadSizes();
        })
        .catch(error => console.error('Lỗi khi xóa thể loại:', error.message));
    
    }

}
function checkMaMausac(ma_so) {
    return fetch(`php/size.php?event=check_ma_kich_co&ma_so=${ma_so}`)
        .then(response => response.json())
        .then(data => {
            return data.hasCategoryId;
        })
        .catch(error => {
            console.error('Lỗi khi kiểm tra mã số thể loại:', error);
            return false;
        });
}