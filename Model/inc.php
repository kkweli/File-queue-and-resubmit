<?php
/**
 * Created by PhpStorm.
 * User: A188656
 * Date: 2016/12/06
 * Time: 12:30 PM
 */
date_default_timezone_set("Africa/Nairobi");
include_once(__DIR__.'/../Mailer/default_smtp.php');

//create log file for level of errors defined above
global $err_CON;
global $err_TXT;

######################################################################################
function doLog($text)
{
    //define the error flags.
   $err_TXT = "Could not open log text file";
    $err_WRT = "Could not write to log text file";
     // open log file
    $log_path = __DIR__."/../WLOG/";
    $filename = "con_err.txt";
    $fh = fopen($log_path.$filename, "a") or die($err_TXT);
    $wrres = fwrite($fh, date("d-m-Y || H:i")." || - $text"."\n") or die($err_WRT);
    return $wrres;
    fclose($fh);
}

function doLogDb($text)
{
    //define the error flags.
    $err_TXT = "Could not open log text file";
    $err_WRT = "Could not write to log text file";
    // open log file
    $log_path = __DIR__."/../WLOG/";
    $filename = "Dbr_err.txt";
    $fh = fopen($log_path.$filename, "a") or die($err_TXT);
    $wrres = fwrite($fh, date("d-m-Y || H:i")." || - $text"."\n") or die($err_WRT);
    return $wrres;
    fclose($fh);
}

function doLogCpy($text)
{
    //define the error flags.
    $err_TXT = "Could not open log text file";
    $err_WRT = "Could not write to log text file";
    // open log file
    $log_path = __DIR__."/../WLOG/";
    $filename = "Cpy_err.txt";
    $fh = fopen($log_path.$filename, "a") or die($err_TXT);
    $wrres = fwrite($fh, date("d-m-Y || H:i")." || - $text"."\n") or die($err_WRT);
    return $wrres;
    fclose($fh);
}

function doLogspf($text)
{
    //define the error flags.
    $err_TXT = "Could not open log text file";
    $err_WRT = "Could not write to log text file";
    // open log file
    $log_path = __DIR__."/../WLOG/";
    $filename = "spf_err.txt";
    $fh = fopen($log_path.$filename, "a") or die($err_TXT);
    $wrres = fwrite($fh, date("d-m-Y || H:i")." || - $text"."\n") or die($err_WRT);
    return $wrres;
    fclose($fh);
}

function doLogRSB($text)
{
    //define the error flags.
    $err_TXT = "Could not open log text file";
    $err_WRT = "Could not write to log text file";
    // open log file
    $log_path = __DIR__."/../WLOG/";
    $filename = "Resubdir_err.txt";
    $fh = fopen($log_path.$filename, "a") or die($err_TXT);
    $wrres = fwrite($fh, date("d-m-Y || H:i")." || - $text"."\n") or die($err_WRT);
    return $wrres;
    fclose($fh);
}

function formatMilliseconds($milliseconds) {
    $seconds = floor($milliseconds / 1000);
    $minutes = floor($seconds / 60);
    $hours = floor($minutes / 60);
    $milliseconds = $milliseconds % 1000;
    $seconds = $seconds % 60;
    $minutes = $minutes % 60;

    $format = '%u:%02u:%02u.%03u';
    $time = sprintf($format, $hours, $minutes, $seconds, $milliseconds);
    return rtrim($time, '0');
}

##########################################################################################
//server/host name
$db_host="localhost";
//server username
$db_user="root";
//server password
$db_pass="";
//database name
$db_name="dbname";

$db_port = "";

$db_table_prefix = "eres_";
//Connect to mysql server
$con= mysql_connect($db_host,$db_user,$db_pass);
if (!$con){
    echo $die = "Sorry connection to host was not established.".mysql_error();
    $CnO_rre = mysql_error()." - Generic; Sorry host connection was not be established.";

    $IssueDef = $CnO_rre;
    $IssueSubj = "QRM Connection Problem";
    $IssueTrig = TemplMail($IssueSubj,$IssueDef);

    doLog($CnO_rre);die();
    
    } else {//if connection successful
        //echo "connection has been established successfully.";
        //Select database
    $db = mysql_select_db($db_name,$con);

    if ($db!=1){
        echo $die = "Sorry connection to DB was not established.".mysql_select_db(mysql_error());
        $CnO_rre = mysql_error()." - Generic; Sorry Db connection was not be established.";

        $IssueDef = $CnO_rre;
        $IssueSubj = "QRM Connection Problem";
        $IssueTrig = TemplMail($IssueSubj,$IssueDef);

        doLog($CnO_rre);die();

    }
}



?>