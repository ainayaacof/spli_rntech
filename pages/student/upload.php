<?php

extract($_POST);
extract($_GET);
include "../conn.php";
// Check if the form is submitted
if (isset($_POST['submit'])) {

    // Retrieve the form data
    $id = $_REQUEST['id'];
    $week = $_POST['week'];
    $task_description = $_POST['description'];
    $task_date = $_POST['date'];
    $total_time= $_POST['time'];
    $add_doc = $_POST['file'];

    // File upload handling
    $doc = ''; // Initialize $add_doc variable
    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];
        $uploadFolder = '../upload/';
        
        // Check if the file was uploaded successfully
        if ($file['error'] === UPLOAD_ERR_OK) {
            $doc = $file[$add_doc]; // Set $add_doc to the file name
            
            // Move the uploaded file to the desired folder
            $destination = $uploadFolder . $doc;
            move_uploaded_file($file[$add_doc], $destination);
        }
    }
    

    $query = "INSERT INTO task_activity (student_id, week, task_description, task_date, total_time, add_doc) VALUES (?,?,?,?,?,?)";

    $stmt = $conn->prepare($query);


//auto calculated if status == aduan (>3) hantar noti amaran pada pelajar 

// Bind parameters
$stmt->bind_param("ssssss", $id, $week, $task_description, $task_date, $total_time, $add_doc);
// Execute the statement
if ($stmt->execute()) {
    echo "<center><script> alert('Successfully Update!') </script></center>";
    echo "<meta http-equiv=\"refresh\" content=\"1;URL=maklumat_tugasan_pelajar.php\">";
} else {
    echo "<center><script> alert('Profile cannot be updated.'); </script></center>";
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=maklumat_tugasan_pelajar.php\">";
}

// Close the statement and connection
$stmt->close();
$conn->close();
}
?>
