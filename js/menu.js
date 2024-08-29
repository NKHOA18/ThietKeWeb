document.addEventListener("DOMContentLoaded", function() {
    loadCategories();

});

function loadCategories() {
    fetch("/nkstore/admin/php/theloai.php?event=get_categories")
        .then(response => response.json())
        .then(data => {
            data.forEach(category => {
                let categoryElement = getCategoryElement(category.nhom, category.ma_so);
                if (categoryElement) {
                    categoryElement.innerHTML += `<li><a href="/nkstore/cartegory.php?category=${category.ma_so}">${category.ten_the_loai}</a></li>`;
                }
            });
        })
        .catch(error => console.error("Lỗi khi lấy dữ liệu:", error));
}

function getCategoryElement(nhom, ma_so) {
    let categoryElement;

    switch (nhom) {
        case '1': // Danh mục NỮ
            categoryElement = getSubMenuElement('.category-nu', ma_so, 10, 7);
            break;
        case '2': // Danh mục NAM
            categoryElement = getSubMenuElement('.category-nam', ma_so, 10, 4);
            break;
        case '3': // Danh mục bé nam
            categoryElement = ma_so >= 20 && ma_so < 30 ? document.querySelector('.category-treem .item-sub-menu:nth-child(3) ul') : null;
            break;
        case '4': // Danh mục bé gái
            categoryElement = ma_so >= 10 && ma_so < 20 ? document.querySelector('.category-treem .item-sub-menu:nth-child(2) ul') : null;
            break;
        default:
            categoryElement = null;
            break;
    }

    return categoryElement;
}

function getSubMenuElement(selector, ma_so, range, subMenuCount) {
    for (let i = 1; i <= subMenuCount; i++) {
        if (ma_so < range * i) {
            return document.querySelector(`${selector} .item-sub-menu:nth-child(${i}) ul`);
        }
    }
    return null;
}

$(document).ready(function() {
    updateCartItemCount();
});

function updateCartItemCount() {
    $.ajax({
        type: 'GET',
        url: '/nkstore/php/getCartCount.php',
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