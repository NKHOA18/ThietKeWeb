document.addEventListener("DOMContentLoaded", function() {
    // Tải danh sách thể loại ban đầu khi trang được tải lên
    loadColors();
    document.querySelector('.capnhat_mausac').disabled = true;
    // Thêm sự kiện click vào nút "Thêm"
    const addButton = document.querySelector('.them_mausac');
    addButton.addEventListener('click', function() {
        addColor(); // Gọi hàm để thêm thể loại mới
    });

    // Thêm sự kiện click vào nút "Cập nhật"
    const updateButton = document.querySelector('.capnhat_mausac');
    updateButton.addEventListener('click', function() {
        const ma_so = document.querySelector('.txtmams').value; // Lấy mã số từ trường nhập liệu
        
        updateColor(ma_so); // Truyền mã số vào hàm để cập nhật thể loại
    });
});


function loadColors() {
    fetch("php/color.php?event=get_colors")
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById("tableBodycolor");
            tableBody.innerHTML = ""; // Xóa nội dung cũ của bảng trước khi cập nhật
            data.forEach(color => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${color.ma_so}</td>
                    <td>${color.ten_mau_sac}</td>
                    <td><img src="/nkstore/assets/images/icon/0${getColor(color.ma_so)}.png"</td>

                    <td>
                        <button class='btn btn-primary' onclick='editColor(this)'>Sửa</button>
                        <button class='btn btn-danger' onclick='deleteColor(${color.ma_so})'>Xóa</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        })
        .catch(error => console.error("Lỗi khi lấy dữ liệu:", error));
}

function getColor(colorId) {
    if(colorId < 10){
        return colorId = "0" + colorId;
    } else{
        return colorId;
    }
}
function addColor() {
    // Lấy dữ liệu từ các trường nhập liệu
    const ma_so = document.querySelector('.txtmams').value.trim();
    const ten_mau_sac = document.querySelector('.txttenmausac').value;

    // Kiểm tra dữ liệu đầu vào
    if (!ma_so.match(/^[0-9]+$/)) {
        alert('Mã số thể loại không hợp lệ. Vui lòng chỉ sử dụng các số.');
        document.querySelector('.txtmams').focus();
        return;
    }

    checkMaMausac(ma_so).then(isDuplicate => {
        if (isDuplicate) {
            alert('Mã số màu sắc đã tồn tại. Vui lòng nhập mã số khác.');
            document.querySelector('.txtmams').focus();
            return;
        }

        const formData = new FormData();
        formData.append('ma_so', ma_so);
        formData.append('ten_mau_sac', ten_mau_sac);


        fetch('php/color.php?event=add_color', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
            alert(data);
            document.querySelector('.txtmams').value = "";
            document.querySelector('.txttenmausac').value = "";
            loadColors(); // Tải lại danh sách thể loại sau khi thêm thành công
        })
        .catch(error => console.error('Lỗi khi thêm thể loại:', error));
    });
}


function editColor(button) {
    document.querySelector('.capnhat_mausac').disabled = false;
    const row = button.closest('tr'); // Lấy hàng (row) chứa nút "Sửa" được click
    const ma_so = row.cells[0].innerText; // Lấy mã số từ cột đầu tiên trong hàng
    const ten_mau_sac = row.cells[1].innerText; // Lấy tên thể loại từ cột thứ ba trong hàng

    // Hiển thị thông tin thể loại vào form
    document.querySelector('.txtmams').value = ma_so;
    document.querySelector('.txtmams').disabled = true; // Vô hiệu hóa trường nhập liệu cho mã số
    document.querySelector('.txttenmausac').value = ten_mau_sac;
    document.querySelector('.cbnhom').value = setGroup(nhom);
    document.querySelector('.them_mausac').disabled = true;
}


function updateColor(ma_so) {
    // Lấy thông tin từ các trường nhập liệu
    const ten_mau_sac = document.querySelector('.txttenmausac').value;

    // Tạo đối tượng dữ liệu FormData để gửi yêu cầu cập nhật thông tin thể loại
    const formData = new FormData();
    formData.append('ma_so', ma_so);
    formData.append('ten_mau_sac', ten_mau_sac);

    // Gửi yêu cầu POST đến server để cập nhật thông tin thể loại
    fetch('php/color.php?event=update_color', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log(data); // Log kết quả trả về từ server
        alert(data);
        // Xóa dữ liệu trong các trường nhập liệu
        document.querySelector('.txtmams').disabled = false;
        document.querySelector('.txtmams').value = "";
        document.querySelector('.txttenmausac').value = "";
        // Sau khi cập nhật thành công, tải lại danh sách thể loại
        loadColors();
        document.querySelector('.them_mausac').disabled = false;
        document.querySelector('.capnhat_mausac').disabled = true;
    })
    .catch(error => console.error('Lỗi khi cập nhật thể loại:', error));
}
function deleteColor(colorId) {
    if (confirm("Bạn có chắc chắn muốn xóa màu sắc này không?")) {
        fetch(`php/color.php?event=delete_color&ma_so=${colorId}`, {
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
            loadColors();
        })
        .catch(error => console.error('Lỗi khi xóa thể loại:', error.message));
    
    }

}
function checkMaMausac(ma_so) {
    return fetch(`php/color.php?event=check_ma_mau_sac&ma_so=${ma_so}`)
        .then(response => response.json())
        .then(data => {
            return data.hasCategoryId;
        })
        .catch(error => {
            console.error('Lỗi khi kiểm tra mã số thể loại:', error);
            return false;
        });
}