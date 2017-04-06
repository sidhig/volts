<?
include_once("connect.php"); 
if($_POST['for_what'] == 'comp'){  // for company
	$table = 'role_opco';
	
	if($_POST['action'] == 'add'){
		$name = $_POST['new_name'];
		$is_avail_id = check_exist($conn,$table,$name); // check for new company is exist in table or not
		if($is_avail_id != false){
			echo "This Company already exist";
		}else{
			$inserted_id = insert_name($conn,$table,$name);  // insert new company in table
			if($inserted_id != false){ //print_r($_POST);
				$status = insert_into_comb($conn,$inserted_id,'','','','',$_POST['what']);     // insert the combination for new company in combination table
				if($status){
					echo "Company successfully added";
				}
			}
		}
	}else if($_POST['action'] == 'edit'){
		$name = $_POST['exist_name'];
		$id = $_POST['exist_id'];
		update_devicedetails($conn,$table,$name,$id);
		$status = update_name($conn,$table,$name,$id);
		if($status)
		{
			echo "Company successfully updated";
		}
		
	}
}else if($_POST['for_what'] == 'sec'){  // for section
	$table = 'role_primary';
	
	if($_POST['action'] == 'add'){
		$name = $_POST['new_name'];
		$comb = $_POST['comb'];
		$company = $_POST['company'];
		$exist_id = $_POST['row_id'];
		//print_r($_POST);
		if($name != ''){
			$is_avail_id = check_exist($conn,$table,$name); // check for new section is exist in table or not
			if($is_avail_id != false){
				echo "This Section already exist";
			}else{
				$inserted_id = insert_name($conn,$table,$name);  // insert new section in table
				if($comb != '' && $comb != null){
					$new_comb = $comb.','.$inserted_id;
					$status = update_into_comb($conn,$company,$new_comb,'','','',$_POST['what'],$exist_id);
					if($status){
						echo "Section successfully added";
					}
				}else{
					$status = update_into_comb($conn,$company,$inserted_id,'','','',$_POST['what'],$exist_id);
					if($status){
						echo "Section successfully added";
					}
				}
			}
		}else{
			$status = update_into_comb($conn,$company,$comb,'','','',$_POST['what'],$exist_id);
			if($status){
				echo "Combination successfully done";
			}
		}
	}else if($_POST['action'] == 'edit'){
		$name = $_POST['exist_name'];
		$id = $_POST['exist_id'];
		update_devicedetails($conn,$table,$name,$id);
		$status = update_name($conn,$table,$name,$id);
		if($status)
		{
			echo "Section successfully updated";
		}
		
	}
}else if($_POST['for_what'] == 'bu'){  // for business unit
	$table = 'role_group';
	//print_r($_POST);
	if($_POST['action'] == 'add'){
		$name = $_POST['new_name'];
		$comb = $_POST['comb'];
		$company = $_POST['company'];
		$section = $_POST['section'];
		$exist_id = $_POST['row_id'];
		//$section = $_POST['section'];
		if($name != ''){
			$is_avail_id = check_exist($conn,$table,$name); // check for new business unit is exist in table or not
			if($is_avail_id != false){
				echo "This Business Unit already exist";
			}else{
				$inserted_id = insert_name($conn,$table,$name);  // insert new business unit in table
				if($comb != '' && $comb != null){
					$new_comb = $comb.','.$inserted_id;
					if($exist_id != ''){
					$status = update_into_comb($conn,$company,$section,$new_comb,'','',$_POST['what'],$exist_id);
					}else{
					$status = insert_into_comb($conn,$company,$section,$new_comb,'','',$_POST['what'],'');	
					}
					if($status){
						echo "Business Unit successfully added";
					}
				}else{
					if($exist_id != ''){
					$status = update_into_comb($conn,$company,$section,$inserted_id,'','',$_POST['what'],$exist_id);
					}else{
					$status = insert_into_comb($conn,$company,$section,$inserted_id,'','',$_POST['what'],'');	
					}
					if($status){
						echo "Business Unit successfully added";
					}
				}
			}
		}else{
			if($exist_id != ''){
			$status = update_into_comb($conn,$company,$section,$comb,'','',$_POST['what'],$exist_id);
			}else{
			$status = insert_into_comb($conn,$company,$section,$comb,'','',$_POST['what'],'');	
			}
			if($status){
				echo "Combination successfully done";
			}
		}
	}else if($_POST['action'] == 'edit'){
		$name = $_POST['exist_name'];
		$id = $_POST['exist_id'];
		update_devicedetails($conn,$table,$name,$id);
		$status = update_name($conn,$table,$name,$id);
		if($status)
		{
			echo "Business Unit successfully updated";
		}
		
	}
}else if($_POST['for_what'] == 'loc'){  // for location
	$table = 'role_dept';
	
	if($_POST['action'] == 'add'){
		$name = $_POST['new_name'];
		$comb = $_POST['comb'];
		$company = $_POST['company'];
		$section = $_POST['section'];
		$business_unit = $_POST['business_unit'];
		$exist_id = $_POST['row_id'];
		//$section = $_POST['section'];
		if($name != ''){
			$is_avail_id = check_exist($conn,$table,$name); // check for new location is exist in table or not
			if($is_avail_id != false){
				echo "This Location already exist";
			}else{
				$inserted_id = insert_name($conn,$table,$name);  // insert new location in table
				if($comb != '' && $comb != null){
					$new_comb = $comb.','.$inserted_id;
					if($exist_id != ''){
					$status = update_into_comb($conn,$company,$section,$business_unit,$new_comb,'',$_POST['what'],$exist_id);
					}else{
					$status = insert_into_comb($conn,$company,$section,$business_unit,$new_comb,'',$_POST['what'],'');	
					}
					if($status){
						echo "Location successfully added";
					}
				}else{
					if($exist_id != ''){
					$status = update_into_comb($conn,$company,$section,$business_unit,$inserted_id,'',$_POST['what'],$exist_id);
					}else{
					$status = insert_into_comb($conn,$company,$section,$business_unit,$inserted_id,'',$_POST['what'],'');		
					}
					if($status){
						echo "Location successfully added";
					}
				}
			}
		}else{
			if($exist_id != ''){
			$status = update_into_comb($conn,$company,$section,$business_unit,$comb,'',$_POST['what'],$exist_id);
			}else{
			$status = insert_into_comb($conn,$company,$section,$business_unit,$comb,'',$_POST['what'],'');	
			}
			if($status){
				echo "Combination successfully done";
			}
		}
	}else if($_POST['action'] == 'edit'){
		$name = $_POST['exist_name'];
		$id = $_POST['exist_id'];
		update_devicedetails($conn,$table,$name,$id);
		$status = update_name($conn,$table,$name,$id);
		if($status)
		{
			echo "Location successfully updated";
		}
		
	}
}else if($_POST['for_what'] == 'wrkgrp'){  // for workgroup
	$table = 'tbl_workgroup';//print_r($_POST);
	if($_POST['action'] == 'add'){
		$name = $_POST['new_name'];
		$comb = $_POST['comb'];
		$company = $_POST['company'];
		$section = $_POST['section'];
		$business_unit = $_POST['business_unit'];
		$location = $_POST['location'];
		$exist_id = $_POST['row_id'];//print_r($_POST);
		//$section = $_POST['section'];
		if($name != ''){
			$is_avail_id = check_exist($conn,$table,$name); // check for new workgroup is exist in table or not
			if($is_avail_id != false){
				echo "This Workgroup already exist";
			}else{
				$inserted_id = insert_name($conn,$table,$name);  // insert new workgroup in table
				if($comb != '' && $comb != null){
					$new_comb = $comb.','.$inserted_id;
					if($exist_id != ''){
					$status = update_into_comb($conn,$company,$section,$business_unit,$location,$new_comb,$_POST['what'],$exist_id);
					}else{
					$status = insert_into_comb($conn,$company,$section,$business_unit,$location,$new_comb,$_POST['what'],'');	
					}
					if($status){
						echo "Workgroup successfully added";
					}
				}else{
					if($exist_id != ''){
					$status = update_into_comb($conn,$company,$section,$business_unit,$location,$inserted_id,$_POST['what'],$exist_id);
					}else{
					$status = insert_into_comb($conn,$company,$section,$business_unit,$location,$inserted_id,$_POST['what'],'');	
					}
					if($status){
						echo "Workgroup successfully added";
					}
				}
			}
		}else{ //echo $company."/".$section."/".$business_unit."/".$location."/".$comb."/".$exist_id;
			if($exist_id != ''){
			$status = update_into_comb($conn,$company,$section,$business_unit,$location,$comb,$_POST['what'],$exist_id);
			}else{
			$status = insert_into_comb($conn,$company,$section,$business_unit,$location,$comb,$_POST['what'],'');	
			}
			if($status){
				echo "Workgroup successfully done";
			}
		}
	}else if($_POST['action'] == 'edit'){
		$name = $_POST['exist_name'];
		$id = $_POST['exist_id'];
		update_devicedetails($conn,$table,$name,$id);
		$status = update_name($conn,$table,$name,$id);
		if($status)
		{
			echo "Workgroup successfully updated";
		}
		
	}
}


function check_exist($conn,$table,$name){ 
	$data = $conn->query("select * from ".$table." where name = '".$name."'"); //print_r($data->num_rows);
	$result = $data->fetch_object();
	if($data->num_rows > 0){
		return $result->id;
	}else{
		return false;
	}
}

function insert_name($conn,$table,$name){ 
	//echo "insert into ".$table." set name = '".$name."'";
	$data = $conn->query("insert into ".$table." set name = '".$name."'");
	if($data){
		return $conn->insert_id;
	}else{
		return false;
	}
}

function update_name($conn,$table,$name,$exist_id){
	$data = $conn->query("update ".$table." set name = '".$name."' where id='".$exist_id."'");
	if($data){
		return true;
	}else{
		return false;
	}
}

function update_devicedetails($conn,$table,$name,$exist_id){
	$result = $conn->query("select name from ".$table." where id='".$exist_id."'")->fetch_object(); 
	$old_name = $result->name;

	if($table == 'role_opco'){
		$column = "`opco`";
	}else if($table == 'role_primary'){
		$column = "`primary`";
	}else if($table == 'role_group'){
		$column = "`group`";
	}else if($table == 'role_dept'){
		$column = "`department`";
	}else{
		$column = "`Workgroup`";
	}

	$data = $conn->query("update devicedetails set ".$column." = '".$name."' where ".$column." = '".$old_name."'");
	if($data){
		return true;
	}else{
		return false;
	}
}

function insert_into_comb($conn,$comp,$sec,$bu,$loc,$wrkgrp,$what){
	
	$data = $conn->query("insert into tbl_combination set company='".$comp."', section='".$sec."', business_unit='".$bu."', location='".$loc."', workgroup='".$wrkgrp."', what='".$what."'");
	if($data){
		return true;
	}else{
		return false;
	}
}

function update_into_comb($conn,$comp,$sec,$bu,$loc,$wrkgrp,$what,$exist_id){ 

	$data = $conn->query("update tbl_combination set company='".$comp."', section='".$sec."', business_unit='".$bu."', location='".$loc."', workgroup='".$wrkgrp."', what='".$what."' where id='".$exist_id."'");
	if($data){
		return true;
	}else{
		return false;
	}
}

function check_exist_comb($conn,$comp,$sec,$bu,$loc,$wrkgrp,$what){
	// echo "select * from tbl_combination where company='".$comp."' and section='".$sec."' and business_unit='".$bu."' and location='".$loc."' and workgroup='".$wrkgrp."' and what='".$what."'";
	
	$data = $conn->query("select * from tbl_combination where company='".$comp."' and section='".$sec."' and business_unit='".$bu."' and location='".$loc."' and workgroup='".$wrkgrp."' and what='".$what."'");
	$result = $data->fetch_object();
	if($data->num_rows > 0){
		return $result->id;
	}else{
		return false;
	}
}
?> 