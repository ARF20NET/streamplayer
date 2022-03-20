<?php
	if (!isset($_GET["type"]))
		$_GET["type"] = "vid";
	
	$playstream = "";
	if (!isset($_GET["stream"]))
		$playstream = "/hls/arf20.m3u8";
	else
		$playstream = $_GET["stream"];
		
	$live = false;
	if (file_exists("/mnt".$playstream))
		$live = true;
?>

<!DOCTYPE html>
<html>
    <head>
		<meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="/style.css">
        <title>ARFNET</title>
		<style>
			.title {
				font-size: 36px;
			}
			
			header *{
				display: inline-block;
			}
			
			*{
				vertical-align: middle;
				max-width: 100%;
			}
			
			video {
				width: 72%;
			}
			
			.live {
				background-color: green;
				display: inline-block;
				
			}
			
			.nolive {
				background-color: red;
				display: inline-block;
			}
		</style>
		
		<link href="https://vjs.zencdn.net/7.0.0/video-js.css" rel="stylesheet">
		<script src="https://vjs.zencdn.net/7.0.0/video.min.js"></script>
    </head>

    <body>
		<header>
			<img src="/arfnet_logo.png" width="64">
			<span class="title"><strong>ARFNET</strong></span>
		</header>
		<hr>
		<a class="home" href="/">Home</a><br>
		<h2><?php if ($playstream == "/hls/arf20.m3u8") echo "Official ARFNET"; else echo substr(substr($playstream, 5), 0, strlen($playstream) - 10); ?> Stream</h2>
		<div class="<?php if ($live) echo "live"; else echo "nolive"; ?>"><span><?php if ($live) echo "On Live NOW"; else echo "Not live"; ?></span></div>
		<br>
		<video id="player" class="video-js vjs-default-skin" height="720" width="1280" controls preload="none">
			<source src="<?php echo 'https://arf20.com'.$playstream; ?>" type="application/x-mpegURL" />
		</video>
		<script>
			var player = videojs('#player');
		</script>
		<div>
			<h3>Streams Live Now</h3>
			<?php
				$files = scandir("/mnt/hls");
				$streams = array();
				
				foreach ($files as $file) {
					if (strpos($file, ".m3u8"))
						array_push($streams, $file);
				}
				
				foreach ($streams as $stream) {
					echo '<a href="https://arf20.com/stream.php?stream=/hls/'.$stream.'">/hls/'.$stream.'</a><br>';
				}
			?>
		</div>
		<div>
			<h3>Now YOU can stream too!</h3>
			<p>Simply open OBS and set stream URL to rtmp://arf20.com/show, and you choose the stream <i>key</i> that will me the stream name.<br>
			Then the stream is distributed at http://arf20.com/hls/<i>key</i>.m3u8, and vieweable at https://arf20.com/stream.php?stream=/hls/<i>key</i>.m3u8</p>
		</div>
	</body>
</html>