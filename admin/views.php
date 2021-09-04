<?php
use server\core\View;

function view(string $view, $user = "admin") : void {
    switch ($view) {
        default: View::render("error",["error",
            "page_title" => '{'.$view.'} Page not Found - Error 404',
            "page_view" => "error",
            "css" => ["pages/error/style-400"],
            "body_class" => "error404 text-center",
            "core_script" => false,
            "page_type" => "error",
            "error_root" => "admin/",
            "error_code" => "404",
            "page_type_root" => "admin/",
            "page_root" => "admin",
        ]); break;
        case "dashboard" :
            View::render($view,[
            "crumbs" => [
                ["page_title" => "Dashboard"],
            ],
            "page_title" => "Dashboard",
            "page_type" => "admin",
            "page_view" =>  "dashboard",
            "plugin_css" => ["apex/apexcharts"],
            "plugin_js" => ["apex/apexcharts.min"],
            "css" => ["widgets/modules-widgets","components/custom-list-group"],
            "custom_js" => ["admin/dashboard"]
        ]); break;
        case "client" :
            View::render($view,[
            "crumbs" => [
                ["page_title" => "Clients"],
            ],
            "page_title" => "Clients",
            "page_type" => "admin",
            "page_view" =>  "client",
            "page_permission" =>  "client",
            "plugin_css" => ["apex/apexcharts"],
            "plugin_js" => ["apex/apexcharts.min"],
            "css" => ["widgets/modules-widgets","components/custom-list-group"],
            "custom_js" => ["admin/client","moment.min","chat"],
        ]); break;
        case "editor" :
            View::render($view,[
                "crumbs" => [
                    ["page_title" => "Editors"],
                ],
                "page_title" => "Editors",
                "page_type" => "admin",
                "page_permission" =>  $view,
                "page_view" =>  "editor",
                "css" => ["widgets/modules-widgets","components/custom-list-group"],
                "custom_js" => ["admin/editor","moment.min","chat"],
            ]);
        break;
        case "writer" :
        View::render($view,[
            "crumbs" => [
                ["page_title" => "Writers"],
            ],
            "page_title" => "Writers",
            "page_type" => "admin",
            "page_permission" =>  $view,
            "page_view" =>  "writer",
            "css" => ["widgets/modules-widgets","components/custom-list-group"],
            "custom_js" => ["admin/editor","moment.min","chat"],
        ]);
        break;
        case "publisher" :
            View::render($view,[
                "crumbs" => [
                    ["page_title" => "Publishers"],
                ],
                "page_title" => "Publishers",
                "page_type" => "admin",
                "page_permission" =>  $view,
                "page_view" =>  "publisher",
                "css" => ["widgets/modules-widgets","components/custom-list-group"],
                "custom_js" => ["admin/editor","moment.min","chat"],
            ]);
        break;
        case "guest" :
            View::render("guest_writer",[
                "crumbs" => [
                    ["page_title" => "Guest Writers"],
                ],
                "page_title" => "Guest Writer",
                "page_type" => "admin",
                "page_permission" =>  $view,
                "page_view" =>  "guest_writer",
                "css" => ["widgets/modules-widgets","components/custom-list-group"],
                "custom_js" => ["admin/editor","moment.min","chat"],
            ]);
        break;
        case "admin" :
            View::render($view,[
                "crumbs" => [
                    ["page_title" => "System Administrators"],
                ],
                "page_title" => "System Administrators",
                "page_type" => "admin",
                "page_view" =>  "admin",
                "page_permission" =>  $view,
                "css" => ["widgets/modules-widgets","components/custom-list-group"],
                "custom_js" => ["admin/editor","moment.min","chat"],
            ]);
        break;
        case "client-doc" :
            View::render($view,[
                "crumbs" => [
                    ["page_title" => "Client Documents"],
                ],
                "page_title" => "Client Documents",
                "page_type" => "admin",
                "page_view" =>  "client-doc",
                "css" => ["widgets/modules-widgets","components/custom-list-group"],
                "custom_js" => ["admin/docs","moment.min"],
            ]); 
        break;
        case "client-acc" :
            View::render($view,[
                "crumbs" => [
                    ["page_title" => "Enter User Account"],
                ],
                "page_title" => "Enter User Account",
                "page_type" => "admin",
                "page_view" =>  "client-acc",
                "page_permission" =>  "enter_accounts",
                "css" => ["widgets/modules-widgets","components/custom-list-group"],
                "custom_js" => ["admin/docs","moment.min"],
            ]); 
        break;
        case "inventory" :
            View::render($view,[
                "page_title" => "inventory",
                "page_type" => "admin",
                "page_view" =>  "inventory",
                "css" => ["components/custom-list-group"],
                "page_permission" =>  $view,
                "custom_css" => ["multi"],
                "plugin_css" => ["select2/select2.min"],
                "custom_js" => ["admin/inventory","moment.min","chat"],
                // "plugin_js" => ["tableExport/tableExport","tableExport/jquery.base64"],
                "plugin_js" => ["table/datatable/button-ext/dataTables.buttons.min","table/datatable/button-ext/jszip.min","table/datatable/button-ext/buttons.html5.min","table/datatable/button-ext/buttons.print.min"],
            ]);
        break;
        case "cinventory" :
            View::render($view,[
                "page_title" => "Client Inventory",
                "page_type" => "admin",
                "page_view" =>  "cinventory",
                "css" => ["components/custom-list-group"],
                "custom_css" => ["multi"],
                "plugin_css" => ["select2/select2.min"],
                "custom_js" => ["admin/inventory","moment.min","chat"],
                "plugin_js" => ["tableExport/tableExport","tableExport/jquery.base64"],
            ]);
        break;
        case "pinventory" :
            View::render($view,[
                "page_title" => "Publisher Inventory",
                "page_type" => "admin",
                "page_view" =>  "pinventory",
                "css" => ["components/custom-list-group"],
                "custom_css" => ["multi"],
                "plugin_css" => ["select2/select2.min"],
                "custom_js" => ["admin/inventory","moment.min","chat"],
                "plugin_js" => ["tableExport/tableExport","tableExport/jquery.base64"],
            ]);
        break;
        case "archive" :
            View::render($view,[
                "page_title" => "archive",
                "page_type" => "admin",
                "page_view" =>  "archive",
                "page_permission" =>  $view,
                "css" => ["components/custom-list-group"],
                "custom_css" => ["multi"],
                "plugin_css" => ["select2/select2.min"],
                "custom_js" => ["admin/inventory","moment.min","chat"],
                "plugin_js" => [],
            ]);
        break;
        case "message" :
            View::render($view,[
                "page_title" => "Messages",
                "page_type" => "admin",
                "page_view" =>  "message",
                "css" => ["apps/mailing-chat"],
                "js" => ["apps/mailbox-chat"],
                "custom_js" => ["chat","moment.min"],
            ]);
        break;
        // "select2/select2.min","bootstrap-multiselect/bootstrap-multiselect.min"
        case "create-task" :
            View::render($view,[
                "page_title" => "Create New Task",
                "page_type" => "admin",
                "page_view" =>  "create-task",
                "page_permission" =>  "create_task",
                "css" => ["components/custom-list-group","components/tabs-accordian/custom-tabs"],
                "js" => [],
                "plugin_css" => ["select2/select2.min"],
                "custom_js" => ["admin/create-task","moment.min"],
                "plugin_js" => [],
            ]);
        break;
        case "new-task" :
            View::render($view,[
                "page_title" => "New Task",
                "page_type" => "admin",
                "page_view" =>  "new-task",
                "css" => ["components/custom-list-group"],
                "custom_css" => ["multi"],
                "plugin_css" => ["select2/select2.min"],
                "custom_js" => ["admin/task","moment.min"],
                "plugin_js" => [],
            ]);
        break;
        case "a-task" :
            View::render($view,[
                "page_title" => "Active Task",
                "page_type" => "admin",
                "page_view" =>  "a-task",
                "css" => ["components/custom-list-group"],
                "custom_css" => ["multi"],
                "plugin_css" => ["select2/select2.min"],
                "custom_js" => ["admin/task","moment.min"],
                "plugin_js" => [],
            ]);
        break;
        case "tasks" :
            View::render($view,[
                "page_title" => "All Tasks",
                "page_type" => "admin",
                "page_view" =>  "tasks",
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
                    ["page_title" => "Task View"],
                ],
                "page_title" => "Task Details",
                "page_type" => "admin",
                "page_view" =>  "vtask",
                "css" => ["widgets/modules-widgets","components/custom-list-group"],
                "custom_js" => ["admin/view-task","moment.min"],
            ]);
        break;
        case "settings" :
            View::render($view,[
                "page_title" => "Setting",
                "page_type" => "admin",
                "page_view" =>  "settings",
                "page_permission" =>  $view,
                "css" => ["components/custom-list-group"],
                "custom_css" => [],
                "plugin_css" => ["select2/select2.min"],
                "custom_js" => ["admin/settings","moment.min"],
                "plugin_js" => [],
            ]);
        break;
        case "login-log" :
            View::render($view,[
                "page_title" => "System Login Log",
                "page_type" => "admin",
                "page_view" =>  "login-log",
                "page_permission" =>  "system_logs",
                "css" => ["components/custom-list-group"],
                "custom_js" => ["admin/logs","moment.min"],
            ]);
        break;
        case "notifications" :
            View::render("notification",[
                "page_title" => "Notifications",
                "page_type" => "admin",
                "page_view" =>  "notification",
                "css" => ["components/custom-list-group"],
                "custom_js" => ["notification","moment.min"],
            ]);
        break;
        case "client-log" :
            View::render("client-log",[
                "page_title" => "Clients Activities",
                "page_type" => "admin",
                "page_view" =>  "client-log",
                "page_permission" =>  "system_logs",
                "css" => ["components/custom-list-group"],
                "custom_js" => ["admin/client","moment.min"],
            ]);
        break;
        case "articles" :
            View::render($view,[
                "page_title" => "Articles",
                "page_type" => "admin",
                "page_view" =>  "articles",
                "page_permission" =>  "writers_articles",
                "css" => ["components/custom-list-group","components/tabs-accordian/custom-tabs"],
                "custom_js" => ["admin/articles","moment.min"],
            ]);
        break;
        case "garticles" :
            View::render($view,[
                "page_title" => "All Guest Articles",
                "page_type" => $user,
                "page_view" =>  "garticles",
                "page_permission" =>  "guest_articles",
                "css" => ["components/custom-list-group","components/tabs-accordian/custom-tabs"],
                "custom_js" => ["admin/articles","moment.min"],
            ]);
        break;
        case "ngarticles" :
            View::render($view,[
                "page_title" => "New Guest Articles",
                "page_type" => $user,
                "page_view" =>  "ngarticles",
                "page_permission" =>  "new_guest_articles",
                "css" => ["components/custom-list-group","components/tabs-accordian/custom-tabs"],
                "custom_js" => ["admin/articles","moment.min"],
            ]);
        break;
    }
}