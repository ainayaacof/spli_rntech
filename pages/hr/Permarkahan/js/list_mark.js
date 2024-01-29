  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["", "", ""]
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
  });

$(document).ready(function () {
    $('.edit-btn').click(function () {
        const $row = $(this).closest('tr');
        const $category = $row.find('.category');
        const $date = $row.find('.date');

        const categoryValue = $category.text().trim();
        const dateValue = $date.text().trim();

        const formattedDate = convertDateFormatBack(dateValue);

        $category.html(`<input type="text" class="form-control category-input" value="${categoryValue}">`);
        $date.html(`<input type="date" class="form-control date-input" value="${formattedDate}">`);

        $(this).hide();
        $row.find('.save-btn').show();
    });

    $(document).on('click', '.save-btn', function () {
        const $row = $(this).closest('tr');
        const $categoryInput = $row.find('.category-input');
        const $dateInput = $row.find('.date-input');
        const categoryId = $row.find('a.btn-warning').attr('href').split('=')[1]; 

        const formData = new FormData();
        formData.append('id', categoryId);
        formData.append('category', $categoryInput.val().trim());
        formData.append('date', $dateInput.val().trim());

        Swal.fire({
            title: 'Anda Pasti?',
            text: 'Untuk mengubah data ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: 'POST',
                    url: 'updateCategory.php',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $row.find('.category').html(formData.get('category'));
                        $row.find('.date').html(convertDateFormat(formData.get('date')));
                        $row.find('.edit-btn').show();
                        $row.find('.save-btn').hide();
                    },
                    error: function () {
                        Swal.fire({
                            title: 'Error',
                            text: 'Failed to update data.',
                            icon: 'error',
                        });
                    }
                });
            }
        });
    });
});

$(document).ready(function () {
    $('.delete-btn').click(function (e) {
        e.preventDefault();
        var categoryId = $(this).data('id');

        Swal.fire({
            title: 'Anda Pasti?',
            text: 'Data akan di padam daripada rekod sistem!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // If user confirms deletion, execute AJAX request
                $.ajax({
                    type: 'GET',
                    url: 'deleteCategoryMark.php?id=' + categoryId,
                    success: function (response) {
                        // Handle success response from server
                        Swal.fire({
                            title: 'Padam!',
                            text: 'Data berjaya di padam.',
                            icon: 'success'
                        }).then(() => {
                            window.location.reload();
                        });
                    },
                    error: function () {
                        // Handle error response from server
                        Swal.fire({
                            title: 'Ralat!',
                            text: 'Data tidak berjaya di padam.',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });
});



function convertDateFormat(date) {
    const parts = date.split('-');
    return `${parts[2]}/${parts[1]}/${parts[0]}`;
}

function convertDateFormatBack(date) {
    const parts = date.split('/');
    return `${parts[2]}-${parts[1]}-${parts[0]}`;
}
