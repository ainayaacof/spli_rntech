<link rel="stylesheet" href="../../../plugins/sweetalert2/sweetalert2.min.css">
<link rel="stylesheet" href="../../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<script src="../../../plugins/jquery/jquery.min.js"></script>
<script src="../../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../../dist/js/adminlte.min.js"></script>
<script type="text/javascript" src="../../../plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="../../../dist/js/demo.js"></script>

<?php
// Include database connection code
include "../../conn.php";


$interviewId = $_GET['id'];
// Initialize variables
$updateMessage = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the form when it is submitted

    // Validate and sanitize user input (You should perform proper validation)
    // $interviewId = $_POST['interview_id'];
    $updatedName = $_POST['updated_name']; // Assuming $updatedName is the new name
    $updatedDate = $_POST['updated_date'];
    $updatedTime = $_POST['updated_time'];
    $updatedLocation = $_POST['location'];
    $updatedlink = $_POST['interview_link'];

    // Update the record in the interview table
    $updateInterviewQuery = "UPDATE interview SET interview_date = '$updatedDate',interview_time = '$updatedTime',location = '$updatedLocation', interview_link = '$updatedlink'
    WHERE ID = ?";

     $stmt = $conn->prepare($updateInterviewQuery);
     $stmt->bind_param("i", $interviewId);

    if ($stmt->execute()) {
        //  Insertion successful
        echo '<center><script> 
        Swal.fire({
            title: "Berjaya",
            text: "Telah dikemaskini.",
            icon: "success"
        }).then(function() {
            window.location.replace("list_apply.php");
        }); </script></center>';
    }
}
    // Display the form with the current values

    // Get the interview ID from the URL parameter
    // $interviewId = $_GET['id'];

    // Retrieve the current values from the database
    $selectQuery = "SELECT interview.ID, student.name AS name, interview.interview_date, interview.interview_time, interview.location, interview.interview_link
                    FROM interview
                    JOIN student ON interview.student_id = student.id
                    WHERE interview.ID = '" . $interviewId . "'";
    $result = mysqli_query($conn, $selectQuery);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        // Display the form with the current values filled in
    } else {
        $updateMessage = "Error fetching record: " . mysqli_error($conn);
    }


// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Interview</title>
    <style>
        body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    margin: 20px;
}

h2 {
    text-align: center;
    color: #333;
}

form {
    max-width: 400px;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

label {
    display: block;
    margin-bottom: 8px;
    color: #333;
}

input,
select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
}

select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background: url('https://img.icons8.com/material-outlined/24/000000/down-arrow.png') no-repeat right #fff;
    background-position-x: 95%;
    background-position-y: center;
}

input[type="submit"] {
    background-color: #4caf50;
    color: #fff;
    cursor: pointer;
    border: none;
    border-radius: 4px;
    padding: 10px;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

    </style>
</head>
<body>
    <h2>Update Interview</h2>
    <?php if (!empty($updateMessage)) : ?>
        <script>
            // Display a pop-up with the update message
            alert("<?php echo $updateMessage; ?>");
            // Redirect to list_apply.php after the pop-up is closed
            window.location.href = 'list_apply.php';
        </script>
    <?php endif; ?>

    <form action="update_interview.php?id=<?php echo $interviewId; ?>" method="post">
        <!-- Display the current values in the form -->
        <label for="updated_name">Name:</label>
        <input type="text" name="updated_name" value="<?php echo $row['name']; ?>" readonly>

        <label for="updated_date">Date:</label>
        <input type="date" name="updated_date" value="<?php echo $row['interview_date']; ?>" required>

        <label for="updated_time">Time:</label>
        <input type="time" name="updated_time" value="<?php echo $row['interview_time']; ?>" required>


        <div class="col-sm-10">
            <select id="location" name="location" class="form-control" required>
                <option value="Online Meeting" <?php echo ($row['location'] == 'Online Meeting') ? 'selected' : ''; ?>>Online Meeting</option>
                <option value="RN Technologies Sdn Bhd" <?php echo ($row['location'] == 'RN Technologies Sdn Bhd') ? 'selected' : ''; ?>>RN Technologies Sdn Bhd</option>
                <!-- Add more options as needed -->
            </select>
        </div>
        <div class="form-group row" id="onlineMeetingLinkDiv" style="display: none;">
            <label for="onlineMeetingLink" class="col-sm-2 col-form-label">Link:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="onlineMeetingLink" name="interview_link" value="<?php echo $row['interview_link']; ?>" required>
            </div>
        </div>
        <input type="hidden" name="interview_id" value="<?php echo $interviewId; ?>">
        <input type="submit" value="Kemaskini">
    
        <a href="list_apply.php" class="btn btn-success" style="margin: 5px;"><i style="font-size: 15px;">Kembali</i></a>

    </form>
    <script>
        // jQuery script to show/hide the input field based on the selected option
        $(document).ready(function() {
            // Initial check on page load
            checkLocation();

            // Bind the change event of the dropdown
            $("#location").change(function() {
                // Check whenever the dropdown changes
                checkLocation();
            });

            function checkLocation() {
                // Get the selected value
                var selectedLocation = $("#location").val();

                // Check if the selected location is "Online Meeting"
                if (selectedLocation === "Online Meeting") {
                    // If "Online Meeting" is selected, show the input field
                    $("#onlineMeetingLinkDiv").show();
                } else {
                    // If any other option is selected, hide the input field
                    $("#onlineMeetingLinkDiv").hide();
                }
            }
        });
    </script>
</body>

</html>
