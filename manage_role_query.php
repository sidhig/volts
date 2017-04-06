<? include_once('connect.php'); 
  session_start(); 
$sql = "select *,if(`view` = 0,'Superadmin',if(`view` = 1,'Admin',if(`view` = 3,'Normal',if(`view` = 2,'View Only',if(`view` = 4,'Scheduler Admin',if(`view` = 5,'Schedule user','')) )) ) ) as Roleview
 from tbl_role_user where  `view`!=0 order by id desc"; 
$result = $conn->query($sql); 
while($obj = $result->fetch_object()){
  if($obj->role_name !='superadmin'){
  ?>
  <tr> 
  <td><?=$obj->name?></td>
 <td><?=$obj->username?></td>
 <td><?=$obj->Roleview?></td>

 <td><!-- <input type="button" value="Users" onclick="view_role_users('<?=$obj->role_name?>')">&nbsp;<input type="button" value="View" onclick="manage_role_view('<?=$obj->role_name?>')"> -->
  <image onclick="edit_role_user('<?=$obj->username?>')" style='cursor: pointer;'src="image/edit.png" >
  <image src="image/deny.png" style='cursor: pointer;' onclick="del_role_user('<?=$obj->username?>')" ></td>  
  </tr>
<?}}?>