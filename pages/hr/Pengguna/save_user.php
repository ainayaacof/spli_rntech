<?php
session_start();
include "../../conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_num = $_POST['phone_num'];
    $password = $_POST['password'];
    $category = $_POST['category'];

    $status = "Aktif";

    $latestIdQuery = "SELECT MAX(student_Id) AS maxId FROM student";
    $result = $conn->query($latestIdQuery);
    $row = $result->fetch_assoc();
    $latestId = $row['maxId'];

    $numericPart = intval(substr($latestId, 2)); 
    $numericPart++; 

    $newStudentId = 'IS' . sprintf('%03d', $numericPart); 

    if ($category === "Pelajar") {
        $address = $_POST['address'];
        $sv_id = $_POST['sv_id'];

        $stmt = $conn->prepare("INSERT INTO student (student_id, name, email, phone_num, password, address, sv_id, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("ssssssss", $newStudentId, $name, $email, $phone_num, $password, $address, $sv_id, $status);

        $stmt->execute();
        if ($stmt->errno) {
            die("Execute failed: " . $stmt->error);
        }

        $stmt->close();
        $conn->close();

        // Alert message when successful insertion
        echo "<script>alert('Data inserted successfully');</script>";
    } elseif ($category === "Penyelia") {
        $latestSupervisorIdQuery = "SELECT MAX(sv_id) AS maxId FROM supervisor";
        $result = $conn->query($latestSupervisorIdQuery);
        $row = $result->fetch_assoc();
        $latestSupervisorId = $row['maxId'];

        $numericPart = intval(substr($latestSupervisorId, 2)); 
        $numericPart++; 

        $newSupervisorId = 'SV' . sprintf('%03d', $numericPart); 

        $position = $_POST['position'];

        $stmt = $conn->prepare("INSERT INTO supervisor (sv_id, name, email, phone_num, password, position, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("sssssss", $newSupervisorId, $name, $email, $phone_num, $password, $position, $status);

        $stmt->execute();
        if ($stmt->errno) {
            die("Execute failed: " . $stmt->error);
        }

        $stmt->close();
        $conn->close();

        // Alert message when successful insertion
        echo "<script>alert('Data inserted successfully');</script>";

        // Redirect after successful insertion
        header("Location: list_user.php");
        exit();
    }
}
?>
