<?php
/**
 * Description of EffectsManager
 *
 * @author msk
 */
class EffectsManager {
    public function applyEffect($id, $content) {
        $class = $id;
        if (class_exists($class)) {
            $effect = new $class();
            $content = $effect->applyEffect($content);            
            $return = ['res' => true, 'content' => $content];            
            return $return;
        } else  {
            return ['res' => false, 'error' => "The effect doesn't exist."];
        }
    }
    
    public function applyEffectsRandom($content, $iterations_max = 1, $allow_duplicated_families=false) {
        $fxs = $this->getEffects();
        $fxs_full = [];
        $fxs_chances = [];
        $fxs_used = [];
        $return = [];
        $families_used = [];
        foreach ($fxs as $fx) {
            $class = $fx;
            if (class_exists($class)) {
                $effect = new $class();
                $multiplier = $effect->getMultiplier();
                $family = $effect->getFamily();
                $fxs_full[$fx] = ['multiplier' => $multiplier, 'family' => $family];
            }  
        }
        foreach ($fxs_full as $fx => $v) {
            for ($i=1; $i <= $v['multiplier']; $i++) {
                $fxs_chances[] = ['fx' => $fx, 'multiplier' => $v['multiplier'], 'family' => $v['family']];
            }
        }
        
        for ($i=1; $i <= $iterations_max; $i++) {   
            $tries = 0;
            $continue = false;
            $rand = rand(0,count($fxs_chances)-1);
            while (in_array($rand, $fxs_used)) {
                $rand = rand(0,count($fxs_chances)-1);
                $tries++;
                if ($tries > 20) {
                    $continue = true;
                    break;
                }
            }
            if ($allow_duplicated_families === false && $continue === false) {
                $tries = 0;
                while (in_array($fxs_chances[$rand]['family'], $families_used)) {
                    $rand = rand(0,count($fxs_chances)-1);
                    $tries++;
                    if ($tries > 20) {
                        $continue = true;
                        break;
                    }
                }
            }
            if ($continue === true) continue;
            $fx = $fxs_chances[$rand]['fx'];
            $class = $fx;
            $effect = new $class();
            $content = $effect->applyEffect($content);
            $families_used[] = $effect->getFamily();
            $fxs_used[] = $rand;
            $return['fxs'][] = $fx;
        }
        $return['content'] = $content;
        return $return;
        
    }
    
    public function getEffects() {
        $return = [];
        $dir = new DirectoryIterator(dirname(__FILE__).'/Effects/lib');
        foreach ($dir as $fileinfo) {
            if (!$fileinfo->isDot()) {
                $return[] = $fileinfo->getBasename('.php');
            }
        }            
        return $return;        
    }
    
    public function convertImageToJPG($originalImage, $outputImage, $quality)
    {
        // jpg, png, gif or bmp?
        $exploded = explode('.',$originalImage);
        $ext = $exploded[count($exploded) - 1]; 
        if (preg_match('/jpg|jpeg/i',$ext))
            $imageTmp=imagecreatefromjpeg($originalImage);
        else if (preg_match('/png/i',$ext))
            $imageTmp=imagecreatefrompng($originalImage);
        else if (preg_match('/gif/i',$ext))
            $imageTmp=imagecreatefromgif($originalImage);
        else if (preg_match('/bmp/i',$ext))
            $imageTmp=imagecreatefrombmp($originalImage);
        else
            return 0;
        // quality is a value from 0 (worst) to 100 (best)
        imagejpeg($imageTmp, $outputImage, $quality);
        imagedestroy($imageTmp);
        return 1;
    }    
}