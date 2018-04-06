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
echo "test";
	

    $htmlBody = '';


		echo "<pre>";
echo "test";
		
        // print_r($playlistItem);
        $videoid = $video_url;
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


<?php
// if (isset($_SESSION['username'])) {
// if(isset($_POST['sub'])){
//     $video_url = $_POST['video_url'];
//    $videoid = $video_url;
//   $listResponse = $youtube->videos->listVideos("statistics,snippet",array('id' => $videoid));
// // mysql code
// $servername = "futuredev-db.cl66uth20b6a.us-west-2.rds.amazonaws.com";
// $username = "monetrewards";
// $password = "monet123";
// $dbname = "iit-k2017";


// // Create connection
// $conn = new mysqli($servername, $username, $password, $dbname);

// $target_dir = "../media/";
// $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
// $uploadOk = 1;
// $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// // Check if image file is a actual image or fake image
// if(isset($_POST["submit"])) {
//     $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
//     if($check !== false) {
//         $msgfile = "File is an image - " . $check["mime"] . ".";
//         $uploadOk = 1;
//     } else {
//         $msgfile = "File is not an image.";
//         $uploadOk = 0;
//     }
// }
// // Check if file already exists
// if (file_exists($target_file)) {
//     $msgfile = "Sorry, file already exists.";
//     $uploadOk = 0;
// }

// // Allow certain file formats
// if($imageFileType != "mp4") {
//     $msgfile = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
//     $uploadOk = 0;
// } else {
//     if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
//         $msgfile = "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
//     } else {
//         $msgfile = "Sorry, there was an error uploading your file.";
//     }
// }
// $ad_url = $_FILES["fileToUpload"]["name"];
// $title = $listResponse[0]['snippet']['localized']['title'];
// //$description = $listResponse[0]['snippet']['localized']['description'];
// $view = $listResponse[0]['statistics']['viewCount'];
// $video_like = $listResponse[0]['statistics']['likeCount'];
// $dislike = $listResponse[0]['statistics']['dislikeCount'];
// $duration = $listResponse[0]['contentDetail']['duration'];

// // Check connection
// if ($conn->connect_error) {
//     $msg = "Connection failed: " . $conn->connect_error;
// }


// $sql = "INSERT INTO content (ad_url, video_url, title, view, video_like, dislike, duration) VALUES ('$ad_url', '$video_url', '$title', '$view', '$video_like', '$dislike', '$duration')";

// if ($conn->query($sql) === TRUE) {
//      $msg = "New record created successfully";
//     //header('Location: /projects/youtube/');
// } else {
//      $msg = "Error: " . $sql . "<br>" . $conn->error;
// }

// $conn->close();
// }
// }
// // else{
// //  header('Location: http://iit.monetrewards.com/youmone/login.php');;
// // }
?>


<!DOCTYPE html>
<html>
<head>
  <title>Monetube Uploads</title>
    <link rel="stylesheet" type="text/css" href="../main.css">
</head>
<body>

<div style="text-align:center;">
  <form style="margin-top: 30px; width: 200px; margin: auto; color: blue;" action=""  method="post" enctype="multipart/form-data">
      <label style="float: left; padding: 5px;">Upload Ad :</label>
      <input style="float: left;" type="file" name="fileToUpload" id="fileToUpload">
    <!-- <input style="float: left;" type="text" name="ad_url"> -->
    <label style="float: left; padding: 5px;">You Tube vedio ID :</label>
    <input style="float: left;" type="text" name="video_url">
    <input style="float: left; margin: 5px;" type="submit" name="sub" value="Submit">
  </form>
</div>

<div style="text-align:center;">
<?=$htmlAuthorize?>
</div>
<div style="text-align:center;">
<?=$msgfile?>
<?=$msg?>
</div>

</body>
</html>
