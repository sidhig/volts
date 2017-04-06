  <?
 include_once('connect.php');//print_r(@$_POST);
 ?>
 <link rel="image icon" type="image/png" href="image/icon.png">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/jquery.min.js"></script>
<title>View Hierarchy</title>
  <script src="js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="css/bootstrap-multiselect.css"> 
    <link rel="stylesheet" href="css/style.css"> 
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css">
   <script src="js/bootstrap-multiselect.js"></script>
   <style>
  .navbar-nav>li>a {
    padding-top: 3px;
    padding-bottom: 4px;
}
.btn {
    display: inline-block;
    padding: 0px 11px;
    }
 .form-control {
  height: 25px;
  padding: 3px 6px; 
 }   
 
.container-fluid>.navbar-header{
      margin-top: 1vh;
    }
/*select[multiple], select[size] {
    height: 16px!important;
}*/
.multiselect-container>li>a>label{
      height:auto;
    }
  .multiselect-container{
      max-height: 50vh;
    overflow: auto;
  }
   /*.container-fluid
{ 
min-height:14vh;
}*/
    label.checkbox:hover{
color:black;
    }
     label.checkbox{
color:black;
background-color: #D9DDE0;
    }
    .navbar-inverse .navbar-nav .open .dropdown-menu>.active>a, .navbar-inverse .navbar-nav .open .dropdown-menu>.active>a:focus, .navbar-inverse .navbar-nav .open .dropdown-menu>.active>a:hover{
     background-color: #9d9d9d;
    }

    .table>tbody>tr>td{
  vertical-align: middle;
}
.set_td{
  text-align: right;
}
  </style>
<style>
body{
	 background-color: #d6dce2;
}
th{
	text-align: center;
}
td{
  text-align: center;
}
.container{
width: auto;
background-color: white;
margin-top: 1vh;
margin-bottom: 1vh;	
padding-right: 9px;
    padding-left: 15px;
}
.list{
  width:15vw;
}
.intp{
  border-radius: 4px;
  height: 4vh;
  margin-bottom: 1vh;
  margin-left: 1vw;
  width:15vw;
  border:1px solid #D3D3D3;
}
.col-sm-12{
padding-right: 5px;
padding-left: 0px;
}
@media only screen and (max-width: 768px) {
   
    .list{
        width: 100%;
    }
    .col-sm-12{
        width: 100%;

    }
}
.verticalLine {
    border-left: thin solid #ff0000;

}
hr { 
    display: block;
    margin-top: 0.0em;
    margin-bottom: 0.0em;
    margin-left: auto;
    margin-right: auto;
    border-style: inset;
    border-width: 2px;
}

.curr_butt_click{
        background: lightgreen;
    }
.curr_butt:focus{
        background: lightgreen;
    }

.combtable{
    border-top: black;
}
</style>

<script>
$(document).ready(function(){ 
 
	var seq_str = localStorage.getItem("sequence");//alert(seq_str);
		if(seq_str != null && seq_str != ''){
			var seq_arr = seq_str.split(',');
		//alert(seq_arr);
		$("#company"+seq_arr[0]).click();
	
		setTimeout(function(){
			$("#section"+seq_arr[1]).click();
		},1000);
	
		setTimeout(function(){
			$("#business_unit"+seq_arr[2]).click();
		},1500);
	
		setTimeout(function(){
			$("#location"+seq_arr[3]).click();
		},2000);
		
	}
	var collect_loc= new Array();
	var collect_bu= new Array();
});
</script>

<center>
<div style='margin-top: 5vw;height: auto;min-height:50vh;background:white; font-size: 1.3rem;width: 95%; border-radius: 15px; padding: 5px; border: 2px solid #969090;'>
<div class="container">

<b>Click buttons to view hierarchy</b>

<input type="button" style="float:left;" value="Back" onclick="localStorage.clear();window.top.close();">
<?
	$res=$conn->query("select * from role_opco where id in (select company from tbl_combination group by company) order by name asc");
	?>
<script>

var collect_comp=new Array();
var collect_sec= new Array();
var i = 0;

function get_combi(com_sel_id,parent,ch_id,sec_sel_id,bu_sel_id,loc_sel_id){ //alert(com_sel_id);
	i++;
	remove_button_color();
	add_button_color(com_sel_id,sec_sel_id,bu_sel_id,loc_sel_id);
	var seq_str = localStorage.getItem("sequence");
		if(seq_str != null && seq_str != ''){
			var seq_arr = seq_str.split(',');
			if(seq_arr.length == i){
				localStorage.clear();
			}
		}

	if(parent == '1'){
		var popup_for = '2';
	}else if(parent == '2'){
		var popup_for = '3';
	}else if(parent == '3'){
		var popup_for = '4';
	}else if(parent == '4'){
		var popup_for = '5';
	}
		init(popup_for);

	set_ver_line(parent,ch_id);
	$.post('menu_type.php',{ com_id:com_sel_id,p:parent,id:ch_id,sec_sel_id:sec_sel_id,bu_sel_id:bu_sel_id,loc_sel_id:loc_sel_id},function(data){

		$('#'+parent+'_data').html(data);
		
	});

}

function add_button_color(c_id,s_id,b_id,l_id){

	$('#company'+c_id).addClass('curr_butt_click');
	$('#section'+s_id).addClass('curr_butt_click');
	$('#business_unit'+b_id).addClass('curr_butt_click');
	$('#location'+l_id).addClass('curr_butt_click');
}

function remove_button_color(){ //alert(c_id);
	var but_seq_str = localStorage.getItem("butt_seq");
	var but_seq_str1 = localStorage.getItem("butt_seq1");
	var but_seq_str2 = localStorage.getItem("butt_seq2");
	var but_seq_str3 = localStorage.getItem("butt_seq3");
	$('#company'+but_seq_str).removeClass('curr_butt_click');
	$('#section'+but_seq_str1).removeClass('curr_butt_click');
	$('#business_unit'+but_seq_str2).removeClass('curr_butt_click');
	$('#location'+but_seq_str3).removeClass('curr_butt_click');
		
		//alert(but_seq_arr);
	
}

function set_ver_line(parent,ch_id){
	//match.push(arrow_id);
	if(parent == '1'){ //alert(collect_comp);
		/*$.each(collect_comp,function(index,value){
			if(value != ch_id){
				$('#comp_'+value).hide();
			}else{
				$('#comp_'+value).show();
			}
		});*/
		$('#comp_horiz,.section').show();
		$('#3_data,#sec_ver_line1,#sec_horiz,#bu_horiz,#4_data,#sec_ver_line2,#sec_ver_line,#2_data,#opco_horiz').hide();//alert(parent+'/'+ch_id);
		
	}else if(parent == '2'){ //alert(collect_sec);alert(match);alert(arrow_id);
		/*$.each(collect_sec,function(index,value){
			if(value != ch_id){
				$('#sec_'+value).hide();
			}else{
				$('#sec_'+value).show();
			}
		});*/
		$('#opco_horiz,#2_data').show();
		$('#3_data,#sec_ver_line1,#sec_horiz,#bu_horiz,#4_data,#sec_ver_line2').hide();
	}else if(parent == '3'){ //alert(collect_bu);alert(match);alert(arrow_id);
		/*$.each(collect_bu,function(index,value){
			if(value != ch_id){
				$('#bu_'+value).hide();
			}else{
				$('#bu_'+value).show();
			}
		});*/
		$('#3_data,#sec_ver_line1,#sec_horiz,#4_data').show();
		$('#4_data,#sec_ver_line2,#bu_horiz').hide();
	}else if(parent == '4'){ //alert(collect_loc); alert(match);
		/*$.each(collect_loc,function(index,value){
			if(value != ch_id){
				$('#loc_'+value).hide();
			}else{
				$('#loc_'+value).show();
			}
		});*/
		$('#4_data,#sec_ver_line2,#bu_horiz').show();
	}
	match.pop();
	
}
var match= new Array();
				$(document).ready(function(){
					init('1');
				});
	</script>
	<table style="font-size:small;margin-top: 2vh;">
	<tr>
	<caption style="text-align: center;"><b>Company</b></caption>
	</tr>
	<tr class="tasks" style="border-top: 2px solid black;">
	<?
	while($d=$res->fetch_object()){
		?>
				<script>
				
					collect_comp.push('<?=$d->id?>');
				</script>
				<td class="task1" data-id="1" >
				<div style="font-size:x-large;">&dArr;</div>
				<div class="task__content"><input type="button"  class="curr_butt" oncontextmenu="$('#right_click_val').val('<?=$d->id?>')" style="margin : 0.5vw;" id="company<?=$d->id?>" class="panel-primary opco_butt" onclick="get_combi('<?=$d->id?>','1','<?=$d->id?>','','','')" value="<?=$d->name?>"></div><br>
			<div id="comp_<?=$d->id?>" style="display:none;font-size:x-large;">&dArr;</div>
			</td>
	<?}
?>
</tr>
</table>
<style>
    .combtable{
        border-top: 2px solid black;
    }
</style>

<span id="1_data"></span>

<span id="2_data"></span>

<span id="3_data"></span>

<span id="4_data"></span>

<div id ="comp_action"> 
  <nav id="context-menu1" class="context-menu">
    <ul class="context-menu__items">
      <li class="context-menu__item">
       	 <a href="#" class="context-menu__link" data-action="View">
       	  <input type="button" id="edit_comp" value="Edit Company" >
       	 </a>
      </li>
      <li class="context-menu__item">
         <a href="#" class="context-menu__link" data-action="View">
        <input type="button" id="add_comp" value="Add Company" >
         </a>
      </li>
    </ul>
  </nav>
</div> 

<div id ="sec_action" style="margin-top: 17vh;display:none;">
	<nav id="context-menu2" class="context-menu">
    <ul class="context-menu__items">
      <li class="context-menu__item">
		<a href="#" class="context-menu__link" data-action="View">
		<input type="button" id="edit_sec" value="Edit Section" >
		</a>
	</li>
      <li class="context-menu__item">
      <a href="#" class="context-menu__link" data-action="View">
      <input type="button" id="add_sec" value="Add Section" >
      </a>
      </li>
    </ul>
  </nav>
</div>

<div id ="bu_action" style="margin-top: 2vh;display:none;">
<nav id="context-menu3" class="context-menu">
    <ul class="context-menu__items">
      <li class="context-menu__item">
		<a href="#" class="context-menu__link" data-action="View">
			<input type="button" id="edit_bu" value="Edit Business Unit" >
		</a>
		</li>
	  <li class="context-menu__item">
	  	<a href="#" class="context-menu__link" data-action="View">
	  	<input type="button" id="add_bu" value="Add Business Unit" >
	  	</a>
	  </li>
	 </ul>
</nav>
</div>

<div id ="loc_action" style="margin-top: 2vh;display:none;">
<nav id="context-menu4" class="context-menu">
    <ul class="context-menu__items">
      <li class="context-menu__item">
		<a href="#" class="context-menu__link" data-action="View">
			<input type="button" id="edit_loc" value="Edit Location" >
		</a>
	 </li>
	 <li class="context-menu__item">
	  	<a href="#" class="context-menu__link" data-action="View">
	  	<input type="button" id="add_loc" value="Add Location" >
	  </a>
	  </li>
	 </ul>
</nav>
</div>

<div id ="wrkgrp_action" style="margin-top: 2vh;display:none;">
<nav id="context-menu5" class="context-menu">
    <ul class="context-menu__items">
      <li class="context-menu__item">
		<a href="#" class="context-menu__link" data-action="View">
			<input type="button" id="edit_wrkgrp" value="Edit Workgroup" >
		</a>
	 </li>
	 <li class="context-menu__item">
	  	<a href="#" class="context-menu__link" data-action="View">
	  	<input type="button" id="add_wrkgrp" value="Add Workgroup" >
	  	</a>
	  </li>
	 </ul>
</nav>
</div>

<div id="action" style="margin-top:2vh;"> </div>
<center><div id="text" ></div></center>
</div>
<script>

$('#add_comp').click(function(){
	//alert('Company');
	$.post('get_multiselect_view.php',{status:'add',for:'comp'},function(data){
		  //alert(data);
		  $('#text').html(data);
     });
	 
});

$('#edit_comp').click(function(){
	var right_click_val = $('#right_click_val').val();
	$.post('get_multiselect_view.php',{status:'edit',for:'comp',r_c_val:right_click_val},function(data){
		  //alert(data);
		  $('#text').html(data);
     });
});

</script>
<input type="hidden" id="right_click_val" value="">
<? include_once('right_click_popup.php');?>
</div>
</center>