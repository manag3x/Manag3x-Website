<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="<?php echo $config::$res->custom->js ?>osai.js"></script>
<script src="<?php echo $config::$res->custom->js ?>CONSTANTS.js"></script>
<script src="<?php echo $config::$res->assets->js ?>libs/jquery-3.1.1.min.js"></script>
<script src="<?php echo $config::$res->resource ?>bootstrap/js/popper.min.js"></script>
<script src="<?php echo $config::$res->resource ?>bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo $config::$res->plugin ?>perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="<?php echo $config::$res->assets->js ?>app.js"></script>
<script>
    $(document).ready(function() {
        App.init();
    });
</script>
<script src="<?php echo $config::$res->plugin ?>highlight/highlight.pack.js"></script>
<script src="<?php echo $config::$res->assets->js ?>custom.js"></script>

<?php 
    if($page_type == "auth"){
        ?>
        <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '365163778532806',
                cookie     : true,
                xfbml      : true,
                version    : 'v11.0'
            });
            
            FB.AppEvents.logPageView();   
            
        };
        //load sdk
        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        // // Facebook login with JavaScript SDK
        // $("#fbloginA").click(function(e)) {
        //     e.preventDefault();
        //     FB.login(function (response) {
        //         if (response.authResponse) {
        //             // Get and display the user profile data
        //             getFbUserData();
        //         } else {
        //             let msg = "User cancelled login or did not fully authorize.";
        //             osNote(msg,"error",{ position: "center", duration: "pin"});
        //         }
        //     }, {scope: 'email'});
        // })
        </script>
        <?php
    }
       
?>
<script src="<?php echo $config::$res->plugin ?>sweetalerts/sweetalert2.min.js"></script>
<script src="<?php echo $config::$res->plugin ?>sweetalerts/custom-sweetalert.js"></script>
<script src="<?php echo $config::$res->plugin ?>table/datatable/datatables.js"></script>
<script src="<?php echo $config::$res->custom->js ?>content.js"></script>
<script src="<?php echo $config::$res->custom->js ?>protocoll.js"></script>
<script src="<?php echo $config::$res->custom->js ?>script.js"></script>
<script src="<?php echo $config::$res->custom->js ?>multi.js"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
<?php
    foreach ($js as $script): ?> <script src="<?php echo $config::$res->assets->js . $script ?>.js"></script> <?php endforeach;
    foreach ($custom_js as $script): ?> <script src="<?php echo $config::$res->custom->js .$script ?>.js"></script> <?php endforeach;
    foreach ($plugin_js as $script): ?> <script src="<?php echo $config::$res->plugin .$script ?>.js"></script> <?php endforeach;
?>
<!-- <script src="<?php //echo $config::$res->plugin ?>apex/apexcharts.min.js"></script>
<script src="<?php //echo $config::$res->assets->js ?>widgets/modules-widgets.js"></script> -->
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->


<!-- <script src="<?php // echo $config::$res->plugin ?>blockui/custom-blockui.js"></script> -->
<!-- <script src="<?php // echo $config::$res->plugin ?>blockui/jquery.blockUI.min.js"></script> -->
