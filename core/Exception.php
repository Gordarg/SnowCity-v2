<?php
// http://php.net/manual/en/language.exceptions.extending.php

class MyException extends Exception
{
    // Redefine the exception so message isn't optional
    public function __construct($message, $code = 0, Exception $previous = null) {
        // some code
        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }

    // custom string representation of object
    public function __toString() {
        return  __CLASS__ . ": [{$this->code}]: {$this->message}\n" ;
    }
    
    public function s_print() {
        // TODO: BeutifulUI if on Web
        echo '<div style="background-color:lightgrey;display:block;">' .
        str_replace('\n' , '<br/>' , $this->message) . '</div>';
    }
}
