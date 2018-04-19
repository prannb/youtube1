<!DOCTYPE html>
<html>
<head>
  <title>youtube</title>
</head>

<body bgcolor="#E6E6FA">
<div>
<?php
	// $view_min = $_POST["Views-min"];
	// $view_max = $_POST["Views-max"];
	echo $_POST;
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
	$sql = "SELECT `video_id`, `title`, `view_count`, `likes`, `dislikes`, `comments`, `def_language`, `channelTitle`, `thumbnail` FROM `youtube` WHERE `view_count`>100000000";	
	// echo $sql;
	$result = $conn->query($sql);
	// echo $result->fetch_assoc();
	// echo "prann";
	if ($result->num_rows > 0) {
		// echo "prann";
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
			$def_language = $row["def_language"];
			$thumbnail = $row["thumbnail"];
			// $date = $row["date"];
			// $channelId = $row["channelId"];
			$channelTitle = $row["channelTitle"];
			$video_url = "https://www.youtube.com/watch?v=" . $video_id;
			// echo "video_id: " . $row["video_id"]. " - Title: " . $row["title"]. " Thumbnail" . $row["thumbnail"]. "<br>";
			echo "<div>
					<a href=".$video_url."><img src=".$thumbnail." hspace = 10 align=\"left\"></a>
					<a href=".$video_url."><font style=\"color: #453b38;font-family: cursive;font-size: 135%;\">".$title."</font></a><br>
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