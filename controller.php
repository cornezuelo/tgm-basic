<?php
function loadEffects() {
	$dir = new DirectoryIterator(dirname(__FILE__).'/classes/Effects/lib');
	foreach ($dir as $fileinfo) {
	    if (!$fileinfo->isDot()) {
	        include_once dirname(__FILE__).'/classes/Effects/lib/'.$fileinfo->getFilename();
	    }
	}    
}

function crawl() {
    $effectsManager = new EffectsManager();
    $redditCrawlerManager = new RedditCrawlerManager();
    $crawl = $redditCrawlerManager->crawl();    
    $uri = $crawl['uri'];
    $aux_content = $crawl['content'];
    $pathinfo = pathinfo($uri);
    $path = uniqid();
    if (isset($pathinfo['extension'])) {
      $path .= '.'.$pathinfo['extension'];  
    }
    
    file_put_contents($path, $aux_content);
    $effectsManager->convertImageToJPG($path, $path.'.jpg', 100);
    if (file_exists($path.'.jpg')) {
        $content = file_get_contents($path.'.jpg');
    } else {
        $content = false;
    }       
    @unlink($path);
    @unlink($path.'.jpg');
    return $content;
}

function download($uri) {    
	$effectsManager = new EffectsManager();
    $content_original = @file_get_contents($uri);
    if (empty($content_original)) {
        return false;
    }            
    $aux_content = $content_original;
    $pathinfo = pathinfo($uri);
    $path = uniqid();
    if (isset($pathinfo['extension'])) {
      $path .= '.'.$pathinfo['extension'];  
    }
    
    file_put_contents($path, $aux_content);
    $effectsManager->convertImageToJPG($path, $path.'.jpg', 100);
    if (file_exists($path.'.jpg')) {
        $content = file_get_contents($path.'.jpg');
    } else {
        $content = false;
    }       
    @unlink($path);
    @unlink($path.'.jpg');
    return $content;
}

function index() {
	$effectsManager = new EffectsManager();
    $response = '';
    $content = false;
    $tries = 0;
    
    while ($content===false) {
    	if (isset($_REQUEST['uri'])) {
    		$content = download($_REQUEST['uri']);
    		if (empty($content)) {
    			$response .= '<p style="color:red"><b>Error downloading image.</b></p>';
            	echo $response;
    		}
    	}
        else {
        	$content = crawl();
      	}
        $tries++;
        if ($tries >= 20) {
            $response .= '<p style="color:red"><b>Error Crawling. Too many tries.</b></p>';
            echo $response;
        }
    }    
    $aux = $effectsManager->applyEffectsRandom($content,rand(1,5),false);
    $response .= '<h2>'.  implode(',', $aux['fxs']).'</h2>';
    $response .= '<img src="data: image/jpeg;base64,'.base64_encode($aux['content']).'">';
    
    echo $response;
}
?>