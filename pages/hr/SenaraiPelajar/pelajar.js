$(function () {
  $("#example1").DataTable({
    "responsive": true, "lengthChange": false, "autoWidth": false,
    "buttons": ["excel"]
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

		// Function to handle deletion
		$('#btnnonactive').click(function(e) {
			e.preventDefault();
			var deleteURL = $(this).attr('href');

			Swal.fire({
				title: 'Adakah anda pasti?',
				text: 'Data akan dinyahaktifkan!',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya, Padam!',
				cancelButtonText: 'Batal'
			}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						type: 'GET',
						url: deleteURL, // Replace this URL with your delete endpoint
						success: function(response) {
							Swal.fire({
								title: 'Dinyahaktif!',
								text: 'Maklumat telah berjaya dinyahaktif.',
								icon: 'success'
							}).then(() => {
								location.reload(); // Refresh the page after successful deletion
							});
						},
						error: function() {
							Swal.fire({
								title: 'Ralat!',
								text: 'Gagal dinyahaktifkan maklumat.',
								icon: 'error'
							});
						}
					});
				}
			});
		});
