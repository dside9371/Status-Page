<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="refresh" content="30">
	<link rel="icon" href="./COMPANY-LOGO.png" type="image/png">
	<link rel="shortcut icon" href="./COMPANY-LOGO.png" type="image/png">
	<title>COMPANY Systems Status</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			margin: 0;
			background-color: #17202A;
			padding: 0;
		}
		h1 {
			padding: 20px;
			margin-bottom: 20px;
			text-align: center;
		}
		.container {
			max-width: 1200px;
			margin: 0 auto;
			padding: 20px;
		}
		.service {
			padding: 20px;
			margin-bottom: 20px;
			background-color: #212F3D;
			border-radius: 5px;
			display: flex;
			justify-content: space-between;
			align-items: center;
		}
		.service-name {
			font-size: 24px;
			font-weight: bold;
			color: #fff;
		}
		.status {
			font-size: 20px;
			font-weight: bold;
			margin-left: 20px;
			padding: 5px 10px;
			border-radius: 5px;
			text-transform: capitalize;
		}
		.status-up {
			background-color: #2ECC71;
			color: #fff;
		}
		.status-OK {
			background-color: #28B463;
			color: #fff;
		}
		.status-Alert {
			background-color: #FA2121;
			color: #fff;
		}
		.slack-messages {
			margin: 20px 0;
			padding: 20px;
			background-color: #212F3D;
			border-radius: 5px;
//			border: 1px solid #ccc;
		}
		.slack-messages h2 {
			font-size: 32px;
			padding: 20px;
//			margin-top: 40px;
			margin-bottom: 10px;
			color: white;
		}
		.slack-messages p {
			font-size: 1em;
//			font-size: 16px;
			margin-bottom: 5px;
			color: white;
			font-weight: bold;
		}
		.slack-messages img {
 			height: 1.2em;
  		 	width: 1.2em;
  			margin: 0 .05em 0 .1em;
  			vertical-align: -0.1em;
		}
		.subscribe-button {
 			background-color: #1F618D;
			border: none;
			color: #fff;
			padding: 10px 20px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 16px;
			cursor: pointer;
			border-radius: 4px;
		}
	</style>
</head>
<body>
	<div class="container">
		<h1 style="color:white;">COMPANY Systems Status</h1>   <!-- RSS setup using zapier-->
		<a href="https://zapier.com/engine/rss/<company info>" target="_blank" rel="noopener noreferrer">
 			 <button class="subscribe-button">Subscribe to RSS Feed</button>
		</a>
		<div class="services">
			<?php
				// Set your Datadog API key and application key here
				$api_key = 'datadog api key';
				$app_key = 'datadog app key';
				// Set the Datadog monitor IDs for each service here
				$monitors = array(
					'Monitor name 1' => 'datadog monitor ID (in the url of the monitor)',
					'Monitor name 2' => 'datadog monitor ID (in the url of the monitor)',
					'Monitor name 3' => 'datadog monitor ID (in the url of the monitor)',
					'Monitor name 4' => 'datadog monitor ID (in the url of the monitor)',
					'Monitor name 5' => 'datadog monitor ID (in the url of the monitor)',
					'Monitor name 6' => 'datadog monitor ID (in the url of the monitor)',
					'Monitor name 7' => 'datadog monitor ID (in the url of the monitor)',
					'Monitor name 8' => 'datadog monitor ID (in the url of the monitor)'
				);
				// Loop through each monitor and get its current status
				foreach ($monitors as $name => $monitor_id) {
					$url = "https://api.datadoghq.com/api/v1/monitor/$monitor_id?api_key=$api_key&application_key=$app_key";
					$data = json_decode(file_get_contents($url), true);
					$status = $data['overall_state'];
					// Output the service name and status with appropriate CSS class
					echo "<div class=\"service\"><span class=\"service-name\">$name</span><span class=\"status status-$status\">$status</span></div>";
				}
			?>
		</div>
    		<h2 style="color:white;">Latest team updates</h2>
    	<div class="slack-messages">
			<?php
    			// Set the Slack API endpoint and parameters
    			$api_endpoint = "https://slack.com/api/conversations.history";
    			$channel_id = "SLACK CHANNEL ID";
    			$token = "SLACK TOKEN";
    		    // Set the request headers
    			$headers = array(
    	    		"Authorization: Bearer " . $token,
    	    		"Content-type: application/json"
				);
    			// Send the GET request to the Slack API
    			$url = $api_endpoint . "?channel=" . $channel_id;
    			$ch = curl_init($url);
    			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    			$response = curl_exec($ch);
    			curl_close($ch);
    			// Decode the JSON response
    			$json = json_decode($response, true);
    			// Extract the messages from the response
				$messages = $json["messages"];
				$url = "https://slack.com/api/emoji.list";
				$headers = array(
    			"Authorization: Bearer " . $token,
    			"Content-type: application/x-www-form-urlencoded"
				);
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				$response = curl_exec($ch);
				curl_close($ch);
				$emoji_data = json_decode($response, true);
    		?>
        	<?php
				// Display the messages on the webpage from Slack and include emoji support
				// Set the default timezone to PST
				date_default_timezone_set("America/Los_Angeles");
        		foreach ($messages as $message) {
					$timestamp = $message["ts"];
					$time = date('h:i A', $timestamp);
					$date = date('M j, Y', $timestamp);
					$message_text = $message['text'];
					foreach ($emoji_data['emoji'] as $emoji_code => $emoji_url) {
    					$message_text = str_replace(":$emoji_code:", "<img src='$emoji_url' alt=':$emoji_code:'>", $message_text);
					}
					echo "<p>$time, $date: " . $message_text . "</p>";
        		}
        	?>
    	</div>
	</div>
</body>
</html>
