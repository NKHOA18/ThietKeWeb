document.addEventListener("DOMContentLoaded", function() {
    // Tải danh sách sản phẩm và thể loại khi trang được tải lên
    showSanPhams();
    loadImages();

    const addButton = document.querySelector('.them_bstanh');
    addButton.addEventListener('click', function() {
        addImage(); // Gọi hàm để thêm sản phẩm mới
    });
});

function loadImages() {
    fetch("php/bstanh.php?event=get_images")
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById("tableBodybstanh");
            tableBody.innerHTML = ""; // Clear the table body before updating

            // Group images by ma_san_pham
            const groupedImages = {};
            data.forEach(image => {
                if (!groupedImages[image.ma_san_pham]) {
                    groupedImages[image.ma_san_pham] = { ten_san_pham: image.ten_san_pham, images: [] };
                }
                groupedImages[image.ma_san_pham].images.push(image);
            });

            // Iterate over each group and display in the table
            Object.keys(groupedImages).forEach(ma_san_pham => {
                const row = document.createElement("tr");

                // Create cell for ma_san_pham
                const tdMaSo = document.createElement("td");
                tdMaSo.textContent = ma_san_pham;
                row.appendChild(tdMaSo);

                // Create cell for ten_san_pham
                const tdTenSanPham = document.createElement("td");
                tdTenSanPham.textContent = groupedImages[ma_san_pham].ten_san_pham;
                row.appendChild(tdTenSanPham);

                // Create cell for images
                const tdImages = document.createElement("td");
                tdImages.className = "d-flex flex-wrap justify-content-start align-items-center"; // Flexbox alignment

                groupedImages[ma_san_pham].images.forEach(image => {
                    // Create container for image and delete button
                    const container = document.createElement("div");
                    container.className = "image-container position-relative"; // Styling for image container

                    // Create image element
                    const img = document.createElement("img");
                    img.src = `../${image.hinh_anh}`;
                    container.appendChild(img);

                    // Create overlay for delete action
                    const overlay = document.createElement("div");
                    overlay.className = "overlay";
                    overlay.onclick = function(event) {
                        deleteImage(image.ma_so, event);
                    };

                    // Create trash icon
                    const trashIcon = document.createElement("i");
                    trashIcon.className = "fa fa-trash";
                    overlay.appendChild(trashIcon);

                    // Append elements to container
                    container.appendChild(overlay);
                    tdImages.appendChild(container);
                });

                row.appendChild(tdImages);

                // Append row to table body
                tableBody.appendChild(row);
            });
        })
        .catch(error => console.error("Error fetching data:", error));
}






function addImage() {
    const ma_san_pham = document.querySelector('.cbtensanpham').value;
    const hinh_anh = document.querySelector('.txtbstanh').files[0]; // Lấy tệp hình ảnh từ input type=file

    // Tạo đối tượng dữ liệu FormData để gửi dữ liệu POST
    const formData = new FormData();
    formData.append('ma_san_pham', ma_san_pham);
    formData.append('hinh_anh', hinh_anh);

    // Gửi yêu cầu POST đến server để thêm sản phẩm ảnh
    fetch('php/bstanh.php?event=add_image', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log(data); // Log kết quả trả về từ server
        alert(data); // Thông báo khi thêm thành công
        document.querySelector('.txtbstanh').value = ""; // Đặt lại giá trị của input type=file

        // Sau khi thêm thành công, tải lại danh sách sản phẩm ảnh
        loadImages();
    })
    .catch(error => console.error('Lỗi khi thêm sản phẩm ảnh:', error));
}

function deleteImage(ma_so, event) {
    event.preventDefault(); // Ngăn chặn hành động mặc định của button

    if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này không?")) {
        fetch(`php/bstanh.php?event=delete_image&ma_so=${ma_so}`, {
            method: 'DELETE'
        })
        .then(response => response.text())
        .then(data => {
            alert(data); // Thông báo kết quả trả về từ server
            loadImages(); // Tải lại danh sách sản phẩm ảnh sau khi xóa
        })
        .catch(error => console.error("Lỗi khi xóa sản phẩm ảnh:", error));
    }
}

function showSanPhams() {
    fetch('php/bstanh.php?event=get_productss')
        .then(response => response.json())
        .then(data => {
            const select = document.querySelector('.cbtensanpham');
            data.forEach(products => {
                const option = document.createElement("option");
                option.value = products.ma_so;
                option.textContent = products.ten_san_pham;
                select.appendChild(option);
            });
        })
        .catch(error => console.error('Lỗi khi lấy danh sách sản phẩm:', error.message));
}
