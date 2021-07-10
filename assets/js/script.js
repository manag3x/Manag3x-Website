$(document).ready(function(){
    $(".year").text(new Date().getFullYear());
    let isHamburger = true;
    $('.menu-toggle').click(function(){

        $("nav").toggleClass("active");

        if (isHamburger) {
            $('.menu-toggle i').attr("class","fa fa-times");
            isHamburger = false;
        }
        else {
            $('.menu-toggle i').attr("class","fa fa-bars");
            isHamburger = true;
        }
        
        
    })
}
    )