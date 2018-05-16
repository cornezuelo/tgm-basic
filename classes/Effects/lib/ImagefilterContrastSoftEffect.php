<?php
/**
 * Description of NegateEffect
 *
 * @author msk
 */
class ImagefilterContrastSoftEffect extends EffectAbstract {
    protected $multiplier = 3;
    protected $family = 'contrast';
    
    public function applyEffect($content) {
        $path = uniqid().'_tmp_'.rand(1,9999).'.jpg';
        file_put_contents($path,$content);
        $im = imagecreatefromjpeg($path);
        $chances = rand(0,100);
        if ($chances >= 80) {
            $i = 1;
        } else {
            $i = -1;
        }
        imagefilter($im, IMG_FILTER_CONTRAST, rand(1,10)*$i);
        imagejpeg($im, $path, 100);
        $content = file_get_contents($path);
        unlink($path);
        imagedestroy($im);
	return $content;
    }

}
