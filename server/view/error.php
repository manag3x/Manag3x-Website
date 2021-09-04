<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 mr-auto mt-5 text-md-left text-center">
            <a href="<?php echo $config::$site->base . $page_root ?>" class="ml-md-5">
                <img alt="image-404" src="<?php echo $config::$site->logo ?>" class="site-logo">
            </a>
        </div>
    </div>
</div>
<div class="container-fluid error-content">
    <div class="">
        <?php echo $error_body ?>
        <a href="#" class="btn btn-primary mt-5 go-back">Go Back</a>
    </div>
</div>
<script>
    document.querySelector(".go-back").addEventListener("click", e => {
        e.preventDefault()
        history.back()
    })
    window.onpopstate = () => location.reload()
</script>