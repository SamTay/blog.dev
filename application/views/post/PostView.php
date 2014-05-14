<?php

abstract class PostView extends View {

    /**
     * This abstract function will essentially force any child class of PostView
     * to overwrite the setBody() function, which currently sets body to a general
     * index homepage.
     *
     * @return mixed
     */
    protected abstract function generateBody();

    protected function setBody() {
        $this->body = $this->generateBody();
    }

}