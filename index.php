<?php
$home = (@$_SERVER['HOME']? : getenv("HOME")? : __DIR__).'/';
if(count($_POST)){
	if(!@$_GET['path']){
		exit('Please specify target file path');
	}
	if(!@$_GET['url']){
		exit('Please specify source file url');
	}
	$path = $home.$_POST['path'];
	$url = @$_POST['url'];
	ignore_user_abort(true); set_time_limit(0); 
	
	if($url && $path) download_file($url, $path); else echo('Path or URL not specified');
	
}else{
?>
<form id="frm-code">
<label>URL of File</label><br/>
<input placeholder="URL" type="url" title="The url of the file to download" value="<?=@$_POST['code']?>" name="url"><br/>
<label>URL of File</label><br/>
<b><?=$home?></b>
<input placeholder="Filename" type="text" title="The target file name for saving..." value="<?=@$_POST['code']?>" name="path"><br/>
<br/><button type="submit">Download</button>
</form>
<?php
}
function download_file($url, $path){
    $newfname = $path;
    $file = fopen ($url, 'rb');
    if ($file) { echo 'File opened... URL: '.$url.'<br/>';
        $newf = fopen ($newfname, 'wb');
        if ($newf) {echo 'Writing file... '. $path.'<br/>';
            while(!feof($file)) {
                fwrite($newf, fread($file, 1024 * 8), 1024 * 8);
            }
        }else echo 'Error opening new file... '. $path;
    }else echo 'Error opening URL... URL: '.$url.'<br/>';
    if ($file) {
        fclose($file);
    }
    if ($newf) {
        fclose($newf);
    }
	echo 'Done writting file**'.'<br/>';
}
?>