<?php

/**
 * Not sure what to do with this model, but pretty sure the actual model classes
 * will be derived from an abstract form, forcing certain properties/methods.
 */
abstract class Model {

	protected $db;

    /**
     * Name of database table
     *
     * @var string
     */
    protected $table = null;


    /**
     * The field name in the database
     *
     * @var string
     */
    protected $primaryKey = null;


    /**
     * Container for data retrieved from database
     *
     * @var array
     */

    public $data = array();


	protected function getRowCount() {
		/* Write a SELECT $table.id FROM posts and count size of result */
	}
}