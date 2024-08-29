document.addEventListener("DOMContentLoaded", function() {
    loadCtdonhangs();
});

function loadCtdonhangs() {
    fetch("php/donhang.php")
        .then(response => response.json())
        .then(data => {
            renderTable(data); // Hiển thị bảng
            renderChart(data); // Hiển thị biểu đồ
        })
        .catch(error => console.error("Lỗi khi lấy dữ liệu:", error));
}

function renderTable(data) {
    const tableBody = document.getElementById("tableBodythongke");
    tableBody.innerHTML = ""; // Xóa nội dung cũ của bảng trước khi cập nhật

    data.forEach(ctdonhang => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${ctdonhang.ma_san_pham}</td>
            <td><img src="../${ctdonhang.hinh_anh}" style="max-width: 120px;"></td>
            <td>${ctdonhang.ten_san_pham}</td>
            <td>${ctdonhang.ma_the_loai}</td>
            <td>${ctdonhang.ngay_tao}</td>
            <td>${ctdonhang.so_luong}</td>
            <td>${ctdonhang.gia}</td>
            
        `;
        tableBody.appendChild(row);
    });
}


function processDataForChart(data) {
    const productNames = []; // Lưu trữ tên sản phẩm
    const quantities = []; // Lưu trữ số lượng sản phẩm
    const prices = []; // Lưu trữ giá sản phẩm

    // Tính tổng số lượng và giá sản phẩm theo từng tên sản phẩm
    data.forEach(item => {
        const index = productNames.findIndex(p => p === item.ten_san_pham);
        if (index === -1) {
            productNames.push(item.ten_san_pham);
            quantities.push(parseInt(item.so_luong)); // Chuyển đổi số lượng từ chuỗi sang số nguyên
            prices.push(parseInt(item.gia)); // Chuyển đổi giá từ chuỗi sang số nguyên
        } else {
            quantities[index] += parseInt(item.so_luong);
            prices[index] += parseInt(item.gia);
        }
    });

    return {
        productNames: productNames,
        quantities: quantities,
        prices: prices
    };
}

// Hàm render biểu đồ
function renderChart(data) {
    const chartData = processDataForChart(data);

    const ctx = document.getElementById("myChart").getContext("2d");

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartData.productNames,
            datasets: [
                {
                    label: 'Số lượng bán ra của sản phẩm',
                    data: chartData.quantities,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Tổng doanh thu của sản phẩm (VNĐ)',
                    data: chartData.prices,
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

