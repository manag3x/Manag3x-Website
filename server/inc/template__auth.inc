<div class="bg-overlay"></div>
<div class="form-container outer">
    <div class="form-form">
        <div class="form-form-wrap">
            <div class="form-container">
                <div class="form-content shadow">
                    <!-- <a href="<?php //echo $config::$site->base ?>"><img src="<?php //echo $config::$site->logo ?>" class="img-fluid" alt="Site Logo"></a> -->
                    <h1 class=""><?php echo $page_title ?></h1>
                    <p class=""><?php echo $page_salute ?></p>
                    <?php 
                        $targ = isset($_GET['i']) ? "reg" : "login";
                    ?>
                    <form method="post" id="fm" class="text-left">
                        <div class="form"><?php echo $page_body ?></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>