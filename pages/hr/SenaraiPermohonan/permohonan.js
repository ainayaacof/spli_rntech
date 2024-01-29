$(document).ready(function() {
  // Initialize DataTable for example1
  $("#example1").DataTable({
    "responsive": true,
    "lengthChange": false,
    "autoWidth": false,
    "buttons": ["excel"]
  }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

  // Initialize DataTable for example2
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
    "responsive": true
  });

  // View User details function
  $('.view-user').on('click', function() {
    var id = $(this).data('id');

    $.ajax({
      type: "POST",
      url: "getData.php",
      data: {
        id: id
      },
      dataType: "json",
      success: function(data) {
        // Populate modal fields with data
        $('#name').val(data.name);
        $('#phone_num').val(data.phone_num);
        $('#email').val(data.email);
        $('#address').val(data.address);
        $('#apply_date').val(data.apply_date);
        $('#apply_time').val(data.apply_time);
        $('#uni_name').val(data.uni_name);
        $('#uni_phone').val(data.uni_phone);
        $('#course').val(data.course);
        $('#mark').val(data.mark);

        // Show the modal
        $('#viewUserDataModal').modal('show');
      },
      error: function(xhr, status, error) {
        console.error(xhr.responseText);
      }
    });
  });

  // Interview button click handler
  $('.interview-button').click(function() {
    var interviewId = $(this).data('id');
    console.log("Interview ID:", interviewId);

    // Rest of your code
  });

  // View button click handler for modals
  $('.btn-primary').click(function() {
    var id = $(this).data('id');
    $('#viewUserDataModal_' + id).modal('show');
  });

  // Done choosing supervisor button click handler
  $('#doneChoosingSupervisorBtn').on('click', function() {
    var selectedSupervisorId = $('#supervisor').val();
    // var studentId = <?php echo $myrow['id']; ?>; // Assuming you have access to the student ID

    // AJAX request to update student's supervisor
    $.ajax({
      url: 'updateSupervisor.php', // Replace with the actual PHP file that updates the supervisor in the database
      type: 'POST',
      data: {
        studentId: studentId,
        supervisorId: selectedSupervisorId
      },
      success: function(response) {
        console.log('Supervisor updated successfully');
      },
      error: function(error) {
        console.error('Error updating supervisor:', error);
      }
    });
  });
});
