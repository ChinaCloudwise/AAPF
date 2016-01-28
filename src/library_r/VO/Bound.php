<?php

/**
 * VO
 *
 * @author neeke@php.net
 * Date: 14-5-14 下午5:07
 */
class VO_Bound
{
    /**
     * @param array     $aParams
     * @param VO_Common $oVO
     *
     * @return \VO_Common $oVO
     */
    static public function Bound(array $aParams, VO_Common $oVO)
    {
        if (count($aParams) < 1) return $oVO;

        foreach ($aParams as $key => $val) {
            $oVO->$key = $val;
        }

        return $oVO;
    }
}