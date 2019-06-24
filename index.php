<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<?php
//load and initialize database class
require_once 'includes/DB.class.php';
require_once 'includes/html_table.class.php';
$db = new DB();
$tblName = 'master2';
//get users from database
$users = $db->getRows($tblName, array('order_by'=>'seq'));
// arguments: id, class
// can include associative array of optional additional attributes


//get status message from session
if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}

$tbl = new HTML_Table('', 'demoTbl');
			$tbl->addCaption('No3 Sample', 'table table-striped' );			
			$tbl->addTSection('thead');
				$tbl->addRow();
					// arguments: cell content, class, type (default is 'data' for td, pass 'header' for th)
					// can include associative array of optional additional attributes
					$tbl->addCell('seq', 'first', 'header');
					$tbl->addCell('Item Type', '', 'header');
					$tbl->addCell('Description', '', 'header');
					$tbl->addCell('Status', '', 'header');
					$tbl->addCell('Action', '', 'header');
			$tbl->addTSection('tbody', '', array ('id' => 'userData'));
			foreach($users as $user):
				$tbl->addRow('', array('id' => $user['seq']));
				$tbl->addCell('
					<span class="editSpan fname">'.$user['Item_type'].'</span>
					<input class="editInput fname form-control input-sm" type="text" name="Item_type" value="'.$user['Item_type'].'" style="display: none;">
					');
				$tbl->addCell('
					<span class="editSpan lname">'.$user['Description'].'</span>
					<input class="editInput lname form-control input-sm" type="text" name="Description" value="'.$user['Description'].'" style="display: none;">
					');
				$tbl->addCell('
					<span class="editSpan email">'.$user['Status'].'</span>
					<input class="editInput email form-control input-sm" type="text" name="Status" value="'.$user['Status'].'" style="display: none;">
					');
				$tbl->addCell('
					<div class="btn-group btn-group-sm">
						<button type="button" class="btn btn-sm btn-default editBtn" style="float: none;"><span class="glyphicon glyphicon-pencil"></span></button>
						<button type="button" class="btn btn-sm btn-default deleteBtn" style="float: none;"><span class="glyphicon glyphicon-trash"></span></button>
					</div>
					<button type="button" class="btn btn-sm btn-success saveBtn" style="float: none; display: none;">Save</button>
					<button type="button" class="btn btn-sm btn-danger confirmBtn" style="float: none; display: none;">Confirm</button>
					');
			endforeach;	
?>            
<div class="container">
    <div class="row">
        <div class="panel panel-default users-content">
            <?php echo $tbl->display(); ?>

        </div>
    </div>
</div>

 
<script>
$(document).ready(function(){
    $('.editBtn').on('click',function(){
        //hide edit span
        $(this).closest("tr").find(".editSpan").hide();
        
        //show edit input
        $(this).closest("tr").find(".editInput").show();
        
        //hide edit button
        $(this).closest("tr").find(".editBtn").hide();
        
        //show edit button
        $(this).closest("tr").find(".saveBtn").show();
        
    });
    
    $('.saveBtn').on('click',function(){
		var trObj = $(this).closest("tr");
        var ID = $(this).closest("tr").attr('id');
        var inputData = $(this).closest("tr").find(".editInput").serialize();
        console.debug('click!');

		
		$.ajax({
			type:'POST',
            url:'update.php',
            dataType: "json",
            data:'action=edit&id='+ID+'&'+inputData,
            success:function(response){
				alert ('Testing');
                if(response.status == 'ok'){
					console.debug(response.msg);
					alert(response.msg);
                    trObj.find(".editSpan.fname").text(response.data.first_name);
                    trObj.find(".editSpan.lname").text(response.data.last_name);
                    trObj.find(".editSpan.email").text(response.data.email);
                    
                    trObj.find(".editInput.fname").text(response.data.first_name);
                    trObj.find(".editInput.lname").text(response.data.last_name);
                    trObj.find(".editInput.email").text(response.data.email);
                    
                    trObj.find(".editInput").hide();
                    trObj.find(".saveBtn").hide();
                    trObj.find(".editSpan").show();
                    trObj.find(".editBtn").show();
                }else{
					console.debug(response.msg);
                    alert(response.msg);
                }
            },
			error: function(jqxhr, status, exception) {
				alert(response[0]);
				//alert('Exception:', response.msg);
			}
        });
    });
    
    $('.deleteBtn').on('click',function(){
        //hide delete button
        $(this).closest("tr").find(".deleteBtn").hide();
        
        //show confirm button
        $(this).closest("tr").find(".confirmBtn").show();
        
    });
    
    $('.confirmBtn').on('click',function(){
        var trObj = $(this).closest("tr");
        var ID = $(this).closest("tr").attr('id');
        $.ajax({
            type:'POST',
            url:'update.php',
            dataType: "json",
            data:'action=delete&id='+ID,
            success:function(response){
                if(response.status == 'ok'){
                    trObj.remove();
                }else{
                    trObj.find(".confirmBtn").hide();
                    trObj.find(".deleteBtn").show();
                    alert(response.msg);
                }
            }
        });
    });
});
</script>