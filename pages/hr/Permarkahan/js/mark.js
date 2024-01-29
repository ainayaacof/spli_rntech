
function goBack() {
    window.history.back();
}

$(document).ready(function () {
    $('.edit-btn').click(function () {
        const $row = $(this).closest('tr');
        const $type = $row.find('td:nth-child(2)');
        const $mark = $row.find('td:nth-child(3)');

        const typeValue = $type.text().trim();
        const markValue = $mark.text().trim();

        $type.html(`<input type="text" class="form-control type-input" value="${typeValue}">`);
        $mark.html(`<input type="text" class="form-control mark-input" value="${markValue}">`);

        $(this).hide();
        $row.find('.save-btn').show();
    });

    $(document).on('click', '.save-btn', function () {
        const $row = $(this).closest('tr');
        const typeId = $row.find('a.btn-danger').attr('href').split('=')[1]; // Extract type ID

        const $typeInput = $row.find('.type-input');
        const $markInput = $row.find('.mark-input');

        const formData = new FormData();
        formData.append('id', typeId);
        formData.append('type', $typeInput.val().trim());
        formData.append('mark', $markInput.val().trim());

        $.ajax({
            method: 'POST',
            url: 'updateMarkApply.php',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $row.find('td:nth-child(2)').html(formData.get('type'));
                $row.find('td:nth-child(3)').html(formData.get('mark'));
                $row.find('.edit-btn').show();
                $row.find('.save-btn').hide();

                Swal.fire({
                    title: 'Kemaskini!',
                    text: 'Data berjaya di kemaskini.',
                    icon: 'success'
                });
            },
            error: function () {
                Swal.fire({
                    title: 'Ralat!',
                    text: 'Data gagal di kemaskini.',
                    icon: 'error'
                });
            }
        });
    });
});

$(document).ready(function () {
    $('.delete-btn').click(function (e) {
        e.preventDefault();
        var markApplyId = $(this).data('id');

        Swal.fire({
            title: 'Anda Pasti?',
            text: 'Data akan dipadam dari rekod sistem!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, pasti!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Proceed with the deletion
                window.location.href = 'deleteMarkApply.php?id=' + markApplyId;
            }
        });
    });
});
