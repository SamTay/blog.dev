<?php

/**
 * Class GenericModel is used as a container for model data
 *
 */
class GenericModel {

	private $items = array();

    public function __construct($initData = array()){
        foreach($initData as $idx => $data){
            $this->set($idx, $data);
        }
    }

    public function __get($key = false){
        if($key){
            if(array_key_exists($key, $this->items)){
                return $this->items[$key];
            }
        }
        return false;
    }

    public function set($key = false, $value = false){
        if($key){
            $this->items[$key] = $value;
        }
        return $this;
    }

	public function __set($key = false, $value = false){
		if($key){
			$this->items[$key] = $value;
		}
	}
}
