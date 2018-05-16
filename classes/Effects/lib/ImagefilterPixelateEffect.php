<?php
/**
 * Description of NegateEffect
 *
 * @author msk
 */
class ImagefilterPixelateEffect extends EffectAbstract {
    protected $family = 'pixel';
    
    public function applyEffect($content) {
        $path = uniqid().'_tmp_'.rand(1,9999).'.jpg';
        file_put_contents($path,$content);
        $im = imagecreatefromjpeg($path);
        imagefilter($im, IMG_FILTER_PIXELATE,rand(1,10),rand(0,1));
        imagejpeg($im, $path, 100);
        $content = file_get_contents($path);
        unlink($path);
        imagedestroy($im);
	return $content;
    }

}
