$(document).ready(function(){
    $(".year").text(new Date().getFullYear());
    let isHamburger = true;
    $('.menu-toggle').click(function(){

        $("nav").toggleClass("active");

        if (isHamburger) {
            // console.log(1);
            $('.menu-toggle i').attr("class","fa fa-times");
            isHamburger = false;
        }
        else {
            // console.log(2);
            $('.menu-toggle i').attr("class","fa fa-bars");
            isHamburger = true;
        }
    })
})