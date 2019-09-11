<?php
	require("config.php");
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link type="text/css" rel="stylesheet" href="css/main.css" />
		<title></title>
	</head>
	<body>

<?php
	//Redirect to long url
	//Check id is set
	if(isset($_GET["id"])){
	ob_clean();
	//Get the id for the short url
	$id = $_GET["id"];
	//The folder were the index page is kept
	$dir = "urls\\" . $id;
	//Check is the folder is jere
	if(file_exists($dir)){
		//Open and send direct page.
		echo(file_get_contents($dir ."\\index.php"));
	}else{
		//No folder so inform user
		echo('
			<div class="note-error pad">
				<h2>The id  given was not found on this server</h2>
			</div>
		');
	}
	
	return;
	}
	
?>
		<div class="wrapper pad-top">
				<h1><span><?php echo($page_title)?></span></h1>
				<p class="dm-center"><span><?php echo($page_subHeader)?></span></p>
				<p class="dm-center note-error" id="err" style="display: none"><span></span></p>

			<div class="SearchBox">
				<form>
				<div class="panel">
					<input id="addurl" class="txtfind" type="text" onkeypress="return runScript(event)" value="http://" required="yes"/><span class="findBtn" onclick="_addUrl();">>></span>
				</div>
				</form>
				<div id="shorturl" style="display: none">
					<p>&nbsp;</p>
					<p>><span><?php echo($shorturl_msg)?></span></p>
					<input id="url" class="txtfind txturl dm-center" value="url">
					
					<p>&nbsp;</p>
					
					<?php
						//Redirect back to front page.						ob_end_clean();
						$link = "http://" . $_SERVER['HTTP_HOST'] . $root_path;
						
						echo('
							<span class="findBtn" onclick="_goHome(\'' . $link . '\')">Go back Generate New Link</span>
						');
					?>
					
					
					
					
				
					
				</div>
			</div>
		</div>
		
		<script>
		
		
function _goHome(s){
	document.location.href = s;
}
		
function runScript(e) {
    if (e.keyCode == 13) {
    	_addUrl();
        return false;
    }
}

function _addUrl(){
	var e = document.getElementById("addurl");
	var err = document.getElementById('err')
	var error = false;
	
	if(e !== null){
		var text = e.value.trim().toLowerCase();
		
		if(text.length == 0){
			error = true;
		}
		
		if(text === "http://"){
			error = true;
		}
		
		if(error === true){
			if(err !== null){
				err.style.display = "";
				err.innerHTML = "You must include a valid URL address";
				return;
			}	
		}else{
			document.location.href = '?action=add&url=' + encodeURI(text);
		}
	}
}
		</script>
		
<?php
	if(isset($_GET["action"])){
		$url = $_GET["url"];
		//Get id for short utl
		$key = _getShorturlID(3);
		//Write index page to $key folder
		$s_dir = "urls\\" . $key;
		//Create the folder with the index page will be saved to
		mkdir($s_dir);
		//OPen the rediect page this will become our main data for the index page
		$data = file_get_contents("inc\\redirect.php");
		//Replace the template name {url} with the long url
		$data =  str_replace("{url}",$url,$data);
		$data =  str_replace("{seconds}",$redirct_waitTime,$data);
		//Open our index page for write
		$fp = fopen($s_dir . "\\index.php","a");
		//Save the data to the index page
		fwrite($fp,$data,strlen($data));
		//Close file
		fclose($fp);                           
		//Get short link address
		$link = "http://" . $_SERVER['HTTP_HOST'] . $root_path . "?id=" . $key;
		
		echo('
			<script>
				var t = document.getElementById("shorturl");
				var v = document.getElementById("url");
				t.style.display = "";
				v.value ="' .$link .'";
			</script>
		');
	}
?>

	</body>
</html>