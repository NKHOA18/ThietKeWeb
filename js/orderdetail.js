// Check user login status and redirect accordingly
$('.btn--outline[name="btn_end"]').on('click', function() {
    // Retrieve orderId from the cart-title element
    const orderId = $('.cart-title').data('orderid');

    $.ajax({
        url: 'php/getUserInfo.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                window.location.href = 'customer/order_list.php'; // Redirect to myorder.php if logged in
            } else {
                
                showToast('Bạn chưa đăng nhập. Vui lòng đăng nhập để xem đơn hàng.'); // Show toast message
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi gửi yêu cầu: ' + xhr.responseText);
        }
    });

    // Function to display toast message and redirect after 3 seconds
    function showToast(message) {
        const toastContainer = $('#toast-container');
        const toastMessage = `<div class="toast toast-info" aria-live="polite" style="display: block;">
                                <div class="toast-message">${message}</div>
                              </div>`;

        toastContainer.html(toastMessage);
        toastContainer.show();

        // Automatically hide toast after 3 seconds
        setTimeout(function() {
            toastContainer.fadeOut();
            window.location.href = 'checkorder.php?orderId=' + orderId; // Redirect to checkorder.php with orderId
        }, 2000);
    }
});
