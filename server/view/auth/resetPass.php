<?php
use server\core\{Helper};
if(!isset($_GET["u"]) and !isset($_GET["auth"])){
  echo "<script> location.href = './' </script>";
  exit();
}

?>
  <input type="hidden" id="route" value="<?php echo $page_ctrl ?>">
  <input type="hidden" id="id" name="id" value="<?php echo Helper::GET('u') ?>">
  <input type="hidden" name="username" value="<?php echo Helper::GET('auth') ?>">
  <div class="row px-4">
      <div class="col-md-8 mx-auto">
        <div id="password-field" class="field-wrapper input mb-2">
            <div class="d-flex justify-content-between">
                <label for="password">New Password</label>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
            <input id="password" name="password" type="password" class="form-control" placeholder="New Password">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
        </div>
        <div id="cpassword-field" class="field-wrapper input mb-2">
            <div class="d-flex justify-content-between">
                <label for="password">Confirm Password</label>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
            <input id="cpassword" name="con-password" type="password" class="form-control" placeholder="Confirm Password">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
        </div>
      
      <div class="d-sm-flex justify-content-between form-group text-center">
        <input type="submit" class="btn btn-block btn-primary widget-content" id="regi" data-val="Reset Password" value="Reset Password">
      </div>
</div>
</div>
