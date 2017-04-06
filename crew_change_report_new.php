<?php 
session_start(); 
// error_reporting(0);
 set_time_limit(0); 
 include_once( 'connect.php');
  //print_r($_REQUEST); 
  $imei=$_POST['equip_imei'];
  $crew=$_POST['crew_name'];
  $from=$_POST[ 'from_date']. " ".$_POST[ 'from_time']. ":00";
  $to=$_POST[ 'to_date']. " ".$_POST[ 'to_time']. ":00"; 
  $report="select * from tbl_driverchnage where requesttime > '".$from."' and requesttime < '".$to."' and  (imei='".$imei."'or crew='".$crew."')order by requesttime";
  //echo "$report";
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>View Crew Change Report</title>
    <link rel="icon" href="image/icon.png" type="image/gif" sizes="16x16">
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <style>
        html,
        body,
        #map-canvas {
            height: 100%;
            margin: 0px;
            padding: 0px
        }
        /*.trip{
margin:10px;
border:2px solid black;
padding:10px;
font-weight:600;
align:center;
}*/
        div#cost input {
            width: 90px;
        }
        td {
            text-align: center;
            height: 5vh;
        }
        footer {
            color: black;
            padding-top: 1vh;
            padding-bottom: 0vh;
            background-color: white;
            border: 1px solid #BBBBBB;
            width: 98%;
        }
    </style>
    <script type="text/javascript" src="js/jquery.min.2.1.3.js"></script>
    <!-- <script type="text/javascript" src="js/drop.js"></script> -->

</head>

<body BGCOLOR='#d6dce2'>
    <center>
        <div id="container" style="width:98%;height:auto;margin:.8vh;">
            <div id="wrappermap" style="background-color: #fff; height:auto; min-height:550px; border:1px solid black;">
                <table width="98%" style="margin:10px; table-layout:fixed;">
                    <tr>
                        <th align="left" style="width: 462px;">
                            <form action="get_crew_change_form.php" method="post">
                                <input type="hidden" name="mbval" value="reports" />
                                <input id="report_back" type="submit" value="Back" style="float:left;" />
                            </form>
                        </th>
                    </tr>
                </table>
                <center>
                    <h1>Crew Change Report</h1>
               
                    <h3>From: <?=date('m/d/Y h:i A',strtotime($_POST['from_date'].' '.$_POST['from_time']))?> &nbsp;&nbsp;&nbsp;
						To: <?=date('m/d/Y h:i A',strtotime($_POST['to_date'].' '.$_POST['to_time']))?></h3>
                        
                </center>
                <table border="0" width="100%" style=" border-spacing: 0px;">
                    <!-- <tr><th colspan="5">Departed</th><th colspan="4">Arrived</th><th colspan="5">Details</th></tr> -->
                    <tr>
                        <th>Date/Time</th>
                        <th>Equip#</th>
                        <th>Olddriver</th>
                        <th>Newdriver</th>
                        <th>OldCrew</th>
                        <th>NewCrew</th>
                        
                        <!-- <th>Time</th> -->
                    </tr>
                    <? $csv_string=",,,Crew Change Report\r\n".",From:,".date('m/d/Y h:i A',strtotime($_POST['from_date'].' '.$_POST['from_time'])).",To:,".date('m/d/Y h:i A',strtotime($_POST['to_date'].' '.$_POST['to_time']))."\r\n";

                     $csv_string=$csv_string."Date/Time,Equip#,Olddriver,Newdriver,OldCrew,NewCrew,\r\n";
                     $result=$conn->query($report);
                      /*$count=0 ; 
                     $isstart=false;*/ 
                    while($ereport=$result->fetch_object()){ ?>
                    <tr>
                         <td>
                            <?=date('m/d/Y H:i A',strtotime($ereport->requesttime))?>
                        </td>
                        <td>
                            <?=$ereport->name?>
                        </td>
                        <td>
                           <?=$ereport->olddriver?>
                        </td>
                        <td>
                           <?=$ereport->newdriver?>
                        </td>
                        <td>
                            <?=$ereport->oldcrew?>
                        </td>
                        <td>
                            <?=$ereport->crew?>
                        </td>
                       
                    </tr>
                    <? $csv_string=$csv_string.date(' m/d/Y H:i A',strtotime($ereport->requesttime)).",".$ereport->name.",".$ereport->olddriver.",".$ereport->newdriver.",".$ereport->oldcrew.",".$ereport->crew."\r\n"; 
                    } ?>
                </table>
                <textarea id="csv_string" style="display:none;">
                    <?=$csv_string?>
                </textarea>
                <center>

                    <? function timediff($etime,$stime){ 
		                    $datetime1=new DateTime($etime);
		                    $datetime2=new DateTime($stime);
		                    $interval=$datetime1->diff($datetime2); 
		                    $dd = $interval->format('%a days');
		                    //echo $dates; //$dt=0; 
		                    if($dd >0){ 
		                    $dd=$dd*24; 
		                    } 
		                    $hh = $interval->format('%H'); 
		                    $d=$dd+$hh; 
		                    $mm = $interval->format('%I:%S'); //$ss = $interval->format('%S'); //echo $mm; 
		                    if($d <9) {
		                     $d='0' .$d; 
		                     } //echo $d. ':'.$mm. ':'.$ss; 
		                    return $d. ':'.$mm;
                     } ?>
                        <div id="butns" style="padding: 20px 24% 20px 24%;">
                            <input type="button"  style=" width: auto; min-width: 25%; font-weight: 700; height: 40px; cursor:pointer; background: url('image/3_d_button.png'); background-size: 100% 100%; border:0px;" onclick="PrintElem()" value="Print"
                            />
                            <input type="button"  style=" width: auto; min-width: 25%; font-weight: 700; height: 40px; cursor:pointer; background: url('image/3_d_button.png'); background-size: 100% 100%; border:0px;" onclick="exc()" value="Send CSV" />
                            <a id="csv_link" href="">
                                <input type="button" style=" width: auto;  min-width: 25%;  font-weight: 700;  height: 40px; cursor:pointer; background: url('image/3_d_button.png'); background-size: 100% 100%; border:0px;" onclick="exc_download()"
                                value="Download CSV" />
                            </a>
                        </div>
                        <!--butns div close -->
            </div>
            </center>
            </form>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
            <script>
                function exc() {
                    //alert($("#csv_string").val());
                    $.post("create_csv.php", {
                        csv_string: $("#csv_string").val()
                    }, function(data) {
                        filename = data;
                        var email = prompt("Send CSV to Email");
                        if (email != '' & email != null) {
                            $.post("create_csv.php", {
                                email: email,
                                csv_string: $("#csv_string").val(),
                                create_for: 'Crew Change'
                            }, function(data) { alert(data);
                                alert("Email send successfully to " + email);
                            });
                        } else {
                            return false;
                        }
                    });
                }

                function exc_download() {
                    //alert($("#csv_string").val());
                    $.post("create_csv.php", {
                        csv_string: $("#csv_string").val(),
                        create_for: 'Crew Change'
                    }, function(data) {
                        //alert(data);
                        $("#csv_link").attr("href", data);
                        document.getElementById("csv_link").click();
                    });
                }
            </script>
            <script type="text/javascript">
                function PrintElem() { //alert(data);
                    $("#butns").hide();
                    window.print();
                    $("#butns").show();
                    $("#report_back").show();
                    return true;
                }
            </script>



        </div>
        <!---wrappermap close -->

        </div>
    </center>
    <!--- container close -->
    <center>
        <div>
            <? include_once( 'fotter.php'); ?>