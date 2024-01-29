<?php                
require '../conn.php'; 
$location = $_POST['location'];
$interview_date = date("y-m-d", strtotime($_POST['interview_date'])); 
$event_date_end = date("y-m-d", strtotime($_POST['event_date_end'])); 

$insert_query = "INSERT INTO `interview`(`location`, `interview_date`, `event_date_end`) VALUES ('".$location."','".$interview_date."','".$event_date_end."')"; 		

if(mysqli_query($conn, $insert_query))
{
	$data = array(
                'status' => true,
                'msg' => 'Event added successfully!'
            );
}
else
{
	$data = array(
                'status' => false,
                'msg' => 'Sorry, Event not added.'				
            );
}
echo json_encode($data);	
?>
