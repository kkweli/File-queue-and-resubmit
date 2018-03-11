<?php
/**
 * Created by PhpStorm.
 * User: A188656
 * Date: 2016/11/18
 * Time: 09:54 AM
 */

//use object to push items to an arrays

class Handler {

    public $TheList = array("");

    public function AddNewSubject($information) {
        $this->TheList = array_push($this->TheList,"$information");
        return $this->TheList;
    }

}