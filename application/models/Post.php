<?php

/*
 * The post class will handle business logic of blog posts,
 * i.e., database connections and execution of CRUD (create,
 * read, update, and delete).
 */
class Post extends Model {

    /*
     * Constructor sets tableName to 'posts' and gives us the primaryKey??
     *
     * @param 'string'
     * @return void
     */
    public function __constructor($fieldname) {
        $this->tableName = 'posts';
        $this->primaryKey = $fieldname;
    }


    /*
     * Hopefully this function will eventually be used to create a blog post
     *
     * @param string $user
     * @param string $body
     * @param (possibly time posted)
     */
    public function create($user, $body, $time) {
        /* Create a blog post from $user, containing $body, and noting the
        time stamp of submission */
    }
}