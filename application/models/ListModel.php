<?php
/**
 * Created by PhpStorm.
 * User: samtay
 * Date: 5/12/14
 * Time: 12:57 PM
 */

class ListModel extends Model {
    static private $instance;

    private function __constructor(){}

    public function getInstance(){
        if (empty(self::$instance)) {
            self::$instance = new Lists();
        }
        return self::$instance;
    }


}