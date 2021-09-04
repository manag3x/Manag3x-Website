    
    <?php // Start session
        if(!session_id()){
            session_start();
        }
        $pg = str_replace("/","",$page_root);
    ?>
    
    

    <div class="row px-4">
        <div class=" <?php echo ($page_root == "admin/" or $page_root == "writer/" or $page_root == "editor/")  ? "col-md-8 mx-auto" : "col-md-6"?>">
            <input type="hidden" id="route" value="<?php echo $page_ctrl ?>">
            <input type="hidden" name="user" value="<?php echo str_replace("/","",$page_root) ?>">
            <div id="username-field" class="field-wrapper input">
                <label for="username">EMAIL</label>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-at-sign register"><circle cx="12" cy="12" r="4"></circle><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path></svg>
                <input id="username" name="email" type="email" class="form-control" placeholder="e.g John_Doe">
            </div>

            <div id="password-field" class="field-wrapper input mb-2">
                <div class="d-flex justify-content-between">
                    <label for="password">PASSWORD</label>
                    <!-- <a href="auth_pass_recovery_boxed.html" class="forgot-pass-link">Forgot Password?</a> -->
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                <input id="password" name="password" type="password" class="form-control" placeholder="Password">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
            </div>

            <div class="field-wrapper terms_condition d-flex flex-wrap">
                <div class="n-chk">
                    <label class="new-control new-checkbox checkbox-primary">
                        <input type="checkbox" name="remember" class="new-control-input" value="">
                        <span class="new-control-indicator"></span><span>Stay Logged</span>
                    </label>
                </div>
                <a href="#" class="forgot-pass-lin ml-auto" id="f-password" data-src="<?php echo $page_fpass ?>" >Forgot Password?</a>
            </div>
            
            <div class="d-sm-flex justify-content-between">
                <div class="field-wrapper">
                    <a type="button" id="login" class="btn btn-block btn-primary widget-content" value="">Log In</a>
                </div>
            </div>
        </div>
        
    <?php
    if($page_root == "client/" or $page_root == "publisher/" or $page_root == "guest/") : ?>
        <input type="hidden" id="fbl" value="<?php echo $page_fb ?>">
        <div class="col-md-1">
            <div class="division">
                <div class="vl"></div>
                <span class="py-3">OR</span>
                <div class="vl"></div>
            </div>
        </div>
        <div class="col-md-5">
        <div class="social mt-md-4 pt-md-3">
            <?php
            // include_once('../php-graph/src/Facebook/autoload.php');
            // require_once 'fbAuth.php';
            
            // require '../google-api/vendor/autoload.php';
            require '../vendor/autoload.php';
            require_once 'googleAuth.php';
            ?>
            <a href="javascript:void()" id="fbloginA"  class="btn social-fb">
                <span class="brand-name"><i class="btn-primary text-white fab fa-facebook-f" style="padding:4px 8px"></i> Sign-in with Facebook</span>
            </a>
        </div>
        <p class="signup-link">Not registered ? <a href="<?php echo str_replace(".php","",$_SERVER['PHP_SELF']) ?>?i=register">Create an account</a></p>
    <?php endif; ?>
        </div>
    </div>

