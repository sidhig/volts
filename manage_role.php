<? include_once('connect.php'); ?>
<script>
function role_search(text_data,jo_object){
  jo = jo_object.find('tr');
 
    var data4 = capitalize(text_data.trim());
    var data5 = text_data.toLowerCase().trim();
    var data6 = text_data.toUpperCase().trim();
    var data7 = text_data.trim();
 
    jo.hide();
    jo.filter(function (i, v) {
        var $t = $(this);

            if ( ($t.is(":contains('" + data4 + "')")) || ($t.is(":contains('" + data5 + "')"))|| ($t.is(":contains('" + data6 + "')")) ||($t.is(":contains('" + data7 + "')"))) {
                return true;
            }
    
     return false;
    }).show();
}
$('#add_role').click(function(){
  $("#trip_sheet_div").load("add_role.php"); 
  //$("#trip_sheet_div").load("test_role.php"); // for testing
    $("#trip_sheet_div").show();
});

function edit_role_user(role){
$('#spin_loading1').show();
 $.ajax({
            type: "POST",
            url: "view_role.php",
            data: "role_name="+role,
            success: function(data) {
              //alert(data);
        //$("#manage_role").hide();
        $("#trip_sheet_div").html(data); 
        $("#trip_sheet_div").show();
        $('#spin_loading1').hide();
        //$("#user_load_spinner").hide();
            }
        }); 
}

</script>
<!-- <h3>Manage Area</h3> -->

 <div id='spin_loading1' style="color:red; clear: both; display:none;"><img src="image/spinner.gif" width="20px">Please wait...</div>
 <button onclick="$('#user_role').hide();$('#hrchy_btn').show();$('#manage_role').hide();$('#tracker').hide();$('#user_btn').show();$('#tracker_conf_btn').show();$('#setting_btn').show();$('#tracker_mgmt_btn').show();" style="top:22vh;position: absolute; left: 2vw;">Back</button>
 <input type="button" id='add_role' value="Add User" class="btn btn-warning" style="width:20vw; height:4rem; color:black; margin-top:3rem;" /><br />
 <center><div id="search" style="margin: 10px;font-size: medium;">
  Search : <input id="search_role"   oninput="role_search($(this).val(),$('#manage_role_query'));" style="padding: .1vh;height: 4%;"><br>
</div></center>
 <table border="1" style="width:80%; margin-top:20px; text-align: center; font-size: 1.35rem; background-color: white;">
 <thead>
   <tr> 
    <th style="text-align: center;">Name</th>
     <th style="text-align: center;">Username</th>
    <th style="text-align: center;">Role</th>
    <th style="text-align: center;">Edit /Delete</th>   
   </tr>
</thead>
   <tbody id="manage_role_query">
<? include_once('manage_role_query.php'); ?>

   </tbody>
</table> 