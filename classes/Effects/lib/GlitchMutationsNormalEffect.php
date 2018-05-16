<?php
/**
 * Description of GlitchMutationsSoftEffect
 *
 * @author msk
 */
class GlitchMutationsNormalEffect extends EffectAbstract {
    protected $multiplier = 3;
    protected $family = 'glitch';
    
    public function applyEffect($content) {	
	$content_glitched = $content;
	$mutations = mt_rand(4,8);
	for($i = 0; $i < $mutations; $i++) {
		$rand = substr(md5(microtime()),rand(0,26),5);
	  	$content_glitched = substr_replace($content_glitched, str_shuffle($rand."t98wfh9p8w3th98w3tsetf9wgt98hgt98rzt98hwz"), rand(strlen($content_glitched)/10, strlen($content_glitched)), 0);		  	
	}		
	return $content_glitched;
    }

}
