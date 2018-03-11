<?php
/**
 * Created by PhpStorm.
 * User: A188656
 * Date: 2016/11/11
 * Time: 05:52 AM
 */
//set the script to execute to the end
ini_set('max_execution_time', 300);
//include time execution script speed class
include_once(__DIR__ . "/processt.php");
//include connection module for modelling functions
include_once(__DIR__ . '/Model/modal_db.php');
//include the paths config
include_once('Pathconf.php');

//invoke path class
$InTpth = new Pathconf();
//invoke the execution calc method.
$loadnT = new processt();//echo "\r";

$PrimeDir = $InTpth->GetMainDir(); //var_dump($PrimeDir);exit;
$BackFold = $InTpth->GetBackDir(); //var_dump($BackDir);exit;
$BackDir = $BackFold['B']; //exit;
//regenerate directories
$Pth_ref->ReacDir($PrimeDir);
$Pth_ref->ReacDir($BackFold);
$Pth_ref->ReacDir(array($BackDir));
//scan directories and count to make sure there is content in them.
foreach ($PrimeDir as $cntfl) { //echo $cntfl; exit;

    $fi = new FilesystemIterator($cntfl, FilesystemIterator::SKIP_DOTS);
    //count files in dir
    $Itr = iterator_count($fi);
    echo "<br />There were " . $Itr . " file(s) in path " . $cntfl . "<br />";

    //check suppress flag
    $CkLttr = CkInsrtctg("ecategory","e_locked",1,"e_name","LTTR");
    $SupLttr = mysql_num_rows($CkLttr);

    //check suppress flag
    $CkStmt = CkInsrtctg("ecategory","e_locked",1,"e_name","STMT");
    $SupStmt = mysql_num_rows($CkStmt);

/*    if ($SupLttr!=0 && $SupStmt!=0){//close both notifications and statements queues
        $files = preg_grep('~\.(csv|xml|SWF.xml)$~', scandir($cntfl));
    }else if ($SupStmt!=0){ //close statements queue
        $files = preg_grep('~\.(csv|xml|SWF.xml|LTTR)$~', scandir($cntfl));
    }else if($SupLttr!=0){//close notification queue
        $files = preg_grep('~\.(csv|xml|SWF.xml|STMT)$~', scandir($cntfl));
    }else {//default option all queues open
        $files = preg_grep('~\.(csv|xml|SWF.xml|STMT|LTTR)$~', scandir($cntfl));
    }*/

    $files = preg_grep('~\.(csv|xml|SWF.xml|STMT|LTTR)$~', scandir($cntfl));
    //test evaluation success.
    //echo var_dump($files); exit;


    //limit iteration to X^ number files at a time.
    //declare iterator start count
    $iTr = 0;

//iterate and touch every file loging it's details
//in this iteration we shall do;
// - log files in db
// - copy files in backup folder
//- move files into intermediary folders
    foreach ($files as $filename) {
//path new path not locked by simple file object
        $newpth = $BackDir."/".$filename;
        $secpth = $cntfl."/".$filename;
        //substring to capture swift advices specifically
        $SwfT_reG = substr($filename, -7); //exit();

        //path to statements files
        $PatH = $cntfl."/".$filename;

        //simple file object will assist us read in file
        $accT = new SplFileObject($PatH);$accT2 = new SplFileObject($PatH);

        //function extracts file details
        $infle = pathinfo($filename);
        echo $BfnamE = $infle['basename'];
        echo " base\n<br />";
        echo $Bextfl = $infle['extension'];
        echo " ext\n<br />";
        //$infle['filename']." name\n<br />";
        echo $Bflbtsz = filesize($PatH);
        echo " bytes\n\n<br />";
        echo $Bfldmod = date("Y-m-d", filemtime($PatH));
        echo " date modified <br />";
        echo $Bfltmod = date("H:i a", filemtime($PatH));
        echo " time modified <br />";
        $TdyT = date("Y-m-d");

        //if this is a swift alert
        if ($SwfT_reG == "SWF.xml") {
            echo "swift ohoiiya<br />";
            //remove duplicates from insert qry;
            $CckfnC = CkInsrtDb("file", "fl_name", $BfnamE, "fl_path", $newpth, "fl_date", $Bfldmod, "fl_ecatg", 3);
            echo $CounTT = nuMrws($CckfnC);
            if ($CounTT != 0) {
                echo "<b style='color: chocolate;'>" . $BfnamE . " is a duplicate </b><br />";
            } else {
                //log the file in DB
                $Part_Pth = $BackDir."/".$filename;
                $SinSt = inStfldt("file", "fl_name", "fl_ext", "fl_path", "fl_date", "fl_time", "fl_size", "fl_ecatg","fl_psec","fl_pdate",
                    $BfnamE, $Bextfl, $newpth, $Bfldmod, $Bfltmod, $Bflbtsz, 3,$secpth,$TdyT);


            }
        }

        //if this is a user import
        if ($infle['extension'] == "csv") {
            echo "import ohoiiya<br />";
            //remove duplicates from insert qry;
            $CckfnU = CkInsrtDb("file", "fl_name", $BfnamE, "fl_path", $newpth, "fl_date", $Bfldmod, "fl_ecatg", 5);
            echo $CounimP = nuMrws($CckfnU);
            if ($CounimP != 0) {
                echo "<b style='color: chocolate;'>" . $BfnamE . " is a duplicate </b><br />";
            } else {
                //log the file in DB
                echo $Part_Pth = $BackDir."/".$filename; //exit;
                $SinSt = inStfldt("file", "fl_name", "fl_ext", "fl_path", "fl_date", "fl_time", "fl_size", "fl_ecatg","fl_psec","fl_pdate",
                    $BfnamE, $Bextfl, $newpth, $Bfldmod, $Bfltmod, $Bflbtsz, 5,$secpth,$TdyT);


            }
        }

        //if this is a advice alert
        if ($SwfT_reG != "SWF.xml" && $infle['extension'] == "xml") {
            echo "Advice ohoiiya<br />";
            //remove duplicates from insert qry;
            $CckfnCadv = CkInsrtDb("file", "fl_name", $BfnamE, "fl_path", $newpth, "fl_date", $Bfldmod, "fl_ecatg", 4);
            echo $CounTTadv = nuMrws($CckfnC);
            if ($CounTTadv != 0) {
                echo "<b style='color: steelblue;'>" . $BfnamE . " is a duplicate </b><br />";
            } else {
                //log the file in DB
                $SinSt = inStfldt("file", "fl_name", "fl_ext", "fl_path", "fl_date", "fl_time", "fl_size", "fl_ecatg","fl_psec","fl_pdate",
                    $BfnamE, $Bextfl, $newpth, $Bfldmod, $Bfltmod, $Bflbtsz, 4,$secpth,$TdyT);
                //path to backup folder
                $PatBkadv = $BackDir."/".$filename;


            }

        }



        //if this is a notification alert
        if ($infle['extension'] == "LTTR"){

          //echo "Notification ohoiiya<br />";
            //remove duplicates from insert qry;
            $Cckfnltr = CkInsrtDb("file", "fl_name", $BfnamE, "fl_path", $newpth, "fl_date", $Bfldmod, "fl_ecatg", 1);
            echo $CounTtr = nuMrws($Cckfnltr);
            if ($CounTtr != 0) {
                echo "<b style='color: crimson;'>" . $BfnamE . " is a duplicate </b><br />";
            } else {
                //log the file in DB
               $SinSt = inStfldt("file", "fl_name", "fl_ext", "fl_path", "fl_date", "fl_time", "fl_size", "fl_ecatg", "fl_psec", "fl_pdate",
                    $BfnamE, $Bextfl, $newpth, $Bfldmod, $Bfltmod, $Bflbtsz, 1, $secpth, $TdyT);
				$EntriNtf = mysql_insert_id();
				$dateRft = date("Y-m-d");
                //put the file object in a try catch statement to handle runtime error(s)
                try {
                    //here is the acc no.
					$accT->seek(7);
					echo $aNt = preg_replace('/\D/', '', $accT);
					echo "<br />";
                    echo "\n";
					//amount here
					$accT->seek(11);
					echo "\n";
					$NtAc = preg_replace('/\D/', '', $accT);
					$NtAc = $NtAc / 100;
					echo $NtAc = number_format((float)$NtAc, 2, '.', '');
					echo "<br />";
                    //update the resubmit file in case in future
					//now that you know send account details to resubmit
					$RinsNotf = ResubInst("resub_not", "re_fle", "re_acc", "re_date", "re_bal", $EntriNtf, $aNt, $dateRft, $NtAc);

                } catch (RuntimeException $e) {
                    doLogspf($e);
                    echo $e;
                }


            }



        }

        //if this is a statement file then get account number line 7

        if ($infle['extension'] == "STMT")
        {

              //remove duplicates from insert qry;
            $CckfnstC = CkInsrtDb("file", "fl_name", $BfnamE, "fl_path", $newpth, "fl_date", $Bfldmod, "fl_ecatg", 2);
            //count result
            echo $CounTsT = nuMrws($CckfnstC);
            if ($CounTsT != 0) {
                echo "<b style='color: darkslategrey;'>" . $BfnamE . " is a duplicate </b><br />";
            } else {
                //log the file in DB
               $SinStmt = inStfldt("file", "fl_name", "fl_ext", "fl_path", "fl_date", "fl_time", "fl_size", "fl_ecatg", "fl_psec", "fl_pdate",
                    $BfnamE, $Bextfl, $newpth, $Bfldmod, $Bfltmod, $Bflbtsz, 2, $secpth, $TdyT);
                $EntriD = mysql_insert_id();
                $dateRrS = date("Y-m-d");
                //put the file object in a try catch statement to handle runtime error(s)
                try {
                    //here is the acc no.
                    $accT->seek(7);
                    echo $a = preg_replace('/\D/', '', $accT);
                    echo "\n";
                   // $accT = null;
                    //here is the ammount.

                    $accT->seek(24);

                    $b = preg_replace('/\D/', '', $accT);
                    echo "<br />";
                    $b = $b / 100;
                    echo $b = number_format((float)$b, 2, '.', '');
                    echo "<br />";
					//exit;
                    //now that you know send account details to resubmit
                    $RinsSel = ResubInst("resub", "re_fle", "re_acc", "re_date", "re_bal", $EntriD, $a, $dateRrS, $b);

                } catch (RuntimeException $e) {
                    doLogspf($e);
                    echo $e;
                }


            }



        }

        //path to backup folder
        $PatBkstm = $BackDir."/".$filename;
        //Copy the file to backup folder
        if (!copy($PatH, $PatBkstm)) {
            $errors = error_get_last();
            echo $CpyErr = "COPY ERROR: " . $errors['type']."".$errors['message'];
            doLogCpy($CpyErr);
            echo "<br />\n" . $errors['message'];
        } else {
            echo "file copied successfully <br />";
            //Delete file from primary folder after backup
            if (file_exists($PatH)){//this gives output of 03-20mins/10,000 files
                $accT = null;$accT2 = null;
                chmod($PatH, 0666);
                //unlink($PatH);//if you would preferably delete
                //instead we want to  move files parmanently
                if (rename($PatH,$PatBkstm)) {
                    echo "file moved permanently with success";
                }else
                {
                    echo "files move command failed to work";
                }
            }

        }


        //condition iterator to limit x^(10,000)
        if (++$iTr==10000){
            break;
        }
    }
}
$Fl_this = basename($_SERVER["SCRIPT_FILENAME"], '.php');
$Prctm = $loadnT->__destruct();$Prctm = formatMilliseconds($Prctm);

runtm("runtime","file","run_time",$Fl_this,$Prctm);

//prevent opening too many connections to DB
mysql_close($con);
?>