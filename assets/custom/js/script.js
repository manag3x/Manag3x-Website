
$(document).ready(function(){
    // console.log(route_ctrl);
    CusWind.config({
        align: "center",
        closeOnBlur: false
    }); // osModal configuration

    $(function(){
        setTimeout(()=>{
            $('.toast').toast('show');
        },4000)
    })

    $(".notifyAnchor_").click(function(e){
        e.preventDefault();
        let id = $(this).data("id");
        let user = $("#pageType").val();
        markAsRead(id,()=>{
            location.href = user+"/"+$(this).data("link");
        });
    })


    $("#logout").click(function(e){
        e.preventDefault();
        let route = $(this).data("url")
        confirm(this,route);
    })

    $("#cPass").click(function(e){
        e.preventDefault();
        // console.log($(this).data("view"))
        modalView(this,"",()=>{
            $("#sendID").val($(this).data("id"));
        });
    })
})

