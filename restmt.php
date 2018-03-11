<?php
/**
 * Created by PhpStorm.
 * User: A188656
 * Date: 2016/12/16
 * Time: 08:36 AM
 */

//set the script to execute to the end
ini_set('max_execution_time', 180);
ini_set('display_errors', 1);
error_reporting(E_ALL);

//include time execution script speed class
include_once(__DIR__."/processt.php");
//include connection module for modelling functions
include_once(__DIR__ . '/Model/modal_db.php');
//include the paths config
include_once('Pathconf.php');

//invoke path class
$Pth_ref = new Pathconf();
//invoke the execution calc method.
$loadnT = new processt();

//statements dirs
$StmtDir = $Pth_ref->GetDirInf();
//regenerate directories
$Pth_ref->ReacDir($StmtDir);
$StmResDir = array($StmtDir['S'],$StmtDir['s']);

//notifications dirs
$NotfDir = $Pth_ref->GetDirInf();
//regenerate directories
$Pth_ref->ReacDir($NotfDir);
$NtfResDir = array($NotfDir['N'],$NotfDir['n']);

//error handler dirs
$ErrDir = $Pth_ref->GetErrDir();
//regenerate directories
$Pth_ref->ReacDir($ErrDir);
$GetErrDir = array($ErrDir['ES'],$ErrDir['es'],$ErrDir['ET'],$ErrDir['et']); //var_dump($GetErrDir);exit;


foreach ($GetErrDir as $dirfl)
{
	//path to statements error files
	if ($dirfl==$ErrDir['ES']) {
		echo $PatDir = $ErrDir['ES'];echo "<br />";
		$PatStmt = $StmtDir['S'];
		$PatErBk = $ErrDir['ERS'];
	}elseif ($dirfl==$ErrDir['es']) {
		echo $PatDir = $ErrDir['es'];echo "<br />";
		$PatStmt = $StmtDir['s'];
		$PatErBk = $ErrDir['ers'];
	}else{
		//break;
	}

	//echo  $dirfl;
    $ErrCnt = new FilesystemIterator($PatDir, FilesystemIterator::SKIP_DOTS);
    //count files in dir
    $FilErr1 = iterator_count($ErrCnt);
    echo "<br />There were " . $FilErr1 . " file(s) in path (" . $PatDir . ")<br />";


	$files = preg_grep('~\.(err|xml)$~', scandir($PatDir)); //var_dump($files);exit();

    foreach ($files as $filenm) {
		//file path
		$PatH = $PatDir."/".$filenm;echo "<br />";
        //simple file object will assist us read in file
        $RdfL = new SplFileObject($PatH);

        //function extracts file details
        $infle = pathinfo($filenm);
        $BfnamE = $infle['basename'];
        //echo " base\n<br />";
        $Bextfl = $infle['extension'];
        //echo " ext\n<br />";
        //$infle['filename']." name\n<br />";
        $Bflbtsz = filesize($PatH);
        //echo " bytes\n\n<br />";
        $Bfldmod = date("Y-m-d", filemtime($PatH));
        //echo " date modified <br />";
        $Bfltmod = date("H:i a", filemtime($PatH));
        //echo " time modified <br />";

        if ($infle['extension']=="err"){
            //try the simple file object for error
            try {
                $a = $RdfL->fgets();
                $b = substr($a, -22);
                //echo $infle['basename'] . "<br /";
            } catch (RuntimeException $e){
                doLogspf($e);
                echo $e;
            }
        }
        //evaluate error for resubmission qualification
        //condition failure
        $Cndstr = "Failed to send email Error";
        if ($Cndstr=$b){
            //if so get the xml file and to read account number to fetch re-submission file
            if ($infle['extension']=="xml"){
                $xml=simplexml_load_file($PatH,'SimpleXMLElement',LIBXML_NOCDATA) or die("Error: Cannot create object");
                //var_dump($xml);
                $b = $xml->children();echo "<br />";
                $file = file($PatH);  $int = 0;
                for ($i = max(0, count($file)-5); $i < count($file); $i++) {
                    $a = (float) filter_var( $file[$i], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );

                    // first check for duplicates before inserts 3 maximum.
                    $CreErr = CkIfler("errhd","re_fle",$PatH,"re_acc",$b,"re_bal",$a);
                    //emun check hits
                    $ErceErr = nuMrws($CreErr); exit;

                    if ($ErceErr==3){
                          //duplicate detected, err handle
                          echo "Ignored certain duplicate";
						/*//log & isolate record
						$GeitRec = ClnOpter("resub","re_acc",$b,"re_bal",$a);
						$FetRec = FetRws($GeitRec);
						//update isol table*/

                      }else { //forego so that checked files are moved instead.*/

                        $art = ResubInst("errhd", "re_fle", "re_acc", "re_date", "re_bal", $PatH, $b, $Bfldmod, $a);
                    }

                    ////fetch from the resubmission table what will give the path to file in backup folder.
                    //check acc & bal
                    $Cnfrm = ClnOpter("resub","re_acc",$b,"re_bal",$a);
                    //count res
                    $Cnnt = nuMrws($Cnfrm);
                    //if the record exsts
                    if ($Cnnt!=0) {
                        //fetch file for re-submission
                        $RearYY = mysql_fetch_array($Cnfrm);
                        //get file id
                        $ufD = $RearYY['re_fle'];
                        //get the file details from file
                        $filedT = ClnOpt("file", "fl_id", $ufD, "fl_id");
                        $r4T = mysql_fetch_array($filedT);

                        //check resubmit lapse times max = 3
                        $Lpsreb = ClnOpt("reslog","res_res",$RearYY['re_id'],"res_res");
                        //cnt
                        $CntLps = nuMrws($Lpsreb);
                        //handle file duplicate on STMT reference - file tbl-ID
                        if ($CntLps==3) {
                            //log resubmit log
                            $Rslog = ReslogInst("reslog", "res_file", $r4T['fl_path'], "res_acc", $b, "res_date", $r4T['fl_date']);
                            //copy to stmt resubmit file
                            $fbkpth = $r4T['fl_path'];
                            $RestmtflD = $PatStmt."/".$r4T['fl_name'];
                            //Copy the file to statements folder
                            if (!copy($fbkpth, $RestmtflD)) {
                                $errors = error_get_last();
                                echo $CpyErr = "COPY ERROR: " . $errors['type']."".$errors['message'];
                                doLogCpy($CpyErr);
                                echo "<br />\n" . $errors['message'];
                            }else {
                                echo "Statement file copied successfully <br />";
                                //move the error files so that the next error is well handled.

                                $re = substr($BfnamE,0,-3);
                                //first error file
                                $ferR = $PatDir."/".$re."err";
                                if ($ferR){
                                    //we want to  move files parmanently
                                    $FerxmlBk = $PatErBk."/".$re."err";
                                    if (rename($ferR,$FerxmlBk)) {
                                        echo "Error file moved permanently with success<br />";
                                    }else
                                    {
                                        echo "Error file move command failed to work<br />";
                                    }
                                }
                                //second xml file
                                $FxMl = $PatDir."/".$re."xml";
                                $RdfL = null;
                                if ($FxMl){
                                    //we want to  move files permanently
                                    $FerxmlBk2 = $PatErBk."/".$re."xml";
                                    if (rename($FxMl,$FerxmlBk2)) {
                                        echo "Xml file moved permanently with success<br />";
                                    }else
                                    {
                                        echo "Xml file move command failed to work<br />";
                                    }
                                }
                            }

                        } else {
                            //max time resubmit lapse
                            //log escalate
                            //mark statement for failed resubmit in the file table resuberr.
                            //insert new file into errhndle
                            // first check for duplicates
                            $Cre = CkIfler("errhd","re_fle",$PatH,"re_acc",$b,"re_bal",$a);
                            //emun check hits
                            $ercRe = nuMrws($Cre); //exit;
                            //handle duplicate on account reference errhndle tbl
                            if ($ercRe>1) {
                                $lGerR = SngUpdtop1("file", "fle_resuberr", 1, "fl_id", $RearYY['re_id']);
                            }
                        }

                    }else {
                        //do not do anything
                        //peculiar scenario error file without corresponding stmt file
                        //probably log this scenario
                    }


                    //}

                    break;


                }
            }
        }else{
            echo "Error does not meet criteria";
        }

    }
    //break;
}
$Fl_this = basename($_SERVER["SCRIPT_FILENAME"], '.php');
$Prctm = $loadnT->__destruct();$Prctm = formatMilliseconds($Prctm);

runtm("runtime","file","run_time",$Fl_this,$Prctm);

//prevent opening too many connections to DB
mysql_close($con);
?>