<?php
defined('BASEPATH') or exit('No direct script access allowed');

function getLoginUser($value='')
{
	$CI = &get_instance();
	if (!empty($value)) {
		return $CI->db->where('id',$value)->get('users')->row();
	}else{
		return $CI->db->where('id',$CI->session->userdata('user_id'))->get('users')->row();
	}
}
function getPackageDetails(array $where)
{
	$CI = &get_instance();
	if (!empty($where)) {
		return $CI->db->where($where)->get('tbl_packages')->row();
	}else{
		return $CI->db->where('id',1)->get('tbl_packages')->row();
	}
}
function admin_url($value='')
{
	return base_url('admin/'.$value);
}

function changeDateFormat($format='',$date='')
{
	return date($format, strtotime($date));
}

function check_row($table='',array $where){ 
	$CI = &get_instance();
    $result = $CI->db->select('*')->from($table)->where($where)->get(); 
    if($result->num_rows() > 0) {
      return $result->row();
    }else{
      return false;
    }
}

function createUserDb($userSubdomain='',array $userRecord) {
	$CI = &get_instance();
	$dbname='smartsone_'.$userSubdomain;
	//$dbname='proximitycrm_anshul';
    $old_db="schoolmaster";//"u359908761_mws";
    $CI->db->query('CREATE DATABASE '.$dbname);
     //lets us check if database created
    $databaseExist= "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME ='$dbname'";
    $queryDB = $CI->db->query($databaseExist);
    if($queryDB->num_rows()>0){
        $servername = "localhost";
       $db_user=MAIN_DATABASE_USER;
       $db_pass=MAIN_DATABASE_PASSWORD; 
        // $new_db="1_masterdb";
      //  echo $dbname;
        
      // echo "<br/>"; 
        
     importdatabase($servername,$db_user,$db_pass,$dbname);
     
  //  exit;
     // exec("mysqldump -u $db_user --password=$db_pass $old_db | mysql -u $db_user -p$db_pass $dbname"." 2>&1",$output);
      

      
   // exit;   
    }  
    if (!empty($userRecord)) {
        $servername = "localhost";
        $username = MAIN_DATABASE_USER;
        $password = MAIN_DATABASE_PASSWORD; 
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }
    
    $newpass = $userRecord['password_original'];
    $new_password = password_hash($newpass, PASSWORD_DEFAULT);
    $join_date = date('Y-m-d');
    $suburl = 'http://'.$userSubdomain.'smartschool.one';
    $name = $userRecord['first_name'].' '.$userRecord['last_name'];
    $sql = "INSERT INTO staff (employee_id,name, email, password, is_active, dob, unique_id) VALUES ('90000','".$name."','".$userRecord['email']."','".$new_password."','1','".$join_date."','".$userRecord['unique_id']."')";

    $sql2 = "UPDATE sch_settings SET name='".$userRecord['school_name']."',email='".$userRecord['email']."', phone='".$userRecord['phone']."', dise_code='".$userRecord['unique_id']."', mobile_api_url='".$suburl."' WHERE id='1'";




        if ($conn->query($sql) === TRUE) {
          // echo "New record created successfully";
            $conn->query($sql2);
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    } 
}
function updateCrmUser(string $userSubdomain,array $userRecord) {
    $CI = &get_instance();
    $dbname='smartsone_'.$userSubdomain;
     
    if (!empty($userRecord)) {
        $servername = "localhost";
        $username = MAIN_DATABASE_USER;
        $password = MAIN_DATABASE_PASSWORD; 
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

$name = $userRecord['first_name'].' '.$userRecord['last_name'];
$new_password = md5($userRecord['password_original']);
        $sql = "UPDATE staff SET employee_id='90000',name='".$name."', password='".$new_password."', is_active='1' WHERE unique_id='".$userRecord['unique_id']."'";




        if ($conn->query($sql) === TRUE) {
          // echo "New record created successfully";
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    } 
} 

function subdomain_url($value='',$param='')
{ 
    redirect('http://'.$value.'.smartschool.one/'.$param);
}


function checkSubdomain($table='',$where=array())
{
    $addCount ='';
    $CI = &get_instance();
    $result = $CI->db->select('id')->from($table)->where($where)->get(); 
    if($result->num_rows() > 0) {
       return $result->num_rows();
       // return $addCount;
    }else{
      return $addCount;
    }
}



function importdatabase($servername,$username,$password,$dbname){
    
    $filename = '/home/zobofy/public_html/smartschoolone/application/helpers/schooldb.sql';
    
// MySQL host
$mysqlHost = $servername;
// MySQL username
$mysqlUser = $username;
// MySQL password
$mysqlPassword = $password;
// Database name
$mysqlDatabase = $dbname;

// Connect to MySQL server
$link = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword, $mysqlDatabase) or die('Error connecting to MySQL Database: ' . mysqli_error());


$tempLine = '';
// Read in the full file
$lines = file($filename);




// Loop through each line
foreach ($lines as $line) {

    // Skip it if it's a comment
    if (substr($line, 0, 2) == '--' || $line == '')
        continue;

    // Add this line to the current segment
    $tempLine .= $line;
    // If its semicolon at the end, so that is the end of one query
    if (substr(trim($line), -1, 1) == ';')  {
        // Perform the query
        mysqli_query($link, $tempLine) or print("Error in " . $tempLine .":". mysqli_error());
        // Reset temp variable to empty
        $tempLine = '';
    }
}
    
   return $data ="Successfully create"; 
    
}





