<?php                
require '../conn.php'; 


$display_query = "select ID,location,interview_date, interview_date_end from interview WHERE status='Temuduga'";             
$results = mysqli_query($conn,$display_query);   
if (!$results) {
    $data = array(
        'status' => false,
        'msg' => 'Error: ' . mysqli_error($conn)
    );
    echo json_encode($data);
    exit; // Stop further execution
}
$count = mysqli_num_rows($results);  
if($count>0) 
{
	$data_arr=array();
    $i=1;
	while ($data_row = mysqli_fetch_assoc($results)) {
	$data_arr[$i]['ID'] = $data_row['ID'];
	$data_arr[$i]['title'] = $data_row['location'];
	$data_arr[$i]['start'] = date("Y-m-d", strtotime($data_row['interview_date']));
	$data_arr[$i]['end'] = date("Y-m-d", strtotime($data_row['interview_date_end']));
	$data_arr[$i]['color'] = '#'.substr(uniqid(),-6); // 'green'; pass colour name
	$data_arr[$i]['url'] = '';
	$i++;
	}
	
	$data = array(
                'status' => true,
                'msg' => 'successfully!',
				'data' => $data_arr
            );
}
else
{
	$data = array(
                'status' => false,
                'msg' => 'Error!'				
            );
}
echo json_encode($data);
?>