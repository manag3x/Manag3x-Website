<?php
use server\core\{Session,Helper,Validation};
// Creating new google client instance
$client = new Google_Client();

// Enter your Client ID
$client->setClientId('889096430590-viu5m6rj46tt2mt3oc5ntpvahb25aapd.apps.googleusercontent.com');
// Enter your Client Secrect
$client->setClientSecret('M0wD6gcKDJhNF6mQvLAPiNMg');
// Enter the Redirect URL
$client->setRedirectUri('https://youroutreachspecialist.com/backlink/'.$pg.'/auth.php');

// Adding those scopes which we want to get (email & profile Information)
$client->addScope("email");
$client->addScope("profile");

if(!empty(Helper::GET('code'))):

    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    // getting profile information
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();

    $data = new Validation;
    // Storing data into database
    $data->id = Helper::cleanse($google_account_info->id);
    $data->fullname = Helper::cleanse($google_account_info->name);
    $data->email = Helper::cleanse($google_account_info->email);
    // $profile_pic = mysqli_real_escape_string($db_connection, $google_account_info->picture);

    // checking user already exists or not
    $user = Helper::activeUser($pg);
    $exist = $user->isExist("oauth_id",$data->id);
    if($exist){
        $user->id = "oauth_id";
        $entity = $user->getById($data->id);
    }
    else{
       $last = $user->oAuth($data,"google");
        // if user not exists we will insert the user
        if($last != "")
            $entity = $user->getById($last);
        else{
            ?>
                <script>
                    alert("Google Authentication failed! Try Again.")
                </script>
            <?php
            exit;
        }
    }
    Session::set($pg,$entity);
    header('Location: ./');
    exit;
else:
    // Google Login Url = $client->createAuthUrl();
?>

<a style="padding: 10px 44px;" href="<?php echo $client->createAuthUrl(); ?>" class="btn mt-3 social-google">
    <span class="brand-name"><i class="fab fa-google rounded-circle bg-danger p-1 text-white"></i> Sign-in with Google</span>
</a>
<?php endif; ?>