<?php
include "../../conn.php";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT interview.*, student.name AS student_name 
        FROM interview
        INNER JOIN student ON interview.student_id = student.student_id";
$result = $conn->query($sql);

$events = array();
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $status = $row['status'];
    $events[] = array(
      'title' => 'Temuduga', 
      'start' => $row['interview_date'] . 'T' . $row['interview_time'], 
      'student_id' => $row['student_id'], 
      'student_name' => $row['student_name'], 
      'location' => $row['location'],
      'time' => $row['interview_time'],
      'link' => $row['interview_link'],
      'status' => $status
    );
  }
}

echo json_encode($events);

$conn->close();
?>
