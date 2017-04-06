<? 
include_once("connect.php");  //print_r($_POST);<? 

 if($_POST['p']=='1'){  // Hierarchical View ->for section
          //$company = $_POST['id'];
          //echo $company;

       ?>
                 <script>
                   
                  collect_bu=[];
                  $('#comp_action,#bu_action,#loc_action,#wrkgrp_action').hide();
                  $('#sec_action').show();
                  
                  //$('#add').val('Add Section');
                  //$('#edit').val('Edit Section');
                  var company = '<?=$_POST['com_id']?>';//alert(company);
                  var what = '<?=$_POST['p']?>';
                  var butt_seq = company;
                  localStorage.setItem("butt_seq", butt_seq);
                  $("#text").html('');
                  $('#add_sec').click(function(){
    
                    var qry_string = "select * from tbl_combination where company='"+company+"' and what='"+what+"'";
                    $.post('get_multiselect_view.php',{for:'sec',query:qry_string,company:company,what:what},function(data){
                          //alert(data);
                          $('#text').html(data);
                    });
                  });

                  $('#edit_sec').click(function(){
                    var right_click_val = $('#right_click_val').val();
                    var qry_string = "select * from tbl_combination where company='"+company+"' and what='"+what+"'";
                    $.post('get_multiselect_view.php',{status:'edit',for:'sec',query:qry_string,company:company,what:what,r_c_val:right_click_val},function(data){
                          //alert(data);
                          $('#text').html(data);
                    });
                  });
                </script>

                <table class="combtable" style="width: auto;font-size: small;">
                    <!-- <tr>
                        <td><b>(Section)</b></td>
                    </tr> -->
                    <caption style="text-align: center;"><b>Section</b></caption>
                    <tr class="tasks">
                        <? //echo "select section from tbl_combination where company='".$_POST['id']."' and what='".$_POST['p']."'";
                        $res=$conn->query("select * from tbl_combination where company='".$_POST['id']."' and what='".$_POST['p']."'")->fetch_object();
                       
                           if($res->section == ''){?>
                              <script>
                              $("#context-menu2").addClass("context-menu-yes");
                              $("#sec_action").css('margin-top','2vh');
                              //$("#edit_sec").prop("disabled",true);
                              </script>
                           <?}else{?>
                              <script>
                              $("#context-menu2").removeClass("context-menu-yes");
                              $("#sec_action").css('margin-top','17vh');
                              //$("#edit_sec").prop("disabled",false);
                              </script>
                           <?
                           //echo "select id,name from role_primary where id in(".$res->section.")";
                        $res1=$conn->query("select id,name from role_primary where id in(".$res->section.")");
                        while($data=$res1->fetch_object()){
                          //print_r($data);
                          ?>
                          <script>
                            collect_sec.push('<?=$data->id?>');
                          </script>
                          <td class="task2">
                             <div style="font-size:x-large">&dArr;</div> <div class="task__content"><input style="margin : 0.5vw;" class="curr_butt" oncontextmenu="$('#right_click_val').val('<?=$data->id?>')" id="section<?=$data->id?>" type="button" onclick="get_combi('<?=$_POST['id']?>','2','<?=$data->id?>','<?=$data->id?>','','')" class="panel-primary" value="<?=$data->name?>">
                             </div><!--</span>--><br>
                              <div id="sec_<?=$data->id?>" style="font-size:x-large;display:none;">&dArr;</div>
                        </td>
                      <?}}?>
                  </tr>
              </table>
  <?}else if($_POST['p'] == '2'){  // for business unit
    //print_r($_POST);
    ?>
              <script>
            
                  $(function(){
                    var td_co = $("#loc_tb_bu td").length;
                    
                       var n_rows = td_co/7;
                 var x = 1;
               for(var i = 0; i <= n_rows; i++)
               {               
                  x++;
              $('#loc_tb_bu tr').eq(i).after('<tr></tr>');
              $('#loc_tb_bu tr:eq('+i+') td.task3:gt(6)') 
               .detach()

               .appendTo('#loc_tb_bu tr:nth-child('+x+')');
                }

            });
                  collect_bu=[];
                  $('#sec_action,#comp_action,#loc_action,#wrkgrp_action').hide();
                  $('#bu_action').show();
                  //$('#add').val('Add Section');
                  //$('#edit').val('Edit Section');
                  $("#text").html('');
                  var company = '<?=$_POST['com_id']?>';
                  var section = '<?=$_POST['sec_sel_id']?>';
                  var butt_seq1 = section;
                  localStorage.setItem("butt_seq1", butt_seq1);
                   var what = '<?=$_POST['p']?>';
                  $('#add_bu').click(function(){
  
                    var qry_string = "select * from tbl_combination where company='"+company+"' and section='"+section+"' and what='"+what+"'";
                    $.post('get_multiselect_view.php',{for:'bu',query:qry_string,company:company,section:section,what:what},function(data){
                          //alert(data);
                          $('#text').html(data);
                    });
                  });

                  $('#edit_bu').click(function(){
                     var right_click_val = $('#right_click_val').val();
                    var qry_string = "select * from tbl_combination where company='"+company+"' and section='"+section+"' and what='"+what+"'";
                    $.post('get_multiselect_view.php',{status:'edit',for:'bu',query:qry_string,company:company,section:section,what:what,r_c_val:right_click_val},function(data){
                          //alert(data);
                          $('#text').html(data);
                    });
                  });
              </script>
              <table id="loc_tb_bu" class="combtable" style="width: auto;font-size: small;">
                    <!-- <tr>
                        <th style='' colspan='10'><b>(Business Unit)</b></th>
                    </tr> -->
                    <caption style="text-align: center;"><b>Business Unit</b></caption>
                    <tr class="tasks">
              <? 
                $res=$conn->query("select * from tbl_combination where company='".$_POST['com_id']."' and section='".$_POST['sec_sel_id']."' and what='".$_POST['p']."'")->fetch_object();
               
                        if($res->business_unit == ''){?>
                              <script>
                              $("#context-menu3").addClass("context-menu-yes");
                             </script>
                           <?}else{?>
                              <script>
                              $("#context-menu3").removeClass("context-menu-yes");
                              </script>
                        <? //echo "select id,name from role_group  where id in(".$res->business_unit.") group by name ";
                        $res1=$conn->query("select id,name from role_group  where id in(".$res->business_unit.") group by name");
                             
                          while($data=$res1->fetch_object()){?>
                            <script>
                            collect_bu.push('<?=$data->id?>');
                            </script>
                            <td class="task3">
                                <div style="font-size:x-large;">&dArr;</div><div class="task__content">
                                <input style="margin : 0.1vw;" class="curr_butt" oncontextmenu="$('#right_click_val').val('<?=$data->id?>')" id="business_unit<?=$data->id?>" type="button" onclick="get_combi('<?=$_POST['com_id']?>','3','<?=$data->id?>','<?=$_POST['sec_sel_id']?>','<?=$data->id?>','')" class="panel-primary" value="<?=$data->name?>"><!--</span>--></div><br>
                                <div id="bu_<?=$data->id?>" style="font-size:x-large;display:none;">&dArr;</div>
                            </td>
                          <?}}?>
                </tr>
            </table>
<?
}else if($_POST['p'] == '3'){   // for Location
  ?>
          <script>
           $(function(){
                    var td_co = $("#loc_tb td").length;
                    
                       var n_rows = td_co/5;
                 var x = 1;
               for(var i = 0; i <= n_rows; i++)
               {               
                  x++;
              $('#loc_tb tr').eq(i).after('<tr></tr>');
              $('#loc_tb tr:eq('+i+') td.task4:gt(4)') 
               .detach()

               .appendTo('#loc_tb tr:nth-child('+x+')');
                }

            });
            collect_loc=[];
                  $('#bu_action,#sec_action,#comp_action,#wrkgrp_action').hide();
                  $('#loc_action').show();
                  //$('#add').val('Add Section');
                  //$('#edit').val('Edit Section');
				          $("#text").html('');
                  var company = '<?=$_POST['com_id']?>';
                  var section = '<?=$_POST['sec_sel_id']?>';
                  var bu = '<?=$_POST['bu_sel_id']?>';
                  var butt_seq2 = bu;
                  localStorage.setItem("butt_seq2", butt_seq2);
                   var what = '<?=$_POST['p']?>';
                  $('#add_loc').click(function(){
  
					var qry_string = "select * from tbl_combination where company='"+company+"' and section='"+section+"' and  business_unit='"+bu+"' and what='"+what+"'";
                    $.post('get_multiselect_view.php',{for:'loc',query:qry_string,company:company,section:section,bu:bu,what:what},function(data){
                          //alert(data);
                          $('#text').html(data);
                    });
                  });

                  $('#edit_loc').click(function(){
                  var right_click_val = $('#right_click_val').val();
					var qry_string = "select * from tbl_combination where company='"+company+"' and section='"+section+"' and  business_unit='"+bu+"' and what='"+what+"'";
                    $.post('get_multiselect_view.php',{status:'edit',for:'loc',query:qry_string,company:company,section:section,bu:bu,what:what,r_c_val:right_click_val},function(data){
                          //alert(data);
                          $('#text').html(data);
                    });
                  });
          </script>
          <table id="loc_tb" class="combtable" style="width: auto;font-size: small;">
                   <!--  <tr>
                        <td><b>(Location)</b></td>
                    </tr> -->
                     <caption style="text-align: center;"><b>Location</b></caption>
                    <tr class="tasks">
          <? //echo "select location from tbl_combination where company='".$_POST['com_id']."' and section='".$_POST['sec_sel_id']."' and business_unit='".$_POST['bu_sel_id']."' and what='".$_POST['p']."'";
          
              $res=$conn->query("select * from tbl_combination where company='".$_POST['com_id']."' and section='".$_POST['sec_sel_id']."' and business_unit='".$_POST['bu_sel_id']."' and what='".$_POST['p']."'")->fetch_object();
             
                       if($res->location == ''){?>
                              <script>
                              $("#context-menu4").addClass("context-menu-yes");
                              </script>
                           <?}else{?>
                              <script>
                              $("#context-menu4").removeClass("context-menu-yes");
                              </script>
                      <? //echo "select id,name from role_dept  where id in(".$res->location.")group by name";
                      $res1=$conn->query("select id,name from role_dept  where id in(".$res->location.")group by name");

                          while($data=$res1->fetch_object()){?>
                            <script>
                              collect_loc.push('<?=$data->id?>');
                            </script>
                            <td class="task4">
                                <div style="font-size:x-large;">&dArr;</div><div class="task__content"><input style="margin : 0.2vw;" class="curr_butt" oncontextmenu="$('#right_click_val').val('<?=$data->id?>')" id="location<?=$data->id?>" type="button" onclick="get_combi('<?=$_POST['com_id']?>','4','<?=$data->id?>','<?=$_POST['sec_sel_id']?>','<?=$_POST['bu_sel_id']?>','<?=$data->id?>')" class="panel-primary" value="<?=$data->name?>"><!--</span>--></div><br>
                                <div id="loc_<?=$data->id?>" style="font-size:x-large;display:none;">&dArr;</div>
                            </td>
                        <?}}?>
                    </tr>
              </table>
<?}else if($_POST['p'] == '4'){ // for Workgroup
  ?>
  <script>
                $('#loc_action,#bu_action,#sec_action,#comp_action').hide();
                  $('#wrkgrp_action').show();
                  //$('#add').val('Add Section');
                  //$('#edit').val('Edit Section');
				          $("#text").html('');
                  var company = '<?=$_POST['com_id']?>';
                  var section = '<?=$_POST['sec_sel_id']?>';
                   var bu = '<?=$_POST['bu_sel_id']?>';
                    var loc = '<?=$_POST['loc_sel_id']?>';
                    var butt_seq3 = loc;
                  localStorage.setItem("butt_seq3", butt_seq3);
                   var what = '<?=$_POST['p']?>';
                  $('#add_wrkgrp').click(function(){
  
					       var qry_string = "select * from tbl_combination where company='"+company+"' and section='"+section+"' and  business_unit='"+bu+"' and location='"+loc+"' and what='"+what+"'";
                    $.post('get_multiselect_view.php',{for:'wrkgrp',query:qry_string,company:company,section:section,bu:bu,loc:loc,what:what},function(data){
                          //alert(data);
                         // $('#text').html(data);
                    });
                  });

                  $('#edit_wrkgrp').click(function(){
                    var right_click_val = $('#right_click_val').val();
					var qry_string = "select * from tbl_combination where company='"+company+"' and section='"+section+"' and  business_unit='"+bu+"' and location='"+loc+"' and what='"+what+"'";
                    $.post('get_multiselect_view.php',{status:'edit',for:'wrkgrp',query:qry_string,company:company,section:section,bu:bu,loc:loc,what:what,r_c_val:right_click_val},function(data){
                          //alert(data);
                        //  $('#text').html(data);
                    });
                  });
  </script>
  <table class="combtable" style="width: auto;font-size: small;">
          <!-- <tr>
              <td><b>(Workgroup)</b></td>
          </tr> -->
       <!--  <caption style="text-align: center;"><b>Workgroup</b></caption>-->
          <tr class="tasks">
  <?
//echo "select workgroup from tbl_combination where company='".$_POST['com_id']."' and section='".$_POST['sec_sel_id']."' and business_unit='".$_POST['bu_sel_id']."' and location='".$_POST['loc_sel_id']."' and what='".$_POST['p']."'";
      $res=$conn->query("select * from tbl_combination where company='".$_POST['com_id']."' and section='".$_POST['sec_sel_id']."' and business_unit='".$_POST['bu_sel_id']."' and location='".$_POST['loc_sel_id']."' and what='".$_POST['p']."'")->fetch_object();
      
                      if($res->workgroup == ''){?>
                              <script>
                              $("#context-menu5").addClass("context-menu-yes");
                              </script>
                           <?}else{?>
                              <script>
                              $("#context-menu5").removeClass("context-menu-yes");
                              </script>
                      <? $res1=$conn->query("select id,name from tbl_workgroup  where id in(".$res->workgroup.")");

              /*while($data=$res1->fetch_object()){?>
                <td class="task5">
                  <div style="font-size:x-large;">&dArr;</div>
                  <div class="task__content"><input style="margin : 0.5vw;" class="curr_butt" oncontextmenu="$('#right_click_val').val('<?=$data->id?>')" type="button" class="panel-primary"  value="<?=$data->name?>"></div>
                </td>
            <?}*/}?>
          </tr>
         
      </table>
<?
}
?>
