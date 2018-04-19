<?php
	ini_set('max_execution_time', 6000);
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

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "dbms";
  $conn = new mysqli($servername, $username, $password, $dbname);

// Check to ensure that the access token was successfully acquired.
if ($client->getAccessToken()) {
  try {
    // Call the channels.list method to retrieve information about the
    // currently authenticated user's channel.
	    $htmlBody = '';

		$myfile = fopen("dataset.txt", "r");
		$ids = fread($myfile,filesize("dataset.txt"));
		fclose($myfile);
		$a = str_split($ids,11);
		for ($i = 2922; $i<28000; $i++) {
			echo "<pre>";
			$video_id = $a[$i];
			// $urls = array("hLQl3WQQoQ0", "YykjpeuMNEk");
			$listResponse = $youtube->videos->listVideos("statistics,snippet",array('id' => $video_id ));
			$title = $listResponse[0]['snippet']['localized']['title'];
			//$description = $listResponse[0]['snippet']['localized']['description'];
			$view_count = $listResponse[0]['statistics']['viewCount'];
			$likes = $listResponse[0]['statistics']['likeCount'];
			$dislikes = $listResponse[0]['statistics']['dislikeCount'];
			$comments = $listResponse[0]['statistics']['commentCount'];
			$duration = $listResponse[0]['contentDetail']['duration'];
			$tags = $listResponse[0]['snippet']['tags'];
			$def_language = $listResponse[0]['snippet']['defaultAudioLanguage'];
			$thumbnail = $listResponse[0]['snippet']['thumbnails']['default']['url'];
			$date = $listResponse[0]['snippet']['publishedAt'];
			$channelId = $listResponse[0]['snippet']['channelId'];
			$channelTitle = $listResponse[0]['snippet']['channelTitle'];
			// print_r($listResponse);
			// print_r($channelId);
			$sql = "INSERT INTO youtube 
					(video_id, title, view_count, likes, dislikes, comments, def_language, channelId, channelTitle, thumbnail, tag1, tag2, tag3, tag4, tag5, tag6, tag7, tag8, tag9, tag10, tag11, tag12, tag13, tag14, tag15, tag16, tag17, tag18, tag19, tag20)
					VALUES
					('$video_id', '$title', '$view_count', '$likes', '$dislikes', '$comments', '$def_language', '$channelId', '$channelTitle', '$thumbnail', '$tags[0]', '$tags[1]', '$tags[2]', '$tags[3]', '$tags[4]', '$tags[5]', '$tags[6]', '$tags[7]', '$tags[8]', '$tags[9]', '$tags[10]', '$tags[11]', '$tags[12]', '$tags[13]', '$tags[14]', '$tags[15]', '$tags[16]', '$tags[17]', '$tags[18]', '$tags[19]')";

			if ($conn->query($sql) === TRUE) {
				$msg = "New record created successfully";
				//header('Location: /projects/youtube/');
			} else {
				$msg = "Error: " . $sql . "<br>" . $conn->error;
			}
		}

		$conn->close();        
        
  

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
<div style="text-align:center;">
	<?=$msg?>
</div>
</body>
</html>
