<?php
/**
 * Description of ImagefilterColorizeEffect
 *
 * @author msk
 */
class ImagefilterColorizeEffect extends EffectAbstract {
    protected $family = 'color';
    
    public function applyEffect($content) {
        $path = uniqid().'_tmp_'.rand(1,9999).'.jpg';
        file_put_contents($path,$content);
        $im = imagecreatefromjpeg($path);
        imagefilter($im, IMG_FILTER_COLORIZE,rand(0,255),rand(0,255),rand(0,255),rand(0,127));
        imagejpeg($im, $path, 100);
        $content = file_get_contents($path);
        unlink($path);
        imagedestroy($im);
	return $content;
    }
}
