<?php
if(!isset($_GET["auth"]) and isset($_GET["u"])){
    header("location","../");
    exit();
}
$DIR = "../";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Verification</title>
    <link href="<?php echo $config::$res->plugin ?>sweetalerts/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $config::$res->plugin ?>sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $config::$res->assets->css ?>components/custom-sweetalert.css" rel="stylesheet" type="text/css" />
</head>
<body class="bg-light pt-5" style="height:100%">
<input type="hidden" id="id" name="id" value="<?php echo @$_GET['u'] ?>">
<input type="hidden" id="tok" name="username" value="<?php echo @$_GET['auth'] ?>">
<input type="hidden" id="url" name="url" value="<?php echo server\core\Config::$user->ctrl.(new server\core\Helper())::crypt('auth/authenticate') ?>">
<script src="<?php echo $config::$res->custom->js ?>osai.js"></script>
<script src="<?php echo $config::$res->custom->js ?>CONSTANTS.js"></script>
<script src="<?php echo $config::$res->assets->js ?>libs/jquery-3.1.1.min.js"></script>
<script src="<?php echo $config::$res->plugin ?>sweetalerts/sweetalert2.min.js"></script>
<script src="<?php echo $config::$res->plugin ?>sweetalerts/custom-sweetalert.js"></script>
<script>
    $(document).ready(function(){
        let id = $("#id").val()
        let auth = $("#tok").val()
        let url = $("#url").val()
        $.ajax({
            url: url,
            method:'POST',
            data:{id:id,username:auth},
            dataType: "JSON",
            beforeSend: function(){
                $preloader("show");
            },
            success: function(data){
                $preloader("hide");
                if(data.valid == 1){
                    swal({
                        title: 'Verified!',
                        text: data.message,
                        type: 'success',
                        padding: '2em'
                    })
                }else{
                    swal({
                        title: 'Error!',
                        text: data.message,
                        type: 'error',
                        padding: '2em'
                    })
                }
                setTimeout(()=>{location.href = data.link},6000);
            }
        });

    })
</script>
</body>
</html>


