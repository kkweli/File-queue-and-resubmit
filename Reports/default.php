<?php
/**
 * Created by PhpStorm.
 * User: A188656
 * Date: 2017/03/30
 * Time: 09:10 AM
 */
//load connections and models
session_start();
date_default_timezone_set("Africa/Nairobi");

include_once(__DIR__.'/../Model/modal_db.php');
include_once(__DIR__.'/en_define.php');

//check jalert services status

//kenya jalert
$cmd = 'tasklist /fi "imagename eq JALERT202.exe"';
// catch output in $output array (handy if you want to parse it)
exec($cmd, $output);
foreach ($output as $line){

	if ($line!="INFO: No tasks are running which match the specified criteria."){
		$_SESSION['JALERT202'] = "JALERT202.exe is running";
	}else{
		$_SESSION['JALERT202'] = "JALERT202.exe warning : ".$line;
	}
	break;
}
echo "<br />";
//sudan jalert
$cmd2 = 'tasklist /fi "imagename eq JALERT202SSB.exe"';
// catch output in $output array (handy if you want to parse it)
exec($cmd2, $output2);
foreach ($output2 as $line2){//echo $line2;exit;

	if ($line2!="INFO: No tasks are running which match the specified criteria."){
		$_SESSION['JALERT202SSB'] = "JALERT202SSB.exe is running";
	}else{
		$_SESSION['JALERT202SSB'] = "JALERT202SSB.exe Warning : ".$line2;
	}
	break;
}


$DatTd = date("Y-m-d"); echo "<br />";

//design processed by date total
$Allproc = CustAll(1);
echo $CntAllprc = mysql_num_rows($Allproc);echo "<br />";
//design unprocessed by date total
$AllUnproc = CustAll(0);
echo $CntAllUnprc = mysql_num_rows($AllUnproc);echo "<br />";

//design processed by category total
//$StmtCtgPr = CustRpt2(2,1,0,$DatTd);echo $TlStmt = mysql_num_rows($StmtCtgPr);echo "<br />";//statements
$StmtCtgPr = CustRpt3(2,1,0);echo $TlStmt = mysql_num_rows($StmtCtgPr);echo "<br />";//statements category only
$SwftCtgPr = CustRpt2(3,1,0,$DatTd);echo $TlSwf = mysql_num_rows($SwftCtgPr);echo "<br />";//swifts
//$NtfCtgPr = CustRpt2(1,1,0,$DatTd);echo $TlNtf = mysql_num_rows($NtfCtgPr);echo "<br />";//notifications
$NtfCtgPr = CustRpt3(1,1,0);echo $TlNtf = mysql_num_rows($NtfCtgPr);echo "<br />";////notifications category only
$AdvCtgPr = CustRpt2(4,1,0,$DatTd);echo $TlAdv = mysql_num_rows($AdvCtgPr);echo "<br />";//advices
$UimpCtgPr = CustRpt2(5,1,0,$DatTd);echo $TlUim = mysql_num_rows($UimpCtgPr);echo "<br />";//user imports

//design unprocessed by category total
//$StmtCtgUnPr = CustRpt2(2,0,0,$DatTd);echo $TlStmtcn = mysql_num_rows($StmtCtgUnPr);echo "<br />";//statements
$StmtCtgUnPr = CustRpt3(2,0,0);echo $TlStmtcn = mysql_num_rows($StmtCtgUnPr);echo "<br />";//statements category only
$SwftUnPr = CustRpt2(3,0,0,$DatTd);echo $TlSwfcn = mysql_num_rows($SwftUnPr);echo "<br />";//swifts
//$NtfCtgUnPr = CustRpt2(1,0,0,$DatTd);echo $TlNtfcn = mysql_num_rows($NtfCtgUnPr);echo "<br />";//notifications
$NtfCtgUnPr = CustRpt3(1,0,0);echo $TlNtfcn = mysql_num_rows($NtfCtgUnPr);echo "<br />";//notifications category only
$AdvCtgUnPr = CustRpt2(4,0,0,$DatTd);echo $TlAdvcn = mysql_num_rows($AdvCtgUnPr);echo "<br />";//advices
$UimpCtgUnPr = CustRpt2(5,0,0,$DatTd);echo $TlUimcn = mysql_num_rows($UimpCtgUnPr);echo "<br />";//user imports
//design failed by category total

$MsgConst = $GenHeader."Jalert Status Validation: \n
Kenya : ".$_SESSION['JALERT202']."\n
South Sudan: ".$_SESSION['JALERT202SSB']."\n\n
Total Processed Queue : ".$CntAllprc."\n
Total - Unprocessed Queue : ".$CntAllUnprc."\n
Total - Statements Processed : ".$TlStmt." || Unprocessed : ".$TlStmtcn."\n
Total - Notifications Processed : ".$TlNtf." || Unprocessed : ".$TlNtfcn."\n
Total - Swifts Processed : ".$TlSwf." || Unprocessed : ".$TlSwfcn."\n
Total - Advices Processed : ".$TlAdv." || Unprocessed : ".$TlAdvcn."\n
Total - New Users Processed : ".$TlUim." || Unprocessed : ".$TlUimcn."\n\n
QRM No-Reply";

/*$MsgConst = $GenHeader."Total processed files : ".$CntAllprc."\n
Total - unprocessed files : ".$CntAllUnprc."\n
Total - Statements Processed : ".$TlStmt."\n
Total - Notifications Processed : ".$TlNtf."\n
Total - Swifts Processed : ".$TlSwf."\n
Total - Advices Processed : ".$TlAdv."\n\n
QRM No-Reply";*/

//send information details
$NotfSubj = $GenSubject;
$NotfMsg = $MsgConst;
$NotfTrig = TemplMail($NotfSubj,$NotfMsg);

//prevent opening too many connections to DB
mysql_close($con);
?>