<?php
use server\core\View;

function view(string $view,$user = "client") : void {
    switch ($view) {
        default: View::render("error",["error",
            "page_title" => '{'.$view.'} Page not Found - Error 404',
            "page_view" => "error",
            "css" => ["pages/error/style-400"],
            "body_class" => "error404 text-center",
            "core_script" => false,
            "page_type" => "error",
            "error_root" => "client/",
            "error_code" => "404",
            "page_type_root" => "client/",
            "page_root" => "client",
        ]); break;
        case "dashboard" :
            View::render($view,[
            "crumbs" => [
                ["page_title" => "Dashboard"],
            ],
            "page_title" => "Dashboard",
            "page_type" => "client",
            "page_view" =>  "dashboard",
            "plugin_css" => ["apex/apexcharts"],
            "plugin_js" => ["apex/apexcharts.min"],
            "css" => ["widgets/modules-widgets","components/custom-modal"],
            // "js" => ["client/dashboard"],
            "custom_js" => ["client/dashboard"]
        ]);
        break;
        case "project" :
            View::render($view,[
                "page_title" => "Campaigns",
                "page_type" => "client",
                "page_view" =>  "project",
                "css" => ["components/custom-list-group"],
                "custom_css" => ["multi"],
                "plugin_css" => ["select2/select2.min"],
                "custom_js" => ["client/project","moment.min"],
                "plugin_js" => ["select2/select2.min","bootstrap-multiselect/bootstrap-multiselect.min"],
            ]);
        break;
        case "inventory" :
            View::render($view,[
                "page_title" => "Website Inventory",
                "page_type" => "client",
                "page_view" =>  "inventory",
                "css" => ["components/custom-list-group"],
                "custom_css" => ["multi"],
                "plugin_css" => ["select2/select2.min"],
                "custom_js" => ["admin/inventory","moment.min","chat"],
                "plugin_js" => ["select2/select2.min","bootstrap-multiselect/bootstrap-multiselect.min"],
            ]);
        break;
        case "recommended" :
            View::render($view,[
                "page_title" => "Recommended Website",
                "page_type" => "client",
                "page_view" =>  "recommended",
                "css" => ["components/custom-list-group"],
                "custom_css" => ["multi"],
                "plugin_css" => ["select2/select2.min"],
                "custom_js" => ["admin/inventory","moment.min","chat"],
                "plugin_js" => ["select2/select2.min","bootstrap-multiselect/bootstrap-multiselect.min"],
            ]);
        break;
        case "order" :
            View::render($view,[
                "page_title" => "Order",
                "page_type" => "client",
                "page_view" =>  "order",
                "css" => ["components/custom-list-group","components/tabs-accordian/custom-tabs"],
                "js" => [],
                "plugin_css" => ["select2/select2.min"],
                "custom_js" => ["admin/create-task","moment.min"],
                "plugin_js" => ["select2/select2.min","bootstrap-multiselect/bootstrap-multiselect.min"],
            ]);
        break;
        case "content" :
            View::render($view,[
                "page_title" => "Order Content",
                "page_type" => "client",
                "page_view" =>  "content",
                "css" => ["components/custom-list-group","components/tabs-accordian/custom-tabs"],
                "js" => [],
                "plugin_css" => ["select2/select2.min"],
                "custom_js" => ["client/order-content","moment.min"],
                "plugin_js" => ["select2/select2.min","bootstrap-multiselect/bootstrap-multiselect.min"],
            ]);
        break;
        case "articles" :
            View::render($view,[
                "page_title" => "Articles",
                "page_type" => "client",
                "page_view" =>  "articles",
                "css" => ["components/custom-list-group","components/tabs-accordian/custom-tabs"],
                "js" => [],
                "plugin_css" => ["select2/select2.min"],
                "custom_js" => ["articles","moment.min"],
                "plugin_js" => ["select2/select2.min","bootstrap-multiselect/bootstrap-multiselect.min"],
            ]);
        break;
        case "tasks" :
            View::render($view,[
                "page_title" => "All Tasks",
                "page_type" => "client",
                "page_view" =>  "tasks",
                "css" => ["components/custom-list-group"],
                "custom_css" => ["multi"],
                "plugin_css" => ["select2/select2.min"],
                "custom_js" => ["admin/task","moment.min"],
                "plugin_js" => [],
            ]);
        break;
        case "a-task" :
            View::render($view,[
                "page_title" => "Active Tasks",
                "page_type" => "client",
                "page_view" =>  "a-task",
                "css" => ["components/custom-list-group"],
                "custom_css" => ["multi"],
                "plugin_css" => ["select2/select2.min"],
                "custom_js" => ["admin/task","moment.min"],
                "plugin_js" => [],
            ]);
        break;
        case "vtask" :
            View::render($view,[
                "crumbs" => [
                    ["page_title" => "Order Details"],
                ],
                "page_title" => "Order Details",
                "page_type" => "client",
                "page_view" =>  "vtask",
                "css" => ["widgets/modules-widgets","components/custom-list-group"],
                "custom_js" => ["admin/view-task","moment.min"],
            ]);
        break;
        case "notifications" :
            View::render("notification",[
                "page_title" => "Notifications",
                "page_type" => $user,
                "page_view" =>  "notification",
                "css" => ["components/custom-list-group"],
                "custom_js" => ["notification","moment.min"],
            ]);
        break;
        
    }
}