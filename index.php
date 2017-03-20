<?php	
	require_once './nowplaying/nowplaying.class.php';

	$lastfmApiKey = "";
	$slackWebhook = "";

	$nowPlaying = new NowPlaying('vrjoycestick', $lastfmApiKey);
	$nowPlaying->setNoTrackPlayingMessage('no song');

	if($nowPlaying->getNowPlaying() == "no song" && file_get_contents("./status.txt") == "active") {
		file_put_contents("./status.txt", "not");
		sendMessage("The den is empty.");
	} else {
		if($nowPlaying->getNowPlaying() != "no song" && file_get_contents("./status.txt") == "not") {
			file_put_contents("./status.txt", "active");
			sendMessage("Someone is in the den.");
		}
	}

	echo $nowPlaying->getNowPlaying();

	function sendMessage($message) {
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $slackWebhook);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"text\":\"$message\"}");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		$headers = array();
		$headers[] = "Content-Type: application/x-www-form-urlencoded";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
		    echo 'Error:' . curl_error($ch);
		}
		curl_close ($ch);
	}