<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>You are visiting {url}</title>

<style>
*{
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
}

@-ms-viewport{
  width: device-width;
}

body,html{
	font-family:Verdana,sans-serif;
	font-size: 15px;
	line-height: 1.5;
	margin: 0;
	padding: 0;
	background-color: #eee;
}

.wrapper{
	margin: auto; 0;
	max-width: 980px;
}

.main-background{
	background-color: #fff;
}

header h1{
	text-align: center;
	font-size: 38px;
	display: block;
	margin-top: 48px;
}

header h3{
	text-align: center;
}

#second{
	color: #67cf00;
	padding: 8px;
	background-color: #fff;
	border-radius: 4px;
}

</style>

	</head>
	<body>
		<div class="wrapper">
		<header>
			<h1>URL Shortner</h1>
			<h3>You will be redirected to {url} in <span id="second">{seconds}</span> seconds</h3>
		</header>
		</div>
		
		<script>
			var elm = document.getElementById('second');
			var s = 0;
			var seconds = {seconds};
			var tmr = setInterval(function(){
				var val = (seconds - s);
				if(val === 0){
					document.location.href = '{url}';
					clearInterval(tmr);
				}
				elm.innerHTML = (seconds - s)
			s++;	
			},999);
		</script>
	</body>
</html>