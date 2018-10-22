<?php
/**
 * Created by PhpStorm.
 * User: kofo
 * Date: 10/21/18
 * Time: 5:22 PM
 */

namespace kofoworola\Subdomains;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Checks if the user owns the current model
     * @param null $user
     * @return bool
     */
    public function ownsModel($user = null){
        $user = $user ?? Auth::user();
        $function = config('subdomains.middleware')['function'];
        $owner = $this->owner();

        $models = $user->$function ?? $user->$function();
        if($models instanceof Collection || is_array($models)){
            $models = collect($models);
            $filtered = $models->filter(function ($value,$key) use ($owner){
               return $value->getKey() == $owner->getKey();
            });
            if($filtered->count() < 1)
                return false;
            else
                return true;
        }
        elseif (!is_null($models)){
            return $models->getKey() == $owner->getKey();
        }
    }
}