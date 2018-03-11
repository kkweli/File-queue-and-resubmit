<?php
/**
 * Created by PhpStorm.
 * User: A188656
 * Date: 2017/02/13
 * Time: 05:01 AM
 */

    const Prime = "/../../../PRIMARY";
    const Backup = "/../../../ECOURIER_BACKUP";
	const Duplicate = "/../../../DUPLICATE_FILES";

	const Uimport = "/../../../Jethro/JALERT201/users/import";
	const Uimport2 = "/../../../Jethro/JALERT201_2/users/import";
    const Notifications = "/../../../Jethro/JALERT201/NOTIFICATION";
	const Notifications2 = "/../../../Jethro/JALERT201_2/NOTIFICATION";
	const Advices = "/../../../Jethro/JALERT201/ADVICE";
	const Advices2 = "/../../../Jethro/JALERT201_2/ADVICE";

    const Statements = "/../../../Jethro/JALERT201_3/STMT";
	const Statements2 = "/../../../Jethro/JALERT201_4/STMT";
	const Swifts = "/../../../Jethro/JALERT201_3/SWIFT";
	const Swifts2 = "/../../../Jethro/JALERT201_4/SWIFT";

	const Errlttr = "/../../../Jethro/JALERT201/channels/lttrt/failure";
	const Errlttr2 = "/../../../Jethro/JALERT201_2/channels/lttrt/failure";
	const Erltrbkp = "/../../../Jethro/JALERT201/channels/lttrt/failurebkp";
	const Erltrbkp2 = "/../../../Jethro/JALERT201_2/channels/lttrt/failurebkp";

    const Errstmt = "/../../../Jethro/JALERT201_3/channels/stmtt/failure";
	const Errstmt2 = "/../../../Jethro/JALERT201_4/channels/stmtt/failure";
    const Erstbkp = "/../../../Jethro/JALERT201_3/channels/stmtt/failurebkp";
	const Erstbkp2 = "/../../../Jethro/JALERT201_4/channels/stmtt/failurebkp";



class Pathconf {

	//recreate broken directories function
	function makeDir($path)
	{
		$mode=0777;
		return is_dir($path) || mkdir($path, $mode, true);
	}

	//recreate folder structure
	function ReacDir($Varstrut){
		foreach ($Varstrut as $strut)
		{
			$this->makeDir($strut);
		}
	}

	//get main directories
	function GetMainDir(){
		//primary folder
		$P = __DIR__.Prime;

		return compact('P');
	}

	//get main directories
	function GetBackDir(){
		//backup folder
		$B = __DIR__.Backup;
		$D = __DIR__.Duplicate;

		return compact('B','D');
	}
	//get error handle directories
	function GetErrDir(){
		//statements  error primary and secondary
		$ES = __DIR__.Errstmt;
		$es = __DIR__.Errstmt2;
		//statement error backup primary and secondary
		$ERS = __DIR__.Erstbkp;
		$ers = __DIR__.Erstbkp2;

		//notifications  error primary and secondary
		$ET = __DIR__.Errlttr;
		$et = __DIR__.Errstmt2;
		//notifications error backup primary and secondary
		$ERT = __DIR__.Erltrbkp;
		$ert = __DIR__.Erltrbkp2;

		return compact('ES','es','ERS','ers','ET','et','ERT','ert');
	}
	//collect all intermediary paths
    function GetDirInf(){
		//user import folder
		$U = __DIR__.Uimport;
		$u = __DIR__.Uimport2;
        //notifications	primary and secondary
		$N = __DIR__.Notifications;
		$n = __DIR__.Notifications2;
		//statements primary and secondary
		$S = __DIR__.Statements;
		$s = __DIR__.Statements2;
		//swifts primary and secondary
		$SW = __DIR__.Swifts;
		$sw = __DIR__.Swifts2;
		//advices primary and secondary
		$A = __DIR__.Advices;
		$a = __DIR__.Advices2;//

        return compact('U','u','N','n','S','s','SW','sw','A','a');
    }


}

?>