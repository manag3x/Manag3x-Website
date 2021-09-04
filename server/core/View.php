<?php
declare(strict_types=1);
namespace server\core;

final class View {
    public static function render($view, array $page) : void {
        $page = [
            "page_url" => $page['url'] ?? $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
            "page_type" =>  $page['page_type'] ?? null,
            "page_title" => $page['page_title'] ?? null,
            "page_desc" => $page['page_desc'] ?? null,
            "page_view" => $page['page_view'] ?? null,
            "page_permission" =>  $page['page_permission'] ?? null,
            "body_class" =>  $page['body_class'] ?? "",
            "body_attr" =>  $page['body_attr'] ?? 'data-spy="scroll" data-offset="110"',
            "js" => $page['js'] ?? [],
            "css" => $page['css'] ?? [],
            "plugin_js" =>  $page['plugin_js'] ?? [],
            "plugin_css" =>  $page['plugin_css'] ?? [],
            "custom_js" => $page['custom_js'] ?? [],
            "custom_css" => $page['custom_css'] ?? [],
            "local" => $page['local'] ?? [],
            "page_root" => $page['page_root'] ?? "client/",
            "error_code" => $page['error_code'] ?? "404",
            "error_body" => $page['error_body'] ?? "",
            "page_salute" =>  $page['page_salute'] ?? null,
            "page_body" => $page['page_body'] ?? null,
            "page_ctrl" => $page['page_ctrl'] ?? null,
        ];

        extract($page,EXTR_SKIP);
        $config = new Config();
        $Helper = new Helper;

        if ($page_type == "auth") {
            // check if usersession is active and redirect to dashboard if so
            $user = str_replace("/","",$page_root);
            if(Session::active($user))
                header("location:./");
            //initialize required variables
            $view_page = "login";
            $page_title = ucfirst(($user == "client") ? "" : $user )." Sign In";
            $GLOBAL['USER'] = $user;
            // echo $user;exit;
            $page_ctrl  = $config::$user->ctrl.Helper::crypt("auth/login");
            $page_fb    = $config::$user->ctrl.Helper::crypt("auth/fb");
            $page_fpass = $config::$user->ctrl.Helper::crypt("auth/fpass");
            if($page_root == "admin/"){
                array_push($page['js'],'admin/auth');
            }
            
            if (array_key_exists('i',$_GET) AND $_GET['i'] == "register") {
                $page_title = "Create an Account";
                $view_page = "register";
                if($page_root == "client/"){
                    $page_salute = "Create an account to start elevating your website traffic";
                }
                $page_ctrl = $config::$user->ctrl.Helper::crypt("auth/register");
            }

            if (array_key_exists('i',$_GET) AND $_GET['i'] == "reset") {
                $page_title = "Reset Your Password";
                $view_page = "resetPass";
                $page_salute = "";
                $page_ctrl = $config::$user->ctrl.Helper::crypt("auth/resetpass");
            }

            ob_start();
                include_once(Config::$DIR."server/view/auth/{$view_page}.php");
            $body = ob_get_clean();
            $page_body = $body;
        }
        
        elseif ($page_type == "error") {
            switch ($error_code){
                case "400":
                    $page_title =  'Opps Error ' . $error_code;
                    $error_body = <<<BODY
                        <h1 class="error-number">{$error_code}</h1>
                        <p class="mini-text">BAD REQUEST!</p>
                        <p class="error-text mb-4 mt-1">Page accessed incorrectly, if problems persists, clear cache and try again</p>
                    BODY;
                break;
                case "500":
                    $page_title =  'Opps Error ' . $error_code;
                    $error_body = <<<BODY
                        <h1 class="error-number">{$error_code}</h1>
                        <p class="mini-text">INTERNAL SERVER ERROR!</p>
                        <p class="error-text mb-4 mt-1">Please contact your developer, or try again later</p>
                    BODY;
                break;
                case "503":
                    $page_title =  'Opps Error ' . $error_code;
                    $error_body = <<<BODY
                        <h1 class="error-number">{$error_code}</h1>
                        <p class="mini-text">SERVICE TEMPORARILY UNAVAILABLE!</p>
                        <p class="error-text mb-4 mt-1">Try refreshing your page, this usually solves the issue</p>
                    BODY;
                break;
                default:
                    $page_title =  'Opps Error ' . $error_code;
                    $error_body = <<<BODY
                        <h1 class="error-number">{$error_code}</h1>
                        <p class="mini-text">PAGE NOT FOUND!</p>
                        <p class="error-text mb-4 mt-1">We Cant FInd the PAge you are Trying to Access</p>
                    BODY;
                break;
            }
        }
        
        // verification page
        if ($page_type == "verify"){
            require_once(Config::$DIR."server/view/auth/verify.php");
            return;
        }else{
            /// HEAD
            //confirm if user is logged in
            if ($page_type !== "auth" AND $page_type !== "error")
                Session::confirm($page_type);
            require_once(Config::$DIR."server/inc/head.inc");
            // Authentication template
            if ($page_type == "auth")
                require_once(Config::$DIR."server/inc/template__auth.inc");
            else if ($page_type == "error"){
                require_once(Config::$DIR."server/view/error.php");
                return;
            }
            // BODY
            else {
            // Main Body
                // check admin permission
                if ($page_type !== "auth" AND $page_type !== "error" AND $page_type == "admin"){
                    $admin = new \server\model\Admin();
                    if(!$admin->isSuper())
                        if(!$admin->permission->hasPermission($page_permission)){
                            $view = "error";
                            $page_title =  'Opps Access Denied ';
                            // $page_type = "error";
                            $error_body = <<<BODY
                                <h1 class="error-number">Access Denied</h1>
                                <p class="mini-text">BAD REQUEST!</p>
                                <p class="error-text mb-4 mt-1">You do not have Permission to access this page, contact system admin for permission and try again</p>
                            BODY;
                        }  
                }
                $file = Config::$DIR."server/view/".$page_type."/".$view.".php";
                if(file_exists($file))
                    include_once($file);
                else
                    throw new \Exception("Page {$view} does not Exist",404);
            }
            require_once(Config::$DIR."server/inc/foot.inc");
            require_once(Config::$DIR."server/inc/foot_script.inc");
        }
        
    }
}