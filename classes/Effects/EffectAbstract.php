<?php
/**
 * Description of EffectAbstract
 *
 * @author msk
 */
abstract class EffectAbstract implements EffectInterface {
    protected $multiplier=1;
    protected $family='fx';
    
    function applyEffect($content) { }
    
    function getMultiplier() {
        return $this->multiplier;
    }

    function setMultiplier($multiplier) {
        $this->multiplier = $multiplier;
    }
    
    function getFamily() {
        return $this->family;
    }

    function setFamily($family) {
        $this->family = $family;
    }
}
