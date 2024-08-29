var counter =1;
setInterval(function(){
    document.getElementById('radio' + counter).checked = true;
    counter++;
    if(counter>4){
        counter=1;
    }
},10000);
$(document).ready(function(){
    $('.toggle').click(function(){
        $('.main-menu').slideToggle();
        $('.logo')
    })
})












