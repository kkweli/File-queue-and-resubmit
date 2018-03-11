<?php
/**
 * Created by PhpStorm.
 * User: A188656
 * Date: 2016/12/06
 * Time: 09:59 AM
 */

//set the script to execute to the end
ini_set('max_execution_time', 180);

//include time execution script speed class
include_once(__DIR__ . "/processt.php");
//include connection module for modelling functions
include_once(__DIR__ . '/Model/modal_db.php');
//include the paths config
include_once('Pathconf.php');

//invoke path class
$InvPcl = new Pathconf();
//invoke the execution calc method.
$loadnT = new processt();

//define the subsidiary directories for JSL.
//revised multisession
$Subfiles = $InvPcl->GetDirInf(); //var_dump($Subfiles);exit;
//regenerate directories
$Pth_ref->ReacDir($Subfiles);

//scan directories and count to make sure there is content in them.
foreach ($Subfiles as $cntfl) {

	if (is_dir($cntfl)) {

		echo "Directory confirmed ;" . $cntfl . "<br />";
		echo $Dir_Nme = basename($cntfl) . PHP_EOL;//exit;
		echo "<br />";


		//notifications messages
		if ($Dir_Nme = "ALERTS")
		{
			//select * notifications limit *2000
			$lim_ntf = 800;
			//$Ntfmv = RecolTe2("fl_ecatg",1,"fl_resubflg",0,$lim_ntf);
			$Ntfmv = RecolTe("file", "fl_ecatg", 1, "fl_resubflg", 0, "fl_id", "fl_size", $lim_ntf);
			//count res
			$CntanTf = nuMrws($Ntfmv);
			echo " Notifications<br />";

			//check if there are unprocessed items in folder
			$Adf1 = new FilesystemIterator($Subfiles['N'], FilesystemIterator::SKIP_DOTS);
			//count files in dir
			$NotfCt1 = iterator_count($Adf1);

			//check if there are unprocessed items in folder
			$Adf2 = new FilesystemIterator($Subfiles['n'], FilesystemIterator::SKIP_DOTS);
			//count files in dir
			$NotfCt2 = iterator_count($Adf2);
//check suppress flag
			$Ckcnfl = CkInsrtctg("ecategory", "e_locked", 1, "e_name", "LTTR");
			$SupCdl = mysql_num_rows($Ckcnfl);
			if ($SupCdl != 0) {
				$NwCodl = 1000000000000000;//outrageous right!:)
			} else {
				$NwCodl = 0;//rational right
			}
			//if result is fetched and pending processed queue is less than 100
			//you can move more files to queue
			if ($CntanTf > $NwCodl) {
				//fetch files array
				while ($Ntfray = mysql_fetch_array($Ntfmv)) {
					//get the path of the file from backup
					echo $PathBkp = $Ntfray['fl_path'];
					echo "<br />";
					if ($NotfCt1 < 100) {
						echo $PathSub = $Subfiles['N'] . "/" . $Ntfray['fl_name'];
					} elseif ($NotfCt2 < 100) {
						echo $PathSub = $Subfiles['n'] . "/" . $Ntfray['fl_name'];
					} else {
						break;
					}
					echo "<br />";

					//Copy the file to swift folder
					if (!copy($PathBkp, $PathSub)) {
						$errors = error_get_last();
						echo $CpyErr = "COPY ERROR: " . $errors['type'] . " " . $errors['message'];
						doLogCpy($CpyErr);
						echo "<br />\n" . $errors['message'];
					} else {
						echo "$Ntfray[fl_name] copied successfully <br />";
						//flag counter so that this is not duplicated on iterative run
						$SetFlg = SngUpdt("file", "fl_resubflg", 1, "fl_id", $Ntfray['fl_id'], "fl_resubflg", 0);


					}

				}
			}
		}

		//statements messages
		if ($Dir_Nme = "STMT") {
			//select * statements limit *2000
			$lim_stm = 800;
			$StMmv = RecolTe("file", "fl_ecatg", 2, "fl_resubflg", 0, "fl_id", "fl_size", $lim_stm);
			//count res
			$CntastM = nuMrws($StMmv);
			echo " Statements<br />";

			//check if there are unprocessed items in folder
			$STmf1 = new FilesystemIterator($Subfiles['S'], FilesystemIterator::SKIP_DOTS);
			//count files in dir
			$Scnt1 = iterator_count($STmf1);

			//check if there are unprocessed items in folder
			$STmf2 = new FilesystemIterator($Subfiles['s'], FilesystemIterator::SKIP_DOTS);
			//count files in dir
			$Scnt2 = iterator_count($STmf2);

			//check suppress flag
			$Ckcnf = CkInsrtctg("ecategory", "e_locked", 1, "e_name", "STMT");
			$SupCd = mysql_num_rows($Ckcnf);
			if ($SupCd != 0) {
				$NwCod = 1000000000000000;//outrageous right!
			} else {
				$NwCod = 0;//rational right
			}
			//if result is fetched and pending processed queue is less than 100
			//you can move more files to queue
			if ($CntastM > $NwCod) {
				//fetch files array
				while ($stmfray = mysql_fetch_array($StMmv)) {
					//get the path of the file from backup
					echo $PathBkp = $stmfray['fl_path'];
					echo "<br />";
					if ($Scnt1 < 100) {
						echo $PathSub = $Subfiles['S'] . "/" . $stmfray['fl_name'];
					} elseif ($Scnt2 < 100) {
						echo $PathSub = $Subfiles['s'] . "/" . $stmfray['fl_name'];
					} else {
						break;
					}
					echo "<br />";

					//Copy the file to swift folder
					if (!copy($PathBkp, $PathSub)) {
						$errors = error_get_last();
						echo $CpyErr = "COPY ERROR: " . $errors['type'] . " " . $errors['message'];
						doLogCpy($CpyErr);
						echo "<br />\n" . $errors['message'];
					} else {
						echo "$stmfray[fl_name] copied successfully <br />";
						//flag counter so that this is not duplicated on iterative run
						$SetFlg = SngUpdt("file", "fl_resubflg", 1, "fl_id", $stmfray['fl_id'], "fl_resubflg", 0);

					}

				}
			}

		}

		//users imports
		if ($Dir_Nme = "import") {
			//select * users limit *1000
			$lim_imp = 1000;
			$Uimmv = RecolTe("file", "fl_ecatg", 5, "fl_resubflg", 0, "fl_id", "fl_size", $lim_imp);
			//count res
			echo $CntaUim = nuMrws($Uimmv);
			echo " New Users<br />";

			//check if there are unprocessed items in folder
			$UMi1 = new FilesystemIterator($Subfiles['U'], FilesystemIterator::SKIP_DOTS);
			//count files in dir
			$Ucnt1 = iterator_count($UMi1);

			//check if there are unprocessed items in folder
			$UMi2 = new FilesystemIterator($Subfiles['u'], FilesystemIterator::SKIP_DOTS);
			//count files in dir
			$Ucnt2 = iterator_count($UMi2);

			//if result is fetched and pending processed queue is less than 100
			//you can move more files to queue
			if ($CntaUim != 0) {
				//fetch files array
				while ($UMray = mysql_fetch_array($Uimmv)) {
					//get the path of the file from backup
					echo $PathBkp = $UMray['fl_path'];
					echo "<br />";
					if ($Ucnt1 < 100) {
						echo $PathSub = $Subfiles['U'] . "/" . $UMray['fl_name'];
					}elseif ($Ucnt2 < 100) {
						echo $PathSub = $Subfiles['u'] . "/" . $UMray['fl_name'];
					}else{
						break;
					}
					echo "<br />";

					//Copy the file to swift folder
					if (!copy($PathBkp, $PathSub)) {
						$errors = error_get_last();
						echo $CpyErr = "COPY ERROR: " . $errors['type'] . " " . $errors['message'];
						doLogCpy($CpyErr);
						echo "<br />\n" . $errors['message'];
					} else {
						echo "$UMray[fl_name] copied successfully <br />";
						//flag counter so that this is not duplicated on iterative run
						$SetFlg = SngUpdt("file", "fl_resubflg", 1, "fl_id", $UMray['fl_id'], "fl_resubflg", 0);

					}

				}
			}
		}


		//swifts messages
		if ($Dir_Nme = "SWIFT")
		{//echo $Subfiles['3'];
			//select * swifts limit *1000
			$lim_sw = 1000;
			$SWmv = RecolTe("file", "fl_ecatg", 3, "fl_resubflg", 0, "fl_id", "fl_size", $lim_sw);
			//count res
			echo $CntasW = nuMrws($SWmv);
			echo " Swifts<br />";

			//check if there are unprocessed items in folder
			$SWf1 = new FilesystemIterator($Subfiles['SW'], FilesystemIterator::SKIP_DOTS);
			//count files in dir
			$Swcnt1 = iterator_count($SWf1);

			//check if there are unprocessed items in folder
			$SWf2 = new FilesystemIterator($Subfiles['sw'], FilesystemIterator::SKIP_DOTS);
			//count files in dir
			$Swcnt2 = iterator_count($SWf2);

			//if result is fetched and pending processed queue is less than 100
			//you can move more files to queue
			if ($CntasW != 0) {
				//fetch files array
				while ($SWray = mysql_fetch_array($SWmv)) {
					//get the path of the file from backup
					echo $PathBkp = $SWray['fl_path'];
					echo "<br />";
					if ($Swcnt1 < 100) {
						echo $PathSub = $Subfiles['SW'] . "/" . $SWray['fl_name'];
					}elseif ($Swcnt2 < 100) {
						echo $PathSub = $Subfiles['sw'] . "/" . $SWray['fl_name'];
					}else{
						break;
					}
					echo "<br />";

					//Copy the file to swift folder
					if (!copy($PathBkp, $PathSub)) {
						$errors = error_get_last();
						echo $CpyErr = "COPY ERROR: " . $errors['type'] . " " . $errors['message'];
						doLogCpy($CpyErr);
						echo "<br />\n" . $errors['message'];
					} else {
						echo "$SWray[fl_name] copied successfully <br />";
						//flag counter so that this is not duplicated on iterative run
						$SetFlg = SngUpdt("file", "fl_resubflg", 1, "fl_id", $SWray['fl_id'], "fl_resubflg", 0);

					}

				}
			}
		}


		//advice messages
		if ($Dir_Nme = "ADVICE")
		{

			//select * advices limit *1000
			$lim_ad = 1;
			$Admv = RecolTe("file", "fl_ecatg", 4, "fl_resubflg", 0, "fl_id", "fl_size", $lim_ad);
			//count res
			$CntadV = nuMrws($Admv);
			echo " Advices<br />";

			//check if there are unprocessed items in folder
			$Adf1 = new FilesystemIterator($Subfiles['N'], FilesystemIterator::SKIP_DOTS);
			//count files in dir
			$AdCt1 = iterator_count($Adf1);

			//check if there are unprocessed items in folder
			$Adf2 = new FilesystemIterator($Subfiles['n'], FilesystemIterator::SKIP_DOTS);
			//count files in dir
			$AdCt2 = iterator_count($Adf2);
			//if result is fetched and pending processed queue is less than 100
			//you can move more files to queue
			if ($CntadV != 0) {
				//fetch files array
				while ($Adray = mysql_fetch_array($Admv)) {
					//get the path of the file from backup
					echo $PathBkp = $Adray['fl_path'];
					echo "<br />";
					if ($AdCt1 < 100) {
						echo $PathSub = $Subfiles['N'] . "/" . $Adray['fl_name'];
					}elseif ($AdCt2 < 100) {
						echo $PathSub = $Subfiles['n'] . "/" . $Adray['fl_name'];
					}else{
						break;
					}
					echo "<br />";

					//Copy the file to advice folder
					if (!copy($PathBkp, $PathSub)) {
						$errors = error_get_last();
						echo $CpyErr = "COPY ERROR: " . $errors['type'] . " " . $errors['message'];
						doLogCpy($CpyErr);
						echo "<br />\n" . $errors['message'];
					} else {
						echo "$Adray[fl_name] copied successfully <br />";
						//flag counter so that this is not duplicated on iterative run
						$SetFlg = SngUpdt("file", "fl_resubflg", 1, "fl_id", $Adray['fl_id'], "fl_resubflg", 0);

					}

				}
			}


		}



	} else {
		$Ere = "Directory does not exist ;" . $cntfl . "<br />";
		doLogRSB($Ere);
	}

}

$Fl_this = basename($_SERVER["SCRIPT_FILENAME"], '.php');
$Prctm = $loadnT->__destruct();
$Prctm = formatMilliseconds($Prctm);

runtm("runtime", "file", "run_time", $Fl_this, $Prctm);

//prevent opening too many connections to DB
mysql_close($con);
?>