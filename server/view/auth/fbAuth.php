<?php
use server\core\{Session,Helper,Validation};
$fb = new Facebook\Facebook(array(
    'app_id' => '365163778532806', // Replace with your app id
    'app_secret' => '0286fbb197d111a174b41a28b04d1d67',  // Replace with your app secret
    'default_graph_version' => 'v3.2',
));

$helper = $fb->getRedirectLoginHelper();

// Try to get access token
try {
    if(isset($_SESSION['facebook_access_token'])){
        $accessToken = $_SESSION['facebook_access_token'];
    }else{
        $accessToken = $helper->getAccessToken();
    }
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}   
   
if(isset($accessToken)){
    if(isset($_SESSION['facebook_access_token'])){
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    }else{
        // Put short-lived access token in session
        $_SESSION['facebook_access_token'] = (string) $accessToken;
        
          // OAuth 2.0 client handler helps to manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();
        
        // Exchanges a short-lived access token for a long-lived one
        $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
        $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
        
        // Set default access token to be used in script
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    }
    
    // Redirect the user back to the same page if url has "code" parameter in query string
    if(isset($_GET['code'])){
        header('Location: ./');
    }  
    
    // Getting user's profile info from Facebook
    try {
        $graphResponse = $fb->get('/me?fields=name,first_name,last_name,email,link,gender,picture');
        $fbUser = $graphResponse->getGraphUser();
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
        session_destroy();
        // Redirect user back to app login page
        header("Location: ./");
        exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }
    
    // Getting user's profile data
    $data = new Validation;
    // Storing data into database
    $data->id = Core::cleanse($fbUser['id']);
    $data->fullname = Helper::cleanse($fbUser['first_name']." ".($fbUser['last_name']));
    $data->email = Helper::cleanse($fbUser['email']);
    // $profile_pic = mysqli_real_escape_string($db_connection, $google_account_info->picture);

    // checking user already exists or not
    $user = Helper::activeUser($pg);
    $exist = $user->isExist("oauth_id",$data->id);
    if($exist){
        $user->id = "oauth_id";
        $entity = $user->getById($data->id);
    }
    else{
        $last = $user->oAuth($data,"facebook");
        // if user not exists we will insert the user
        if($last != "")
            $entity = $user->getById($last);
        else{
            ?>
                <script>
                    alert("Ooops!! Something Went Wrong! Try Again.")
                </script>
            <?php
            exit;
        }
    }
    Session::set($pg,$entity);
    header('Location: ./');
    exit;
}else{
    // Get login url
    $permissions = ['email']; // Optional permissions
    $loginURL = $helper->getLoginUrl('https://www.youroutreachspecialist.com/backlink/client/auth', $permissions);
    // $loginURL = $helper->getLoginUrl("https://www.youroutreachspecialist.com/backlink/'.$pg.'/auth", $permissions);
    ?>
    <a href="<?php echo htmlspecialchars($loginURL) ?>"  class="btn social-fb">
        <span class="brand-name"><i class="btn-primary text-white fab fa-facebook-f" style="padding:4px 8px"></i> Sign-in with Facebook</span>
    </a>
    <?php
}