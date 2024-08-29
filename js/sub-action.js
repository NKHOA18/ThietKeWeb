document.addEventListener('DOMContentLoaded', function() {
    function getCookie(name) {
        let cookieArr = document.cookie.split(";");
        for (let i = 0; i < cookieArr.length; i++) {
            let cookiePair = cookieArr[i].split("=");
            if (name === cookiePair[0].trim()) {
                return decodeURIComponent(cookiePair[1]);
            }
        }
        return null;
    }

    function deleteCookie(name) {
        document.cookie = name + '=; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT;';
    }

    function showToast(message) {
        const toastContainer = $('#toast-container');
        const toastMessage = `<div class="toast toast-info" aria-live="polite" style="display: block;">
                                <div class="toast-message">${message}</div>
                              </div>`;

        toastContainer.html(toastMessage);
        toastContainer.show();

        // Tự động ẩn toast sau 3 giây
        setTimeout(function() {
            toastContainer.fadeOut();
        }, 3000);
    }

    var accountCookie = getCookie('account');
    var userIcon = document.getElementById('user-icon');
    var subActionMenu = document.getElementById('sub-action-menu');
    var logoutButton = document.querySelector('.fa-sign-out').closest('li');

    if (userIcon) {
        userIcon.addEventListener('click', function(event) {
            event.preventDefault();
            if (accountCookie) {
                subActionMenu.classList.toggle('show');
            } else {
                window.location.href = 'login.html';
            }
        });
    }

    document.addEventListener('click', function(event) {
        if (!userIcon.contains(event.target) && !subActionMenu.contains(event.target)) {
            subActionMenu.classList.remove('show');
        }
    });

    if (logoutButton) {
        logoutButton.addEventListener('click', function(event) {
            event.preventDefault();
            subActionMenu.classList.remove('show');
            deleteCookie('account');
            deleteCookie('password');
            window.location.href = '/nkstore/login.html';
        });
    }

    var btnWishlist = document.querySelector('.btn--wishlist');

    if (btnWishlist) {
        btnWishlist.addEventListener('click', function(event) {
            event.preventDefault();

            if (!accountCookie) {
                showToast('Bạn cần đăng nhập để thực hiện chức năng này!');
                return;
            }

            var productId = btnWishlist.getAttribute('data-id');
            var action = $(btnWishlist).find('.fa').hasClass('fa-heart') ? 'remove' : 'add';

            $.ajax({
                type: 'POST',
                url: 'php/addToFavorites.php', // Đường dẫn tới file PHP xử lý
                data: { productId: productId, action: action }, // Dữ liệu gửi đi
                success: function(response) {
                    console.log('Success:', response);
                    if (!response.status) {
                        if (action === 'add') {
                            $(btnWishlist).find('.fa').removeClass('fa-heart-o').addClass('fa-heart');
                            showToast('Đã thêm vào yêu thích!');
                        } else {
                            $(btnWishlist).find('.fa').removeClass('fa-heart').addClass('fa-heart-o');
                            showToast('Đã xóa khỏi yêu thích!');
                        }
                    } else {
                        showToast(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    }

    
});
