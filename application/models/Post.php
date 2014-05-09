<?php

/*
 * The post class will handle business logic of blog posts,
 * i.e., database connections and execution of CRUD (create,
 * read, update, and delete).
 */
class Post extends Model {

    /*
     * Constructor sets tableName to 'posts' and
     * gives us the primaryKey??
     */
    public function __constructor($fieldname) {
        $this->tableName = 'posts';
        $this->primaryKey = $fieldname;
    }
}