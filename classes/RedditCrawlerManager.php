<?php
/**
 * Description of RedditCrawlerManager
 *
 * @author msk
 */
class RedditCrawlerManager {
    public function crawl() {
        $section = array("Astrophotography", "spaceporn", "earthporn", "StarshipPorn", "AuroraPorn", "SeaPorn", "DiamondPorn", "BeachPorn", "JunglePorn", "LakePorn", "ImaginaryLandscapes", "ImaginaryWildlands", "Astrophotography","videogamewallpapers");
        $r = rand(0, count($section)-1);
        $sectionchosen = $section[$r];
      
        $url="https://www.reddit.com/r/$sectionchosen/top.json?sort=top&t=month&count=100";
        //  Initiate curl
        $ch = curl_init();
        // Disable SSL verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Set the url
        curl_setopt($ch, CURLOPT_URL,$url);
        // Execute
        $result=curl_exec($ch);
        //echo '<pre>';print_r(curl_getinfo($ch));print_r($result);die();
        // Closing
        curl_close($ch);
        // Get image
        $array = json_decode($result, true);
        $tries = 0;
        $rand = rand(0,24);
        while (!isset($array["data"]["children"][$rand]["data"]["url"])) {
                $rand = rand(0,24);
                $tries++;
                if ($tries >= 5) return $this->crawl();
        }
        $img = $array["data"]["children"][$rand]["data"]["url"];
        $content_original = @file_get_contents($img);
        if (empty($content_original)) {
            return $this->crawl();
        }        
        return ['uri' => $img, 'content' => $content_original];
    }
}