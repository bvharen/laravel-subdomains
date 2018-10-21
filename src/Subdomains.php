<?php
/**
 * Created by PhpStorm.
 * User: kofo
 * Date: 10/21/18
 * Time: 5:22 PM
 */

namespace kofoworola\Subdomains;


class Subdomains
{

    private $name;
    private $value;

    public function __construct($name,$value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * Get name of parameter
     * @return \Illuminate\Config\Repository|mixed
     */
    public function parameterName(){
        return $this->name;
    }

    /**
     * Set the value of the subdomain called
     * @param $value
     */
    public function setValue($value){
        $this->value = $value;
    }

    /**
     * Get value of subdomain being called
     * @return mixed
     */
    public function parameterValue(){
        return $this->value;
    }

    /**
     * Get owner model of current subdomain
     * @return mixed
     */
    public function owner(){
        $owner = config('subdomains.model');
        $column = config('subdomains.column');
        return $owner::where($column,$this->value)->first();
    }
}