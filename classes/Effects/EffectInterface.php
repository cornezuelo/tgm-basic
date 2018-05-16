<?php
/**
 * Description of EffectInterface
 *
 * @author msk
 */
interface EffectInterface {
    public function applyEffect($content);
    public function getMultiplier();
    public function setMultiplier($multiplier);
    public function getFamily();
    public function setFamily($family);
}
