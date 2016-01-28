<?php

/**
 * 基础VO
 *
 * @author neeke@php.net
 * Date: 14-5-14 上午10:06
 */
class VO_Common
{
    public function __set($property_name, $value)
    {
        $this->{$property_name} = $value;
    }

    public function __get($property_name)
    {
        if (isset($this->$property_name)) {
            return ($this->$property_name);
        } else {
            return (NULL);
        }
    }

    public function toArray()
    {
        return (array)$this;
    }
}