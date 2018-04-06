<?php
    $oauthClientID = '126865384018-o6v51bnvmfpsk3cfnnmjfdk0n54fouap.apps.googleusercontent.com';
    $oauthClientSecret = 'P3DpKIo-15yWlax_vsiCtoU1';
    $baseUri = 'http://localhost/youtube1/index.php';
    $redirectUri = 'http://localhost/youtube1/index.php';
    
    define('OAUTH_CLIENT_ID',$oauthClientID);
    define('OAUTH_CLIENT_SECRET',$oauthClientSecret);
    define('REDIRECT_URI',$redirectUri);
    define('BASE_URI',$baseUri);
    
    // Include google client libraries
    require_once 'src/autoload.php'; 
    require_once 'src/Client.php';
    require_once 'src/Service/YouTube.php';
    session_start();
    
    $client = new Google_Client();
    $client->setClientId(OAUTH_CLIENT_ID);
    $client->setClientSecret(OAUTH_CLIENT_SECRET);
    $client->setScopes('https://www.googleapis.com/auth/youtube');
    $client->setRedirectUri(REDIRECT_URI);
    
    // Define an object that will be used to make all API requests.
    $youtube = new Google_Service_YouTube($client);
    $htmlAuthorize ="";
    $hidden ="";
    $tokenSessionKey = 'token-' . $client->prepareScopes();

//die();

    if (isset($_GET['code'])) {
      if (strval($_SESSION['state']) !== strval($_GET['state'])) {
        die('The session state did not match.');
      }
	  
      $client->authenticate($_GET['code']);
      $_SESSION['token'] = $client->getAccessToken();

      header('Location: ' . REDIRECT_URI);
    }

    if (isset($_SESSION['token'])) {
      $client->setAccessToken($_SESSION['token']);
  }

// Check to ensure that the access token was successfully acquired.
if ($client->getAccessToken()) {
  try {
    // Call the channels.list method to retrieve information about the
    // currently authenticated user's channel.
	    $htmlBody = '';


		echo "<pre>";
		
        $listResponse = $youtube->videos->listVideos("statistics,snippet",array('id' => "hLQl3WQQoQ0"));

        
        print_r($listResponse);
        
        
  

  } catch (Google_Service_Exception $e) {
    $htmlBody = sprintf('<p>A service error occurred: <code>%s</code></p>',
      htmlspecialchars($e->getMessage()));
  } catch (Google_Exception $e) {
    $htmlBody = sprintf('<p>An client error occurred: <code>%s</code></p>',
      htmlspecialchars($e->getMessage()));
  }

  $_SESSION[$tokenSessionKey] = $client->getAccessToken();

  // print_r("hgh");
  // die();
          $hidden="<script type='text/javascript'> 
          $(document).ready(function(){
            $('.container').removeClass('hide'); 
          })</script>";
          // die();  
}else {
  $state = mt_rand();
  $client->setState($state);
  $_SESSION['state'] = $state;

  $authUrl = $client->createAuthUrl();
  $htmlAuthorize = <<<END
  <h3>Authorization Required</h3>
  <p>You need to <a href="$authUrl">authorize access</a> before proceeding.<p>
END;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>youtube</title>
</head>
<body>

<div style="text-align:center;">
<?=$htmlAuthorize?>
</div>

</body>
</html>
