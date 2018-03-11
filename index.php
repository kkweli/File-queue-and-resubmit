<?php
/**
 * Created by PhpStorm.
 * User: A188656
 * Date: 2016/12/15
 * Time: 02:31 PM
 */

//include connection module for modelling functions
include_once(__DIR__ .'/Model/modal_db.php');
ini_set('max_execution_time', 0);
?>
<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <title>QRM Configuration</title>
    <script src="js/modernizr.js" type="text/javascript"></script>
    <link rel="stylesheet" href="css/reset.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h1 class="heading-primary">Queue & Resubmit Manager</h1>
    <div class="accordion">
        <dl>
            <dt>
                <a href="#accordion1" aria-expanded="false" aria-controls="accordion1"
                   class="accordion-title accordionTitle js-accordionTrigger">Control J-Alert Traffic Optimise Queue Module</a>
            </dt>
            <dd class="accordion-content accordionItem is-collapsed" id="accordion1" aria-hidden="true">
                <form name="repress" action="" method="post">
                    <!-- Squared ONE -->
                    <div class="squaredOne" style="margin-left: 200px;">
                        <input type="checkbox" value="1" id="squaredOne" name="stmt" />
                        <label for="squaredOne">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Statements</label>
                    </div>

                    <!-- Squared TWO -->
                    <div class="squaredfour" style="margin-left: 200px;">
                        <input type="checkbox" value="1" id="squaredfour" name="lttr" />
                        <label for="squaredfour">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Notifications</label>
                    </div>

                    <div style="margin-left: 200px;">
                        <input type="submit" value="Close Queue" name="rep" class="fsSubmitButton" />
                        <input type="submit" value="Open Queue" name="rein" class="SsSubmitButton" />

                    </div>
                </form>

            </dd>
        </dl>
    </div>
    <?php
    //post status updates here for queue management
    echo "<br />";
    $Repconsole = Selallscnd("ecategory","e_locked",1);
    //verify count
     $rT = mysql_num_rows($Repconsole);

    if ($rT !=0) {
        //iterate and display reports
        while ($reprW = mysql_fetch_array($Repconsole)) {
            echo "<div class='notice info'><span>".$reprW['e_desc']." queue closed!</span></div>";
        }
    }else {
        echo "<div class='notice info'><span>Zero closed queues!</span></div>";

    }

    //suppress sequences
    if (isset($_POST['rep'])){

        if (isset($_POST['stmt']) && $_POST['stmt']=1){
        //update lock value on statements
            $SupStm = SngUpdstr("ecategory","e_locked",1,"e_name","STMT");
            //repress all files under category
            //$Reinstfl = SngUpdt("file","fl_locked",1,"fl_ecatg",2,"fl_resubflg",0);
            //confirm update ctg
            $Ckcnfs = CkInsrtctg("ecategory","e_locked",1,"e_name","STMT");$Cncnts = mysql_num_rows($Ckcnfs);
            //confirm files cond
            //$CkFlcs = CkIcmpL("file","fl_locked",1,"fl_ecatg",2,"fl_resubflg",0);$Cnflcs = mysql_num_rows($CkFlc);

            if ($Cncnts!=0) {
                echo "<div class='notice success'><span>successfully Closed Statements Queue</span></div>";
            }else{
                echo "<div class='notice error'><span>Unsuccessfully Closed Statements Queue</span></div>";
            }
        }

            if (isset($_POST['lttr']) && $_POST['lttr']=1) {
                //update lock value on notification
                $SupStml = SngUpdstr("ecategory","e_locked",1,"e_name","LTTR");
                //repress all files under category
                //$Reinstfl = SngUpdt("file","fl_locked",1,"fl_ecatg",1,"fl_resubflg",0);

                //confirm update ctg
                $Ckcnf = CkInsrtctg("ecategory","e_locked",1,"e_name","LTTR"); $Cncnt = mysql_num_rows($Ckcnf);
                //confirm files cond
                //$CkFlc = CkIcmpL("file","fl_locked",1,"fl_ecatg",1,"fl_resubflg",0);$Cnflc = mysql_num_rows($CkFlc);

                if ($Cncnt!=0) {
                    echo "<div class='notice success'><span>successfully Closed Notifications Queue</span></div>";
                }else{
                    echo "<div class='notice error'><span>Unsuccessfully Closed Notifications Queue</span></div>";
                }

            }

        header('Refresh: 5; URL=index.php');
    }

    //reinstate sequence
    if (isset($_POST['rein'])){

        if (isset($_POST['stmt']) && $_POST['stmt']=1){

            //update lock value on statements
            $ReinStm = SngUpdstr("ecategory","e_locked",0,"e_name","STMT");
            //confirm update ctg
             $CkcnfRs = CkInsrtctg("ecategory","e_locked",0,"e_name","STMT"); $CncntRs = mysql_num_rows($CkcnfRs);
            if ($CncntRs!=0) {
                echo "<div class='notice success'><span>successfully Opened Statements Queue</span></div>";
            }else {
                echo "<div class='notice error'><span>Unsuccessfully Opened Statements Queue</span></div>";
            }
        }

        if (isset($_POST['lttr']) && $_POST['lttr']=1){
            $ReinLtr = SngUpdstr("ecategory","e_locked",0,"e_name","LTTR");
           //confirm update ctg
            $CkcnfLtr = CkInsrtctg("ecategory","e_locked",0,"e_name","LTTR");$Cncntltr = mysql_num_rows($CkcnfLtr);
            if ($Cncntltr!=0) {
                echo "<div class='notice success'><span>successfully Opened notifications queue</span></div>";
            }else {
                echo "<div class='notice error'><span>Unsuccessfully Opened notifications queue</span></div>";
            }
        }

        header('Refresh: 5; URL=index.php');


    }




    ?>
</div>

<script src="js/index.js"></script>

</body>
</html>
