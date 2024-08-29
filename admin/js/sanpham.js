document.addEventListener("DOMContentLoaded", function() {
    // Tải danh sách sản phẩm và thể loại khi trang được tải lên
    
    showSoluongsp();
    showTheloaisp();
    loadProducts();
    document.querySelector('.capnhat_sanpham').disabled = true;
    // Thêm sự kiện click vào nút "Thêm"
    const addButton = document.querySelector('.them_sanpham');
    addButton.addEventListener('click', function() {
        addProduct(); // Gọi hàm để thêm sản phẩm mới
    });
    const updateButton = document.querySelector('.capnhat_sanpham');
    updateButton.addEventListener('click', function() {
        const ma_so = document.querySelector('.txtmasp').value; // Lấy mã số từ trường nhập liệu
        
        updateProduct(ma_so); // Truyền mã số vào hàm để cập nhật thể loại
    });
});

function loadProducts() {
    fetch("php/sanpham.php?event=get_products")
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById("tableBodysp");
            tableBody.innerHTML = ""; // Xóa nội dung cũ của bảng trước khi cập nhật
            data.forEach(product => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td><button class='btn btn-info' onclick='addAttribute(${product.ma_so}, event)'>${product.ma_so}</button></td>
                    <td>${product.ten_san_pham}</td>
                    <td><img src="../${product.hinh_anh}" style="max-width: 120px;"></td>
                    <td>${product.gia}</td>
                    <td>${product.muc_giam}%</td>
                    <td>${product.mo_ta}</td>
                    <td>${product.so_luong}</td>
                    <td>${getCategoryName(product.ma_the_loai)}</td>
                    <td>${getGrouptt(product.trang_thai)}</td>
                    <td>
                        <button class='btn btn-primary' onclick='editProduct(this, event)'>Sửa</button>
                        <button class='btn btn-danger' onclick='deleteProduct(${product.ma_so}, event)'>Xóa</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        })
        .catch(error => console.error("Lỗi khi lấy dữ liệu:", error));
}


function addProduct() {
    // Lấy dữ liệu từ các trường nhập liệu
    const ten_san_pham = document.querySelector('.txttensp').value;
    const hinh_anh = document.querySelector('.txtimagesp').files[0]; // Lấy tệp hình ảnh
    const gia = document.querySelector('.txtgiasp').value.trim();
    const muc_giam = document.querySelector('.cbmucgiam').value;
    const mo_ta = document.querySelector('.txtmotasp').value;
    const ma_the_loai = document.querySelector('.cbtheloai').value;
    const so_luong = document.querySelector('.cbsoluong').value;
    const trang_thai = document.querySelector('.cbtrangthai').value;

    // Kiểm tra dữ liệu đầu vào
    if (!ten_san_pham) {
        alert('Tên sản phẩm không được để trống!');
        document.querySelector('.txttensp').focus();
        return;
    }

    if (!hinh_anh) {
        alert('Bạn phải chọn hình ảnh cho sản phẩm!');
        document.querySelector('.txtimagesp').focus();
        return;
    }

    if (isNaN(gia) || parseFloat(gia) <= 0) {
        alert('Giá sản phẩm không hợp lệ. Vui lòng nhập một số lớn hơn 0!');
        document.querySelector('.txtgiasp').focus();
        return;
    }

    if (ma_the_loai === "0") {
        alert('Bạn phải chọn thể loại cho sản phẩm!');
        document.querySelector('.cbtheloai').focus();
        return;
    }
        // Tạo đối tượng dữ liệu FormData để gửi dữ liệu POST
        const formData = new FormData();

        formData.append('ten_san_pham', ten_san_pham);
        formData.append('hinh_anh', hinh_anh);
        formData.append('gia', gia);
        formData.append('muc_giam', muc_giam);
        formData.append('mo_ta', mo_ta);
        formData.append('ma_the_loai', ma_the_loai);
        formData.append('so_luong', so_luong);
        formData.append('trang_thai', trang_thai);

        // Gửi yêu cầu POST đến server để thêm sản phẩm
        fetch('php/sanpham.php?event=add_product', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log(data); // Log kết quả trả về từ server
            alert(data); // Thông báo khi thêm thành công
             document.querySelector('.txtmasp').disabled = true;
            document.querySelector('.txtmasp').value = "";
            document.querySelector('.txttensp').value = "";
            document.querySelector('.txtimagesp').value = "";
            document.querySelector('.txtgiasp').value = "";
            document.querySelector('.txtmotasp').value = "";
            // Sau khi thêm thành công, tải lại danh sách sản phẩm
            loadProducts();
        })
        .catch(error => console.error('Lỗi khi thêm sản phẩm:', error));

}

function updateProduct(ma_so) {
    // Lấy thông tin từ các trường nhập liệu
    const ten_san_pham = document.querySelector('.txttensp').value;
    const hinh_anh = document.querySelector('.txtimagesp').files[0]; // Lấy tệp hình ảnh
    const gia = document.querySelector('.txtgiasp').value.trim();
    const muc_giam = document.querySelector('.cbmucgiam').value;
    const mo_ta = document.querySelector('.txtmotasp').value;
    const ma_the_loai = document.querySelector('.cbtheloai').value;
    const so_luong = document.querySelector('.cbsoluong').value;
    const trang_thai = document.querySelector('.cbtrangthai').value;

    // Kiểm tra dữ liệu đầu vào
    if (isNaN(gia) || parseFloat(gia) <= 0) {
        alert('Giá sản phẩm không hợp lệ. Vui lòng nhập một số lớn hơn 0.');
        return;
    }

    // Tạo đối tượng dữ liệu FormData để gửi yêu cầu cập nhật thông tin sản phẩm
    const formData = new FormData();
    formData.append('ma_so', ma_so);
    formData.append('ten_san_pham', ten_san_pham);
    formData.append('gia', gia);
    formData.append('muc_giam', muc_giam);
    formData.append('mo_ta', mo_ta);
    formData.append('ma_the_loai', ma_the_loai);
    formData.append('so_luong', so_luong);
    formData.append('trang_thai', trang_thai);

    // Nếu có tệp hình ảnh mới được chọn, thêm vào FormData
    if (hinh_anh) {
        formData.append('hinh_anh', hinh_anh);
    }

    // Gửi yêu cầu POST đến server để cập nhật thông tin sản phẩm
    fetch(`php/sanpham.php?event=update_product&ma_so=${ma_so}`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log(data); // Log kết quả trả về từ server
        alert(data); // Hiển thị thông báo kết quả từ server

        // Xóa dữ liệu trong các trường nhập liệu
        document.querySelector('.txtmasp').disabled = true;
        document.querySelector('.txtmasp').value = "";
        document.querySelector('.txttensp').value = "";
        document.querySelector('.txtimagesp').value = "";
        document.querySelector('.txtgiasp').value = "";
        document.querySelector('.txtmotasp').value = "";
        document.querySelector('.cbtrangthai').disabled= true;
        // Sau khi cập nhật thành công, tải lại danh sách sản phẩm
        loadProducts();
        
        // Enable nút thêm sản phẩm và disable nút cập nhật sản phẩm
        document.querySelector('.them_sanpham').disabled = false;
        document.querySelector('.capnhat_sanpham').disabled = true;
    })
    .catch(error => console.error('Lỗi khi cập nhật sản phẩm:', error));
}


function deleteProduct(ma_so, event) {
    event.preventDefault(); // Ngăn chặn hành động mặc định

    if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này không?")) {
        fetch(`php/sanpham.php?event=delete_product&ma_so=${ma_so}`, {
            method: 'DELETE'
        })
        .then(response => response.text())
        .then(data => {
            if (data.includes('lỗi')) {
                alert('Sản phẩm này có các dữ liệu từ bảng thuộc tính sản phẩm và bộ sưu tập ảnh của sản phẩm tham chiếu đến. Bạn cần phải xóa những dữ liệu đó trước.');
            } else {
                alert(data); 
                loadProducts(); // Tải lại danh sách sản phẩm sau khi xóa
            }
        })
        .catch(error => {
            console.error("Lỗi khi xóa sản phẩm:", error);
            alert('Sản phẩm này có các dữ liệu từ bảng thuộc tính sản phẩm và bộ sưu tập ảnh của sản phẩm tham chiếu đến. Bạn cần phải xóa những dữ liệu đó trước.');
        });
    }
}


function editProduct(button, event) {
    event.preventDefault();
    document.querySelector('.txttensp').focus();
    document.querySelector('.capnhat_sanpham').disabled = false;
    const row = button.closest('tr'); // Lấy hàng (row) chứa nút "Sửa" được click
    const ma_so = row.cells[0].innerText; // Lấy mã số từ cột đầu tiên trong hàng
    const ten_san_pham = row.cells[1].innerText; 
    const hinh_anh = row.cells[2].querySelector('img').getAttribute('src'); // Lấy đường dẫn hình ảnh từ thẻ img
    const gia = row.cells[3].innerText;
    const muc_giam = row.cells[4].innerText;
    const mo_ta = row.cells[5].innerText;
    const so_luong = row.cells[6].innerText;
    const ten_the_loai = row.cells[7].innerText;
    const trang_thai = row.cells[8].innerText;

    // Hiển thị thông tin sản phẩm vào form
    document.querySelector('.txtmasp').value = ma_so;
    document.querySelector('.cbtrangthai').disabled = false; 
    document.querySelector('.txttensp').value = ten_san_pham;
    document.querySelector('.txtimagesp').value = ""; // Xóa giá trị của input file (vì không thể gán giá trị file)
    document.querySelector('.txtgiasp').value = gia;
    document.querySelector('.cbmucgiam').value = muc_giam;
    document.querySelector('.txtmotasp').value = mo_ta;
    document.querySelector('.cbtheloai').value = getCategoryId(ten_the_loai); // Đặt giá trị thể loại theo mã thể loại
    document.querySelector('.cbsoluong').value = so_luong;
    document.querySelector('.cbtrangthai').value = trang_thai === "Còn hàng" ? "1" : (trang_thai === "Hết hàng" ? "10" : "0");

    document.querySelector('.them_sanpham').disabled = true;
}


function getGroupsp(groupId) {
    switch (groupId) {
        case "1":
            return "Áo sơ mi";
        case "2":
            return "Áo thun";
        case "3":
            return "Áo croptop";
        case "4":
            return "Áo peplum";
        case "5":
            return "Áo thun nam";
        case "6":
            return "Áo polo";
        case "7":
            return "Áo sơ mi nam";
        case "8":
            return "Áo khoác/vest";
        case "11":
            return "Áo bé gái";
        case "12":
            return "Quần bé gái";
        case "14":
            return "Quần dài";
        case "13":
            return "Áo vest/blazer";
        case "15":
            return "Quần lửng/short";
        case "16":
            return "Quần dài";
        case "17":
            return "Váy bé gái";
        case "18":
            return "Chân váy bé gái";
        case "19":
            return "Phụ kiện bé gái";
        case "21":
            return "Set bộ công sở";
        case "22":
            return "Set bộ co-ords";
        case "23":
            return "Set bộ thun len";
        case "24":
            return "Phụ kiện";
        case "25":
            return "Áo bé trai";
        case "26":
            return "Quần bé trai";
        case "27":
            return "Phụ kiện bé trai";
        case "31":
            return "Chân váy bút chì";
        case "32":
            return "Chân váy chữ A";
        case "33":
            return "Chân váy jeans";
        case "41":
            return "Váy đầm nữ";
        case "42":
            return "Đầm công sở";
        case "43":
            return "Đầm voan hoa/ maxi";
        case "44":
            return "Đầm thun";
        case "45":
            return "Áo Dài";
        case "51":
            return "Senora - Đầm dạ hội";
        case "61":
            return "Đồ lót";
        case "62":
            return "Giày/dép & Sandals";
        case "63":
            return "Phụ kiện nữ";
        case "64":
            return "Túi/ ví";
            
        default:
            return "Không xác định";
    }
}
function setGroupsp(groupName) {
    switch (groupName) {
        case "Áo sơ mi":
            return "1";
        case "Áo thun":
            return "2";
        case "Áo croptop":
            return "3";
        case "Áo peplum":
            return "4";
        case "Áo thun nam":
            return "5";
        case "Áo polo":
            return "6";
        case "Áo sơ mi nam":
            return "7";
        case "Áo khoác/vest":
            return "8";
        case "Áo bé gái":
            return "11";
        case "Quần bé gái":
            return "12";
        case "Quần dài nam":
            return "14";
        case "Áo vest/blazer":
            return "13";
        case "Quần lửng/short":
            return "15";
        case "Quần dài":
            return "16";
        case "Váy bé gái":
            return "17";
        case "Chân váy bé gái":
            return "18";
        case "Phụ kiện bé gái":
            return "19";
        case "Set bộ công sở":
            return "21";
        case "Set bộ co-ords":
            return "22";
        case "Set bộ thun len":
            return "23";
        case "Phụ kiện":
            return "24";
        case "Áo bé trai":
            return "25";
        case "Quần bé trai":
            return "26";
        case "Phụ kiện bé trai":
            return "27";
        case "Chân váy bút chì":
            return "31";
        case "Chân váy chữ A":
            return "32";
        case "Chân váy jeans":
            return "33";
        case "Váy đầm nữ":
            return "41";
        case "Đầm công sở":
            return "42";
        case "Đầm voan hoa/ maxi":
            return "43";
        case "Đầm thun":
            return "44";
        case "Áo Dài":
            return "45";
        case "Senora - Đầm dạ hội":
            return "51";
        case "Đồ lót":
            return "61";
        case "Giày/dép & Sandals":
            return "62";
        case "Phụ kiện nữ":
            return "63";
        case "Túi/ ví":
            return "64";
        default:
            return "0"; // Hoặc giá trị mặc định bạn muốn đặt khi không khớp với bất kỳ nhóm nào
    }
}
function getCategoryId(categoryName) {
    const category = categoryList.find(cat => cat.ten_the_loai === categoryName);
    return category ? category.ma_so : null;
}

function getGrouptt(groupId) {
    switch (groupId) {
        case "1":
            return "<button class='btn btn-success' onclick='toggleStatus(this, event)'>Còn hàng</button>";
        case "2":
            return "<button class='btn btn-danger' onclick='toggleStatus(this, event)'>Hết hàng</button>";
        case "0":
            return "<button class='btn btn-warning' onclick='toggleStatus(this, event)'>NEW</button>";
        default:
            return "Không xác định";
    }
}


function toggleStatus(button, event) {
    event.preventDefault();
    const row = button.closest('tr');
    const ma_so = row.cells[0].innerText; // Lấy mã số từ cột đầu tiên trong hàng
    const currentStatus = row.cells[8].innerText.trim(); // Lấy trạng thái hiện tại từ cột thứ 8 trong hàng
    
    let newStatus;
    if (currentStatus === "NEW") {
        newStatus = "1"; // Chuyển từ "NEW" sang "Còn hàng"
    } else if (currentStatus === "Còn hàng") {
        newStatus = "10"; // Chuyển từ "Còn hàng" sang "Hết hàng"
    } else if (currentStatus === "Hết hàng") {
        newStatus = "1"; // Chuyển từ "Hết hàng" sang "Còn hàng"
    } else {
        console.error("Trạng thái không xác định");
        return;
    }

    fetch(`php/sanpham.php?event=update_status&ma_so=${ma_so}&trang_thai=${newStatus}`, {
        method: 'POST'
    })
    .then(response => response.text())
    .then(data => {
        console.log(data); // Log kết quả trả về từ server
        loadProducts(); // Tải lại danh sách sản phẩm sau khi cập nhật
    })
    .catch(error => console.error("Lỗi khi cập nhật trạng thái:", error));
}

function getGroupcate(groupId) {
    switch (groupId) {
        case "1":
            return "(nữ)";
        case "2":
            return "(nam)";
        default:
            return "";
    }
}

function setCategory(categoryId) {
    const select = document.querySelector('.cbtheloai');
    if (select) {
        select.value = categoryId;
    } else {
        console.error('Không tìm thấy phần tử select');
    }
}


function showSoluongsp() {
    var select = document.querySelector('.cbsoluong');
    for (var i = 5; i <= 500; i += 5) {
        var option = document.createElement("option");
        option.value = i;
        option.text = i;
        select.appendChild(option);
    }
}

let categoryList = [];

function showTheloaisp() {
    fetch('php/theloai.php?event=get_categories')
        .then(response => {
            if (!response.ok) {
                throw new Error('Có lỗi xảy ra khi lấy danh sách thể loại');
            }
            return response.json();
        })
        .then(data => {
            categoryList = data; // Lưu trữ danh sách thể loại vào biến toàn cục
            const select = document.querySelector('.cbtheloai');
            data.forEach(category => {
                const option = document.createElement("option");
                option.value = category.ma_so;
                option.text = category.ten_the_loai + " " + getGroupcate(category.nhom);
                select.appendChild(option);
            });
        })
        .catch(error => console.error('Lỗi:', error.message));
}

function getCategoryName(categoryId) {
    const category = categoryList.find(cat => cat.ma_so === categoryId);
    return category ? category.ten_the_loai : 'Không xác định';
}
function formatCurrency(amount) {
    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
}

function addAttribute(ma_so, event) {
    event.preventDefault();

    swapForm("boxthuoctinh");

    // Update breadcrumb
    var st = '<li class="breadcrumb-item"><a href="#">Danh mục</a></li>' +
             '<li class="breadcrumb-item active">Thuộc tính</li>';
    $(".breadcrumbcurrent").html(st);

    // Focus on the attribute select element
    $('.cbthuoctinhsp').focus();
    document.querySelector('.cbthuoctinhsp').disabled= true;
    document.querySelector('.cbthuoctinhsp').value = ma_so;
    // Optionally, you may add additional logic here based on your application needs
}

function swapForm(f) {
    // Hide all form boxes except the one specified by f
    $(".boxsanpham").addClass("is-hidden");
    $("." + f).removeClass("is-hidden");
}
