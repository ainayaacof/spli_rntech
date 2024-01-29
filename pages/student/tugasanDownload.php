<?php

    include "../conn.php";
    // Start or resume the session
    session_start();

    $id = $_SESSION['id'];
    $week = $_GET['unique_week'];

    $uploadPath = '../upload/' . $pdfFileName; // Replace this with the path to your actual file
    $pdfFileName = $_FILES['pdfFile']['name'];   // Replace this with the desired name for the downloaded file

    // Check if the file exists
    if (file_exists($uploadPath)) {
        
        // Set headers for force download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $pdfFileName . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($uploadPath));

        // Read the file and output its content
        readfile($uploadPath);

        exit;
    } else {
        // File not found
        echo 'File not found.';
    }
?>
