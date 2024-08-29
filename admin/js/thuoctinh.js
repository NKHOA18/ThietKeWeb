document.addEventListener("DOMContentLoaded", function() {
    showSanPham();
    showColor();
    showSize();
    loadAttributes();

    const addButton = document.querySelector('.them_thuoctinh');
    addButton.addEventListener('click', function() {
        addProductAttribute();
    });
});

function loadAttributes() {
    fetch("php/thuoctinh.php?event=get_attributes")
        .then(response => response.json())
        .then(data => {
            data.sort((a, b) => a.ma_san_pham.localeCompare(b.ma_san_pham));

            const tableBody = document.getElementById("tableBodytt");
            tableBody.innerHTML = "";

            const groupedAttributes = {};

            data.forEach(attribute => {
                const { ma_so, ma_san_pham, ten_san_pham, ma_mau_sac, ma_kich_co, mo_ta_them } = attribute;
                const groupKey = `${ma_san_pham}_${ma_mau_sac}`;

                if (!groupedAttributes[groupKey]) {
                    groupedAttributes[groupKey] = {
                        ma_san_pham: ma_san_pham,
                        ten_san_pham: ten_san_pham,
                        ma_mau_sac: ma_mau_sac,
                        attributes: []
                    };
                }

                groupedAttributes[groupKey].attributes.push({
                    ma_so: ma_so,
                    ma_kich_co: ma_kich_co,
                    mo_ta_them: mo_ta_them
                });
            });

            Object.keys(groupedAttributes).forEach(groupKey => {
                const group = groupedAttributes[groupKey];

                const rowGroup = document.createElement("tr");
                rowGroup.innerHTML = `
                    <td colspan="6"><strong>Mã sản phẩm: ${group.ma_san_pham}, Mã màu sắc: ${group.ma_mau_sac}</strong></td>
                `;
                tableBody.appendChild(rowGroup);

                group.attributes.sort((a, b) => a.ma_so - b.ma_so);

                group.attributes.forEach(attr => {
                    const { ma_so, ma_kich_co, mo_ta_them } = attr;

                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${group.ma_san_pham}</td>
                        <td>${group.ten_san_pham}</td>
                        <td><img src="/nkstore/assets/images/icon/0${getColor(group.ma_mau_sac)}.png" style="border : 3px solid #ccc; border-radius: 50%;"></td>
                        <td>${getSize(ma_kich_co)}</td>
                        <td>${mo_ta_them}</td>
                        <td>
                            <button class='btn btn-danger' onclick='deleteAttribute(${ma_so}, event)'>Xóa</button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            });
        })
        .catch(error => console.error("Error fetching data:", error));
}

function addProductAttribute() {
    const maSanPham = document.querySelector('.cbthuoctinhsp').value;
    const maMauSac = document.querySelector('.cbthuoctinhms').value;
    const maKichCo = document.querySelector('.cbthuoctinhkc').value;
    const dongSanPham = document.querySelector('.cbtt1').value;
    const nhomSanPham = document.querySelector('.cbtt2').value;
    const chatLieu = document.querySelector('.cbtt3').value;
    const kieuDang = document.querySelector('.cbtt4').value;
    const doDai = document.querySelector('.cbtt5').value;
    const hoaTiet = document.querySelector('.cbtt6').value;
    const moTaThem = `${dongSanPham}, ${nhomSanPham}, ${chatLieu}, ${kieuDang}, ${doDai}, ${hoaTiet}`;

    const formData = new FormData();
    formData.append('ma_san_pham', maSanPham);
    formData.append('ma_mau_sac', maMauSac);
    formData.append('ma_kich_co', maKichCo);
    formData.append('mo_ta_them', moTaThem);

    fetch('php/thuoctinh.php?event=add_attribute', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
        alert(data);
        loadAttributes();
    })
    .catch(error => console.error('Lỗi khi thêm thuộc tính sản phẩm:', error));
}

function deleteAttribute(ma_so, event) {
    event.preventDefault();

    if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này không?")) {
        fetch(`php/thuoctinh.php?event=delete_attribute&ma_so=${ma_so}`, {
            method: 'DELETE'
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            loadAttributes();
        })
        .catch(error => console.error("Lỗi khi xóa sản phẩm:", error));
    }
}

function showColor() {
    fetch('php/thuoctinh.php?event=get_colors')
        .then(response => response.json())
        .then(data => {
            const select = document.querySelector('.cbthuoctinhms');
            select.innerHTML = "";
            data.forEach(color => {
                const option = document.createElement("option");
                option.value = color.ma_so;
                option.textContent = color.ten_mau_sac;
                select.appendChild(option);
            });
        })
        .catch(error => console.error('Lỗi khi lấy danh sách màu sắc:', error.message));
}

function showSize() {
    fetch('php/thuoctinh.php?event=get_sizes')
        .then(response => response.json())
        .then(data => {
            const select = document.querySelector('.cbthuoctinhkc');
            select.innerHTML = "";
            data.forEach(size => {
                const option = document.createElement("option");
                option.value = size.ma_so;
                option.textContent = size.ten_kich_co;
                select.appendChild(option);
            });
        })
        .catch(error => console.error('Lỗi khi lấy danh sách kích cỡ:', error.message));
}

function showSanPham() {
    fetch('php/thuoctinh.php?event=get_products')
        .then(response => response.json())
        .then(data => {
            const select = document.querySelector('.cbthuoctinhsp');
            data.forEach(product => {
                const option = document.createElement("option");
                option.value = product.ma_so;
                option.textContent = product.ten_san_pham;
                select.appendChild(option);
            });
        })
        .catch(error => console.error('Lỗi khi lấy danh sách sản phẩm:', error.message));
}

function getColor(colorId) {
    return colorId < 10 ? "0" + colorId : colorId;
}

function getSize(sizeId) {
    const sizes = {
        "1": "S",
        "2": "M",
        "3": "L",
        "4": "XL",
        "5": "XXL"
    };
    return sizes[sizeId] || sizeId;
}
