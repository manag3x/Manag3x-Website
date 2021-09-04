<?php
// if you want to modify the form to suit the client's form fields, just use:
// <?php if($meta->page_type_root == "client/") : ?_>
//  {The selected form}
// <?php endif; ?_>
// meanwhile, if you want to hide a field, the if condition value should be "admin/"
?>
    <input type="hidden" id="route" value="<?php echo $page_ctrl ?>">
    <div class="row px-4">
    <div class="col-md-8 mx-auto">
        <div id="username-field" class="field-wrapper input">
            <label for="username">NAME</label>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
            <input id="name" name="name" type="text" class="form-control" placeholder="Enter Name">
        </div>

        <div id="email-field" class="field-wrapper input">
            <label for="email">EMAIL</label>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-at-sign register"><circle cx="12" cy="12" r="4"></circle><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path></svg>
            <input id="email" name="email" type="text" value="" class="form-control" placeholder="Email">
        </div>

        <div id="password-field" class="field-wrapper input mb-2">
            <div class="d-flex justify-content-between">
                <label for="password">PASSWORD</label>
                <a href="auth_pass_recovery_boxed.html" class="forgot-pass-link">Forgot Password?</a>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
            <input id="password" name="password" type="password" class="form-control" placeholder="Password">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
        </div>

        <div class="field-wrapper terms_condition">
            <div class="n-chk">
                <label class="new-control new-checkbox checkbox-primary">
                <input type="checkbox" name="policy" class="new-control-input">
                <span class="new-control-indicator"></span><span>I agree to the <a href="javascript:void(0);">  terms and conditions </a></span>
                </label>
            </div>
        </div>

        <div class="d-sm-flex justify-content-between">
            <div class="field-wrapper">
                <input type="submit" id="regi" class="btn btn-primary widget-content" value="Register">
            </div>
        </div>
    </div>
</div>
    <!-- <div class="division">
        <span>OR</span>
    </div>

    <div class="social">
        <a href="javascript:void(0);" class="btn social-fb">
            <span class="brand-name"><i class="bg-primary text-white fab fa-facebook-f" style="padding:4px 8px"></i> Facebook</span>
        </a>
        
        <a href="javascript:void(0);" class="btn social-google"><span class="brand-name"><i class="fab fa-google rounded-circle bg-danger p-1 text-white"></i> Google</span> </a>
    </div> -->

    <p class="mt-4 signup-link register">Already have an account? <a href="<?php echo str_replace(".php","",$_SERVER['PHP_SELF']) ?>">Log in</a></p>