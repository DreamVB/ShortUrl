<?php
	require("config.php");
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
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
				<div id="p-addurl" class="panel">
					<input id="addurl" class="txtfind" type="text" onkeypress="return runScript(event)" placeholder="Paste a long url" required="yes"/><span class="findBtn" onclick="_addUrl();">>></span>
				</div>
				</form>
				<div id="shorturl" style="display: none">
			
					<p><span><?php echo($shorturl_msg)?></span></p>
					<input id="url" class="txtfind txturl dm-center" value="url"><span class="findBtn" onclick="_copyLink();">Copy</span>
					<div class="pad-row-small"></div>
					<!--Social media bar--->
					<div id="Social-icons" class="Social-bar" style="display: none;">
						<div class="icon">
							<h2>Share above link with</h2>
							<a id="fb" href="#" title="Share with Facebook">
								<div class="facebook"></div>
							</a>
							<a id="tw" href="#" title="Share with Twitter">
								<div class="twitter"></div>
							</a>
							<a id="pt" href="#" title="Share with Pinterest">
								<div class="pinteres"></div>
							</a>
						</div>
						<!--End social media bar--->
					</div>
					
					<?php
						//Redirect back to front page.
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

function _copyLink() {
  var copyText = document.getElementById("url");
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  document.execCommand("copy");
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
				var a = document.getElementById("p-addurl");
				var fb = document.getElementById("fb");
				var tw = document.getElementById("tw");
				var pt = document.getElementById("pt");
				var Social = document.getElementById("Social-icons");
				fb.href = "https://www.facebook.com/sharer/sharer.php?u=" + "' . $link . '";
				tw.href = "https://twitter.com/home?status=" + "' . $link . '";
				pt.href = "https://pinterest.com/pin/create/button/?url=" + "' . $link . '";
				t.style.display = "";
				v.value ="' .$link .'";
				a.style.display = "none";
				Social.style.display = "' . $EnableShareLink . '";
			</script>
		');
	}
?>

	</body>
</html>