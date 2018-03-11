<?php
/**
 * Created by PhpStorm.
 * User: A188656
 * Date: 2016/11/21
 * Time: 11:12 AM
 */
//page timer monitoring
class processt {
    private $time_start     =   0;
    private $time_end       =   0;
    private $time           =   0;
    public function __construct(){
        $this->time_start= microtime(true);
    }
    public function __destruct(){
        $this->time_end = microtime(true);
        $this->time = $this->time_end - $this->time_start;
        //echo "<br /><br />Loaded in $this->time seconds\n";
        return $Tmi = $this->time;
    }

}