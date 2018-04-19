<!DOCTYPE html>
<html>
<head>
  <title>youtube</title>
</head>

<body bgcolor="#E6E6FA">
<div>
<?php
	// print_r($_POST);
	$view_min = $_POST["Views-min"];
	$view_max = $_POST["Views-max"];
	$likes_min = $_POST["Likes-min"];
	$likes_max = $_POST["Likes-max"];
	$dislikes_min = $_POST["Dislikes-min"];
	$dislikes_max = $_POST["Dislikes-max"];
	$comments_min = $_POST["Comments-min"];
	$comments_max = $_POST["Comments-max"];
	$language = $_POST["language"];
	$token = $_POST["token"];
	if ($language == null) {
		$language = "en";
	}
	// echo $view_min;
	$lang_dict = array(
		"English" => "en",
		"Hindi" => "hi",
		"Vietnamese" => "vi",
		"Tamil" => "ta",
		"Chinese" => "zh",
		"French" => "fr",
		"Urdu" => "ur",
		"Korean" => "ko",
		"Filipino" => "fil",
		"Punjabi" => "pa",
		"Russian" => "ru",
		"Telugu" => "te",
		"Persian" => "fa",
		"Arabic" => "ar",
		"Malayalam" => "ml"
	);
	$output = array();

	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "dbms";
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	// echo "Connected successfully";
	$sql = "SELECT `video_id`,`title`,`view_count`,`likes`,`dislikes`, `comments`, `thumbnail`
			FROM youtube
			WHERE view_count BETWEEN ".$view_min." and ".$view_max."
			and likes BETWEEN ".$likes_min." and ".$likes_max."
			and comments BETWEEN ".$comments_min." and ".$comments_max."
			and dislikes BETWEEN ".$dislikes_min." and ".$dislikes_max."
			and def_language LIKE '".$lang_dict[$language]."%'
			and (tag1 LIKE '%".$token."%'
			or tag2 LIKE '%".$token."%'
			or tag3 LIKE '%".$token."%'
			or tag4 LIKE '%".$token."%'
			or tag5 LIKE '%".$token."%'
			or tag6 LIKE '%".$token."%'
			or tag7 LIKE '%".$token."%'
			or tag8 LIKE '%".$token."%'
			or tag9 LIKE '%".$token."%'
			or tag10 LIKE '%".$token."%'
			or tag11 LIKE '%".$token."%'
			or tag12 LIKE '%".$token."%'
			or tag13 LIKE '%".$token."%'
			or tag14 LIKE '%".$token."%'
			or tag15 LIKE '%".$token."%'
			or tag16 LIKE '%".$token."%'
			or tag17 LIKE '%".$token."%'
			or tag18 LIKE '%".$token."%'
			or tag19 LIKE '%".$token."%'
			or tag20 LIKE '%".$token."%')
			ORDER BY view_count DESC"
			;	
	echo $sql;
	$result = $conn->query($sql);
	// echo $result->fetch_assoc();
	// echo "prann";
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			array_push($output, $row);
			$video_id = $row["video_id"];
			$title = $row["title"];
			$view_count = $row["view_count"];
			$likes = $row["likes"];
			$dislikes = $row["dislikes"];
			$comments = $row["comments"];
			// $duration = $row["duration"];
			// $tags = $row["tags"];
			// $def_language = $row["def_language"];
			$thumbnail = $row["thumbnail"];
			// $date = $row["date"];
			// $channelId = $row["channelId"];
			// $channelTitle = $row["channelTitle"];
			$video_url = "https://www.youtube.com/watch?v=" . $video_id;
			// echo "video_id: " . $row["video_id"]. " - Title: " . $row["title"]. " Thumbnail" . $row["thumbnail"]. "<br>";
			echo "<div>
					<a href=".$video_url." target = \"_blank\"><img src=".$thumbnail." hspace = 10 align=\"left\"></a>
					<a href=".$video_url." target = \"_blank\"><font style=\"color: #453b38;font-family: cursive;font-size: 135%;\">".$title."</font></a><br>
					<font style=\"color: #706976;font-weight: 550;font-style: oblique;\">Views = ".number_format($view_count)."<br>
					Likes = ".number_format($likes)." &emsp;&emsp;    Dislikes = ".number_format($dislikes)."<br>
					Comments = ".number_format($comments)."</font><br>
				</div><br><br>
				";
		}
	} else {
		echo "0 results";
	}
	$conn->close();
	// echo json_encode($output);
?>
</div>


</body>
</html>