<?php
/**
 * Created by PhpStorm.
 * User: A188656
 * Date: 2016/12/06
 * Time: 12:32 PM
 */

//include connection file
include_once('inc.php');

//check file many global
function Selallscnd($data1,$data2,$data3)
{
    global $db_table_prefix;
    $Ckhstt = "SELECT * FROM ".$db_table_prefix.$data1." WHERE $data2=$data3";
    $exQry = mysql_query($Ckhstt)or die(doLogDb(mysql_error().__LINE__)."$Ckhstt <br /> failed @ line ".__LINE__);
    return $exQry;
}

//insert file into db function
function inStfldt($data1,$data2,$data3,$data4,$data5,$data6,$data7,$data8,$data16,$data18,$data9,$data10,$data11,$data12,$data13,$data14,$data15,$data17,$data19)
{
    global $db_table_prefix;
    $insT = "INSERT INTO ".$db_table_prefix.$data1." ($data2,$data3,$data4,$data5,$data6,$data7,$data8,$data16,$data18)
    VALUES ('$data9','$data10','$data11','$data12','$data13','$data14','$data15','$data17','$data19')";
    $eXqrY = mysql_query($insT) or die(doLogDb(mysql_error().__LINE__)."$insT <br />failed @ line ".__LINE__);
    return $eXqrY;
}

//check file insert duplicate
function CkInsrtDb($data1,$data2,$data3,$data4,$data5,$data6,$data7,$data8,$data9)
{
    global $db_table_prefix;
    $Ckhstt = "SELECT * FROM ".$db_table_prefix.$data1." WHERE $data2='$data3' AND $data4='$data5' AND $data6='$data7'
    AND $data8=$data9";
    $exQry = mysql_query($Ckhstt)or die(doLogDb(mysql_error().__LINE__)."$Ckhstt <br /> failed @ line ".__LINE__);
    return $exQry;
}

//check file ctg duplicate
function CkInsrtctg($data1,$data2,$data3,$data4,$data5)
{
    global $db_table_prefix;
    $Ckhstt = "SELECT * FROM ".$db_table_prefix.$data1." WHERE $data2=$data3 AND $data4='$data5'";
    $exQry = mysql_query($Ckhstt)or die(doLogDb(mysql_error().__LINE__)."$Ckhstt <br /> failed @ line ".__LINE__);
    return $exQry;
}

//confirm file suppress compliance
function CkIcmpL($data1,$data2,$data3,$data4,$data5,$data6,$data7)
{
    global $db_table_prefix;
    $Ckhstt = "SELECT * FROM ".$db_table_prefix.$data1." WHERE $data2=$data3 AND $data4=$data5 AND $data6=$data7";
    $exQry = mysql_query($Ckhstt)or die(doLogDb(mysql_error().__LINE__)."$Ckhstt <br /> failed @ line ".__LINE__);
    return $exQry;
}

//check file error duplicate
function CkIfler($data1,$data2,$data3,$data4,$data5,$data6,$data7)
{
    global $db_table_prefix;
    $Ckhstt = "SELECT * FROM ".$db_table_prefix.$data1." WHERE $data2='$data3' AND $data4='$data5' AND $data6=$data7";
    $exQry = mysql_query($Ckhstt)or die(doLogDb(mysql_error().__LINE__)."$Ckhstt <br /> failed @ line ".__LINE__);
    return $exQry;
}

//enter resubmit insert
function ResubInst($data1,$data2,$data3,$data4,$data5,$data6,$data7,$data8,$data9)
{
    global $db_table_prefix;
    $BldiNst = "INSERT INTO ".$db_table_prefix.$data1." ($data2,$data3,$data4,$data5) VALUES ('$data6','$data7','$data8','$data9')";
    $eXcQry = mysql_query($BldiNst) or die(doLogDb(mysql_error().__LINE__)."$BldiNst <br /> failed @ line ".__LINE__);
    return $eXcQry;
}

//enter resubmit insert
function ReslogInst($data1,$data2,$data3,$data4,$data5,$data6,$data7)
{
	global $db_table_prefix;
	$BldiNst = "INSERT INTO ".$db_table_prefix.$data1." ($data2,$data3,$data4) VALUES ('$data5','$data6','$data7')";
	$eXcQry = mysql_query($BldiNst) or die(doLogDb(mysql_error().__LINE__)."$BldiNst <br /> failed @ line ".__LINE__);
	return $eXcQry;
}

//enter resublog insert
function Resublogint($data1,$data2,$data3)
{
    global $db_table_prefix;
    $BldiNst = "INSERT INTO ".$db_table_prefix.$data1." ($data2) VALUES ('$data3')";
    $eXcQry = mysql_query($BldiNst) or die(doLogDb(mysql_error().__LINE__)."$BldiNst <br /> failed @ line ".__LINE__);
    return $eXcQry;
}

//select * and limit and order for resubmit
function RecolTe($data1,$data2,$data3,$data4,$data5,$data6,$data7,$data8){
    global $db_table_prefix;
    $BilSelc = "SELECT * FROM ".$db_table_prefix.$data1." WHERE $data2=$data3 AND $data4=$data5 ORDER BY $data6 ASC, $data7 DESC LIMIT $data8";
    $ExBils = mysql_query($BilSelc) or die(doLogDb(mysql_error().__LINE__)."$BilSelc <br /> failed @ line ".__LINE__);
    return $ExBils;
}
//bypass
function RecolTe2($data2,$data3,$data4,$data5,$data6){
	$BilSelc2 = "SELECT * FROM eresub.eres_file  WHERE $data2=$data3 AND $data4=$data5 ORDER BY fl_id ASC LIMIT $data6";
	$ExBils2 = mysql_query($BilSelc2) or die(doLogDb(mysql_error().__LINE__)."$BilSelc2 <br /> failed @ line ".__LINE__);
	return $ExBils2;
}


//optimized select * and limit and order for resubmit
function ClnOpt($data1,$data2,$data3,$data4){
    global $db_table_prefix;
    $BilSelcop = "SELECT * FROM ".$db_table_prefix.$data1." WHERE $data2=$data3 ORDER BY $data4 ASC";
    $ExBilsop = mysql_query($BilSelcop) or die(doLogDb(mysql_error().__LINE__)."$BilSelcop <br /> failed @ line ".__LINE__);
    return $ExBilsop;
}

function ClnOpt_str($data1,$data2,$data3){
    global $db_table_prefix;
    $BilSelstr = "SELECT * FROM ".$db_table_prefix.$data1." WHERE $data2='$data3'";
    $ExBilstr = mysql_query($BilSelstr) or die(doLogDb(mysql_error().__LINE__)."$BilSelstr <br /> failed @ line ".__LINE__);
    return $ExBilstr;
}

function ClnOpter($data1,$data2,$data3,$data4,$data5){
    global $db_table_prefix;
    $BilSelstr = "SELECT * FROM ".$db_table_prefix.$data1." WHERE $data2='$data3' AND $data4=$data5";
    $ExBilstr = mysql_query($BilSelstr) or die(doLogDb(mysql_error().__LINE__)."$BilSelstr <br /> failed @ line ".__LINE__);
    return $ExBilstr;
}


//update functions
//single record
function SngUpdt($data1,$data2,$data3,$data4,$data5,$data6,$data7)
{
    global $db_table_prefix;
    $BiuPdt = "UPDATE ".$db_table_prefix.$data1." SET $data2=$data3 WHERE $data4=$data5 AND $data6=$data7";
    $exQupd = mysql_query($BiuPdt) or die(doLogDb(mysql_error().__LINE__)."$BiuPdt <br /> failed @ line ".__LINE__);
    return $exQupd;
}

function SngUpdtop1($data1,$data2,$data3,$data4,$data5)
{
    global $db_table_prefix;
    $BiuPdt1 = "UPDATE ".$db_table_prefix.$data1." SET $data2=$data3 WHERE $data4=$data5";
    $exQupd1 = mysql_query($BiuPdt1) or die(doLogDb(mysql_error().__LINE__)."$BiuPdt1 <br /> failed @ line ".__LINE__);
    return $exQupd1;
}

function SngUpdstr($data1,$data2,$data3,$data4,$data5)
{
    global $db_table_prefix;
    $BiuPdt1 = "UPDATE ".$db_table_prefix.$data1." SET $data2=$data3 WHERE $data4='$data5'";
    $exQupd1 = mysql_query($BiuPdt1) or die(doLogDb(mysql_error().__LINE__)."$BiuPdt1 <br /> failed @ line ".__LINE__);
    return $exQupd1;
}

//universal mysql num rows
function nuMrws($result)
{
    $RuncnT = mysql_num_rows($result);
    return $RuncnT;
}

//universal mysql Fetch rows
function FetRws($result)
{
	$RuncnT = mysql_num_rows($result);
	return $RuncnT;
}

//custom multiple select all function
function CustAll($flg1)
{
    $MulQry = "SELECT eres_file.fl_id,eres_file.fl_name,eres_file.fl_ext,eres_file.fl_path,eres_file.fl_date,
    eres_file.fl_time,eres_file.fl_size,eres_file.fl_ecatg,eres_file.fl_resubflg,eres_file.fl_psec,eres_file.fle_resuberr,eres_file.fl_pdate
    ,eres_ecategory.e_id,eres_ecategory.e_name
    ,eres_reslog.res_id,eres_reslog.res_res
    FROM eres_file
    JOIN eres_ecategory ON eres_ecategory.e_id = eres_file.fl_ecatg
    LEFT JOIN eres_reslog ON eres_reslog.res_res = eres_file.fl_id
    WHERE eres_file.fl_resubflg = $flg1";
    $MqrExc = mysql_query($MulQry) or die(doLogDb(mysql_error().__LINE__)."$MulQry <br /> failed @ line ".__LINE__);
    return $MqrExc;
}

//custom multiple select function with catg
function CustRpt2($Ctg,$flg1,$flg2,$Dyt)
{
    $MulQry = "SELECT eres_file.fl_id,eres_file.fl_name,eres_file.fl_ext,eres_file.fl_path,eres_file.fl_date,
    eres_file.fl_time,eres_file.fl_size,eres_file.fl_ecatg,eres_file.fl_resubflg,eres_file.fl_psec,eres_file.fle_resuberr,eres_file.fl_pdate
    ,eres_ecategory.e_id,eres_ecategory.e_name
    ,eres_reslog.res_id,eres_reslog.res_res
    FROM eres_file
    JOIN eres_ecategory ON eres_ecategory.e_id = eres_file.fl_ecatg
    LEFT JOIN eres_reslog ON eres_reslog.res_res = eres_file.fl_id
    WHERE eres_file.fl_resubflg = $flg1 AND eres_file.fle_resuberr = $flg2 AND eres_file.fl_ecatg = $Ctg AND eres_file.fl_pdate='".$Dyt."'";
    $MqrExc = mysql_query($MulQry) or die(doLogDb(mysql_error().__LINE__)."$MulQry <br /> failed @ line ".__LINE__);
    return $MqrExc;
}

//custom multiple select function with catg
function CustRpt3($Ctg,$flg1,$flg2)
{
	$MulQry = "SELECT eres_file.fl_id,eres_file.fl_name,eres_file.fl_ext,eres_file.fl_path,eres_file.fl_date,
    eres_file.fl_time,eres_file.fl_size,eres_file.fl_ecatg,eres_file.fl_resubflg,eres_file.fl_psec,eres_file.fle_resuberr,eres_file.fl_pdate
    ,eres_ecategory.e_id,eres_ecategory.e_name
    ,eres_reslog.res_id,eres_reslog.res_res
    FROM eres_file
    JOIN eres_ecategory ON eres_ecategory.e_id = eres_file.fl_ecatg
    LEFT JOIN eres_reslog ON eres_reslog.res_res = eres_file.fl_id
    WHERE eres_file.fl_resubflg = $flg1 AND eres_file.fle_resuberr = $flg2 AND eres_file.fl_ecatg = $Ctg";
	$MqrExc = mysql_query($MulQry) or die(doLogDb(mysql_error().__LINE__)."$MulQry <br /> failed @ line ".__LINE__);
	return $MqrExc;
}
//function clean up DB
function Delcln($data1,$flg,$data2,$dtt,$data3){
    global $db_table_prefix;
    $DlqrY = "DELETE FROM ".$db_table_prefix.$data1." WHERE $flg=$data2 AND $dtt <= '".$data3."'";
    $ExcDlqry = mysql_query($DlqrY) or die(doLogDb(mysql_error().__LINE__)."$DlqrY <br /> failed @ line ".__LINE__);
    return $ExcDlqry;
}

function Delcln2($data1,$dtt,$data3){
    global $db_table_prefix;
    $DlqrY = "DELETE FROM ".$db_table_prefix.$data1." WHERE $dtt <= '".$data3."'";
    $ExcDlqry = mysql_query($DlqrY) or die(doLogDb(mysql_error().__LINE__)."$DlqrY <br /> failed @ line ".__LINE__);
    return $ExcDlqry;
}

function DelAll($data1){
	global $db_table_prefix;
	$DlqrY = "DELETE FROM ".$db_table_prefix.$data1;
	$ExcDlqry = mysql_query($DlqrY) or die(doLogDb(mysql_error().__LINE__)."$DlqrY <br /> failed @ line ".__LINE__);
	return $ExcDlqry;
}

//record scripts execution time
function runtm($data1,$data2,$data3,$scp_fl,$gtime){
    global $db_table_prefix;
    $fntm = $gtime; //secs in a minute
    //update this time in table
    $svls = "INSERT INTO ".$db_table_prefix.$data1." ($data2,$data3) VALUES ('$scp_fl','$fntm')";
    $exqry = mysql_query($svls) or die(doLogDb(mysql_error().__LINE__)."$svls <br /> failed @ line ".__LINE__);
    return $exqry;
}


?>