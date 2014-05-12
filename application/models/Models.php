<?php

/**
 * Not sure what to do with this model, but pretty sure the actual model classes
 * will be derived from an abstract form, forcing certain properties/methods.
 */
abstract class Models {

    /**
     * Name of database table
     *
     * @var string
     */
    public $tableName = null;


    /**
     * The field name in the database
     *
     * @var string
     */
    public $primaryKey = null;


    /**
     * Container for data retrieved from database
     *
     * @var array
     */
    public $data = array();
}