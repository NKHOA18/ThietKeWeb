document.addEventListener("DOMContentLoaded", function() {
    loadOrders();
});

function loadOrders() {
    fetch("php/order.php?event=get_orders")
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById("tableBodyorder");
            tableBody.innerHTML = ""; // Xóa nội dung cũ của bảng trước khi cập nhật
            data.forEach(order => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${order.ma_so}</td>
                    <td>${order.ten_nguoi_dung}</td>
                    <td>${order.so_dien_thoai}</td>
                    <td>${order.dia_chi}</td>
                    <td>${order.ngay_tao}</td>
                    <td>${getStatus(order.trang_thai_thanh_toan)}</td>
                    <td>
                        <select class="form-control rounded disable-select-${order.ma_so}" onchange="markSelect(${order.ma_so})">
                            <option value="0" ${order.trang_thai_don_hang == 0 ? 'selected' : ''}>Đặt hàng thành công</option>
                            <option value="1" ${order.trang_thai_don_hang == 1 ? 'selected' : ''}>Đang xử lý</option>
                            <option value="2" ${order.trang_thai_don_hang == 2 ? 'selected' : ''}>Chờ giao vận</option>
                            <option value="3" ${order.trang_thai_don_hang == 3 ? 'selected' : ''}>Đã gửi</option>
                            <option value="4" ${order.trang_thai_don_hang == 4 ? 'selected' : ''}>Đã nhận hàng</option>
                            <option value="5" ${order.trang_thai_don_hang == 5 ? 'selected' : ''}>Đã hủy</option>
                            <option value="6" ${order.trang_thai_don_hang == 6 ? 'selected' : ''}>Trả hàng</option>
                        </select>
                        <button class="btn btn-primary" onclick='updateOrderStatus(${order.ma_so})'><i class="fa fa-wrench"></i></button>
                    </td>
                    <td><a href="/nkstore/orderdetail.php?orderId=${order.ma_so}">Detail</a></td>
                    <td>
                        <button class='btn btn-danger' onclick='deleteOrder(${order.ma_so})'>Xóa</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        })
        .catch(error => console.error("Lỗi khi lấy dữ liệu:", error));
}

function updateOrderStatus(orderId) {
    const selectElement = document.querySelector(`.disable-select-${orderId}`);
    const status = selectElement.value;
    
    fetch("php/order.php?event=update_orderstatus", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `ma_so=${orderId}&trang_thai_don_hang=${status}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log("Cập nhật trạng thái đơn hàng thành công.");
            selectElement.disabled = true;
        } else {
            console.error("Lỗi khi cập nhật trạng thái đơn hàng: " + data.message);
        }
    })
    .catch(error => console.error("Lỗi khi cập nhật trạng thái đơn hàng:", error));
}

function deleteOrder(orderId) {
    if (confirm("Bạn có chắc chắn muốn xóa đơn hàng này không?")) {
        fetch(`php/order.php?event=check_orderdetails&ma_so=${orderId}`)
            .then(response => response.json())
            .then(data => {
                if (data.hasOrderdetails) {
                    const orderdetailCount = data.orderdetail_count;
                    if (confirm(`Đơn hàng này đang có ${orderdetailCount} sản phẩm tham chiếu. Bạn phải xóa các sản phẩm đó, bạn vẫn muốn tiếp tục?`)) {
                        fetch(`php/order.php?event=delete_orderdetails&ma_so=${orderId}`, {
                            method: 'POST',
                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded"
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                console.log(data.message);
                                return fetch(`php/order.php?event=delete_order&ma_so=${orderId}`, {
                                    method: 'POST',
                                    headers: {
                                        "Content-Type": "application/x-www-form-urlencoded"
                                    }
                                });
                            } else {
                                throw new Error(data.message);
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                console.log(data.message);
                                alert(data.message);
                                loadOrders();
                            } else {
                                throw new Error(data.message);
                            }
                        })
                        .catch(error => console.error('Lỗi khi xóa thể loại:', error.message));
                    }
                } else {
                    fetch(`php/order.php?event=delete_order&ma_so=${orderId}`, {
                        method: 'POST',
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log(data.message);
                            alert(data.message);
                            loadOrders();
                        } else {
                            throw new Error(data.message);
                        }
                    })
                    .catch(error => console.error('Lỗi khi xóa thể loại:', error.message));
                }
            })
            .catch(error => console.error('Lỗi khi kiểm tra sản phẩm:', error.message));
    }
}

function getStatus(statusId) {
    switch (statusId) {
        case "1":
            return "Thanh toán bằng thẻ VISA";
        case "2":
            return "Thanh toán bằng ATM";
        case "3":
            return "Thanh toán bằng MOMO";
        case "4":
            return "Thanh toán khi giao hàng";
        default:
            return "Chưa thanh toán";
    }
}
