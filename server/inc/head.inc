<?php $config = new server\core\Config(); ?>
<!DOCTYPE html>
<html lang="en">
    <base href="<?php echo $config::$site->base ?>" id="app-root-base">
    <title><?php if(isset($page_title) and $page_title != "Homepage") echo $page_title . " :: "; echo $config::$site->name_full
        ?></title>
    <meta charset="utf-8">
    <meta name="description" class="pageDescription" content="<?php echo $page_desc ?? ""; ?>">
    <meta name="author" content="<?php echo $config::$site->author ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="theme-color" content="<?php echo $config::$site->pry_color ?>">
    <meta name="msapplication-navbutton-color" content="<?php echo $config::$site->pry_color ?>">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta property="og:title" class="pageTitleOG" content="<?php echo $page_title ?? ""; ?>">
    <meta property="og:url" id="website-page-url" content="<?php echo $page_url ?? ""; ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?php echo $config::$site->name ?>">
    <meta property="og:description" class="pageDescription" content="<?php echo $page_desc ?? ""; ?>">
    <meta property="og:image" content="<?php echo $config::$site->logo ?>">
    <meta itemprop="name" class="pageTitleOG" content="<?php echo $page_title ?? ""; ?>">
    <meta itemprop="description" class="pageDescription" content="<?php echo $page_desc ?? ""; ?>">
    <meta itemprop="image" content="<?php echo $config::$site->logo ?>">
    <link rel="icon" type="image/x-icon" href="<?php echo $config::$site->icon ?? ""; ?>">
    
    <!-- <link href="<?php // echo $config::$assets->css ?>loader.css" rel="stylesheet" type="text/css" /> -->
    <!-- <script src="<?php //echo $config::$assets->js ?>loader.js"></script> -->
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="<?php echo $config::$assets->plugin ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo $config::$assets->plugin ?>sweetalerts/promise-polyfill.js"></script>
    <link href="<?php echo $config::$assets->plugin ?>sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $config::$assets->plugin ?>fonts/fontawesome/css/fontawesome.min.css">
    <link href="<?php echo $config::$assets->css ?>structure.css" rel="stylesheet" type="text/css" class="structure" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    
    <style>
        .form-form .form-form-wrap form .division {
            text-align: center;
            font-size: 13px;
            margin: 19px 0 20px 0 !important;
        }
        .navbar .navbar-item.navbar-dropdown {
            margin-left: auto;
        }
        .layout-px-spacing {
            min-height: calc(100vh - 145px)!important;
        }
    </style>

<?php
    foreach ($css ?? [] as $css): ?><link href="<?php echo $config::$assets->css . $css ?>.css" rel="stylesheet">
    <?php endforeach;
    foreach ($custom_css ?? [] as $css): ?><link href="<?php echo $config::$assets->custom->css . $css ?>.css"
    rel="stylesheet"><?php endforeach;
    foreach ($plugin_css ?? [] as $css): ?><link href="<?php echo $config::$assets->plugin . $css ?>.css"
    rel="stylesheet"><?php endforeach;
?>
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
</head>
<body class="<?php echo $body_class ?> sidebar-noneoverflow starterkit" <?php echo $body_attr ?>>
<?php 
    if(isset($page_type) and ($page_type == "auth" or $page_type == "error")) return;
    require_once "vars.inc"; 
    require_once "top_nav.inc"; 
?>