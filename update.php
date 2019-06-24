<?php
//load and initialize database class
require_once 'includes/DB.class.php';


$returnData = array(
            'status' => 'ok',
            'msg' => 'Some problem occurred',
            'data' => 'XXXXX'
        );
		
header("Content-Type: application/json; charset=utf-8", true);
echo json_encode($returnData);

die();
$db = new DB();		
$tblName = 'master2';
echo $_POST['action'] ;
if(($_POST['action'] == 'edit') && !empty($_POST['seq'])){
	
    //update data
    $userData = array(
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'email' => $_POST['email']
    );
    $condition = array('id' => $_POST['id']);
    $update = $db->update($tblName, $userData, $condition);
    if($update){
        $returnData = array(
            'status' => 'ok',
            'msg' => 'User data has been updated successfully.',
            'data' => $userData
        );
    }else{
        $returnData = array(
            'status' => 'error',
            'msg' => 'Some problem occurred, please try again.',
            'data' => ''
        );
    }
    echo json_encode($returnData);
}elseif(($_POST['action'] == 'delete') && !empty($_POST['id'])){
    //delete data
    $condition = array('id' => $_POST['id']);
    $delete = $db->delete($tblName, $condition);
    if($delete){
        $returnData = array(
            'status' => 'ok',
            'msg' => 'User data has been deleted successfully.'
        );
    }else{
        $returnData = array(
            'status' => 'error',
            'msg' => 'Some problem occurred, please try again.'
        );
    }
    
    echo json_encode($returnData);
}
die();
?>
