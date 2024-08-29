$(document).ready(function(){
    swapForm("boxkhachhang");
    $(".menu-taikhoan").click(function(){
        swapForm("boxkhachhang");
        var st='<li class="breadcrumb-item"><a href="#" >Danh mục</a></li>'+
        '<li class="breadcrumb-item active">Account</li>';

        loadUsers();
        
    })

    $(".menu-sanpham").click(function() {
        swapForm("boxsanpham");

        var st = '<li class="breadcrumb-item"><a href="#">Danh mục</a></li>' +
                 '<li class="breadcrumb-item active">Sản phẩm</li>';
        $(".breadcrumb").html(st);
        // showSoluongsp();
        // showTheloaisp();
        loadProducts(); 
    });
    

    $(".menu-theloai").click(function(){
        swapForm("boxtheloai");
        var st='<li class="breadcrumb-item"><a href="#" >Danh mục</a></li>'+
        '<li class="breadcrumb-item active">the loai</li>';
        //console.log(st);
         $(".breadcrumbcurrent").html(st);
         $(".them_nuoc").prop("disabled",false);
         $(".sua_nuoc").prop("disabled",true);
         $(".luu_nuoc").prop("disabled",true);
         showDGN();
         showDataTablenuocpage(0,record);
    })

    $(".menu-mausac").click(function(){
        swapForm("boxmausac");
        var st='<li class="breadcrumb-item"><a href="#" >Danh mục</a></li>'+
        '<li class="breadcrumb-item active">màu sắc</li>';
        $(".breadcrumbcurrent").html(st);
        //console.log(st);
        loadColors();
    })
    

    $(".menu-kichco").click(function(){
        swapForm("boxkichco");
        var st='<li class="breadcrumb-item"><a href="#" >Danh mục</a></li>'+
        '<li class="breadcrumb-item active">Phong</li>';
        //console.log(st);
        $(".breadcrumbcurrent").html(st);

        loadSizes();
    })

    $(".menu-donhang").click(function(){
        swapForm("boxdonhang");
        var st='<li class="breadcrumb-item"><a href="#" >Danh mục</a></li>'+
        '<li class="breadcrumb-item active">Đơn hàng</li>';
        loadOrders();
        
    })

    $(".menu-bstanh").click(function(){
        swapForm("boxbstanh");
        var st='<li class="breadcrumb-item"><a href="#" >Danh mục</a></li>'+
        '<li class="breadcrumb-item active">Bộ sưu tập ảnh</li>';
        //console.log(st);
    
    })

    $(".menu-thuoctinh").click(function(){
        swapForm("boxthuoctinh");
        var st='<li class="breadcrumb-item"><a href="#" >Danh mục</a></li>'+
        '<li class="breadcrumb-item active">thuộc tính</li>';
         $(".breadcrumbcurrent").html(st);
      
    })



  

    $(".menu-hoadonP").click(function(){
        swapForm("boxhoadonP");
        var st='<li class="breadcrumb-item"><a href="#" >Thống kê</a></li>'+
        '<li class="breadcrumb-item active">Thống kê sản phẩm</li>';
        //console.log(st);
         $(".breadcrumbcurrent").html(st);
        
    })
    $(".menu-hdban").click(function(){
        swapForm("boxhdban");
        var st='<li class="breadcrumb-item"><a href="#" >Thống kê/a></li>'+
        '<li class="breadcrumb-item active">Tài khoản</li>';
        //console.log(st);
         $(".breadcrumbcurrent").html(st);
         $(".them_hdban").prop("disabled",false);
         $(".sua_hdban").prop("disabled",true);
         $(".luu_hdban").prop("disabled",true);
         showSLhdban();
         showmakhhdban();
         showDataTablehdbanpage(0,record);
    })
    


    
    

    
    function swapForm(f){
        
        $(".boxdonhang").addClass("is-hidden");
        $(".boxsanpham").addClass("is-hidden"); 
        $(".boxkhachhang").addClass("is-hidden");
        $(".boxtheloai").addClass("is-hidden");
        $(".boxkichco").addClass("is-hidden");
        $(".boxbstanh").addClass("is-hidden");
        $(".boxthuoctinh").addClass("is-hidden");
        $(".boxthuekichco").addClass("is-hidden");
        $(".boxhoadonP").addClass("is-hidden");
        $(".boxhdban").addClass("is-hidden");
        $(".boxmausac").addClass("is-hidden");
        $("."+f).removeClass("is-hidden");
    }
    $(".btnhome").click(function(){
        swapForm("boxkhachhang");
        var st=' <li class="breadcrumb-item"><a href="#" >Danh mục</a></li>'+
        ' <li class="breadcrumb-item active">nhân viên</li>';
        console.log(st);
        $(".breadcrumbcurrent").html(st);
    });
});