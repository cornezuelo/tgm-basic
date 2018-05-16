<?php
/**
 * Description of GlitchMergeEffect
 *
 * @author msk
 */
class GlitchMergeEffect extends EffectAbstract {
    protected $multiplier = 4;
    protected $family = 'glitch';
    
    public function applyEffect($content) {            
        $path = uniqid().'_tmp_'.rand(1,9999).'.jpg';
        file_put_contents($path,$content);             
        $rand = rand(1,10);        
        for ($i = 0; $i <= $rand; $i++) {
            $dest = imagecreatefromjpeg($path);            
            $src = imagecreatefromjpeg($path);                        

            imagefilter($src, IMG_FILTER_COLORIZE, rand(0,255), rand(0,255), rand(0,255));

            $w = imagesx($dest);
            $h = imagesy($dest);
            
            $dst_x = rand(0,$w);
            $dst_y = rand (0,$h);
            $src_x = rand(0,$w);
            $src_y = rand(0,$h);
            $src_w = rand(10,$w);
            $src_y = rand(10,$h);
            $pt = rand(30,70);            

            //echo '<pre>';print_r([$w,$h,$dst_x,$dst_y,$src_x,$src_y,$src_w,$src_y,$pt]);echo '<hr>';

            imagecopymerge($dest, $src, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_y, $pt);            
            imagejpeg($dest,$path);
        }
        imagedestroy($dest);
        imagedestroy($src);        
        $content = file_get_contents($path);
        unlink($path);    
	return $content;
    } 
}
