$(function () {
    $('#kategori').change(function () {
        var selectedValue = $(this).val();

        // Hide all additional fields initially
        $('#alamatField, #noPekerjaField, #positionField').hide();

        // Check the selected value and display additional fields accordingly
        if (selectedValue === 'pelajar') {
            $('#alamatField').show();
        } else if (selectedValue === 'penyelia') {
            $('#noPekerjaField, #positionField').show();
        }
    });
    
    // DataTable initialization
    $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["excel", "pdf",]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });

    // Handling password change modal for buttons with class '.btn-success'
    $('.btn-success').click(function (e) {
        e.preventDefault();
        var userId = $(this).closest('tr').find('td:first').text(); // Assuming ID is in the first column
        $('#userId').val(userId);
        $('#changePasswordModal').modal('show');
    });

    // Handling change password functionality for elements with class '.change-password'
    $('.change-password').on('click', function () {
        var userId = $(this).data('user-id');
        var userType = $(this).data('user-type');
        $('#userId').val(userId);
        $('#userType').val(userType);
    });

    // Handling viewing user data for elements with class '.view-user'
    $('.view-user').on('click', function () {
        var name = $(this).data('name');
        var email = $(this).data('email');
        var phone = $(this).data('phone_num');
        var address = $(this).data('address');
        var position = $(this).data('position');
        var userType = '';

        // Determine userType based on the user type (student or supervisor)
        if ($(this).closest('td').prev().text() === 'Pelajar') {
            userType = 'student';
        } else if ($(this).closest('td').prev().text() === 'Penyelia') {
            userType = 'supervisor';
        }

        $('#viewName').val(name);
        $('#viewEmail').val(email);
        $('#viewPhone').val(phone);

        if (address !== undefined && address !== '') {
            $('#viewAddress').val(address);
            $('#addressField').show();
        } else {
            $('#addressField').hide();
        }

        if (position !== undefined && position !== '') {
            $('#viewPosition').val(position);
            $('#positionField').show();
        } else {
            $('#positionField').hide();
        }

        // Additional code related to form submission (if required)
        $('#userId').val($(this).data('id')); // Assuming 'id' is the user ID
        $('#userType').val(userType); // Setting userType in the form

        $('#changePasswordForm').attr('action', 'changePassword.php'); // Setting form action
        $('#changePasswordForm').submit(); // Submitting the form
    });

    // Function to enable editing
    function enableEdit() {
        var inputs = document.getElementsByTagName("input");
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].removeAttribute("disabled");
        }
        document.getElementById("editButton").style.display = "none";
        document.getElementById("saveButton").style.display = "inline-block";

        // Set the id_edit value in the form
        var idEditField = document.getElementById("id_edit");
        var idEditValue = "";
        idEditField.value = idEditValue;
    }
});

document.addEventListener('DOMContentLoaded', function () {
    // Add event listener to the submit button
    document.getElementById('submitEditButton').addEventListener('click', function () {
        Swal.fire({
            title: 'Anda pasti mahu simpan?',
            text: 'Perubahan akan disimpan!',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, simpan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Trigger form submission if confirmed
                document.getElementById('form-edit').submit();
            }
        });
    });
});
