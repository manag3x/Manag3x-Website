<?php use server\core\Config; $config = new Config();?>
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
    
    <link href="<?php echo $config::$res->assets->css ?>loader.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo $config::$res->assets->js ?>loader.js"></script>
    
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="<?php echo $config::$res->resource ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $config::$res->assets->css ?>plugins.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo $config::$res->plugin ?>sweetalerts/promise-polyfill.js"></script>
    <link href="<?php echo $config::$res->plugin ?>sweetalerts/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $config::$res->plugin ?>sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $config::$res->assets->css ?>components/custom-sweetalert.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $config::$res->plugin ?>font-icons/fontawesome/css/fontawesome.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="<?php // echo $config::$res->plugin
    ?>table/datatable/custom_dt_html5.css"> -->
    <link rel="stylesheet" type="text/css" href="<?php echo $config::$res->plugin ?>table/datatable/dt-global_style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $config::$res->plugin ?>table/datatable/datatables.css">
<!--    <link rel="stylesheet" type="text/css" href="--><?php //echo $config::$res->plugin ?><!--table/datatable/custom_dt_multiple_tables.css">-->
    <link href="<?php echo $config::$res->assets->css ?>components/custom-modal.css" rel="stylesheet" type="text/css">
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link rel="stylesheet" type="text/css" href="<?php echo $config::$res->plugin ?>animate/animate.css">
    <!-- <link href="<?php // echo $config::$res->custom->css ?>multi.css" rel="stylesheet" type="text/css" /> -->
    <link href="<?php echo $config::$res->custom->css ?>protocoll.css" rel="stylesheet" type="text/css" />
    <style>
        .layout-px-spacing {
            min-height: calc(100vh - 166px)!important;
        }
        .form-form .form-form-wrap form .division {
            text-align: center;
            font-size: 13px;
            margin: 19px 0 20px 0 !important;
        }
    </style>

<?php
    foreach ($css ?? [] as $css): ?><link href="<?php echo $config::$res->assets->css . $css ?>.css"
                                     rel="stylesheet"><?php endforeach;
    foreach ($custom_css ?? [] as $css): ?><link href="<?php echo $config::$res->custom->css . $css ?>.css"
                                     rel="stylesheet"><?php endforeach;
    foreach ($plugin_css ?? [] as $css): ?><link href="<?php echo $config::$res->plugin . $css ?>.css"
                                            rel="stylesheet"><?php endforeach;
?>
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
</head>
<body class="<?php echo $body_class ?>" <?php echo $body_attr ?>>
<?php 
    if(isset($page_type) and ($page_type == "auth" or $page_type == "error")) return;
    require_once "vars.inc"; 
    require_once "top_nav.inc"; 
?>