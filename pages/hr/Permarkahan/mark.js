$(document).ready(function () {
 

    // Show add data modal when clicking the button
    $('#addRecordButton').on('click', function () {
        var markCategoryId = "<?php echo $mark_category_id; ?>";
        $('#mark_category_id').val(markCategoryId);
        $('#addDataModal').modal('show');
    });

    
    // Submit new data form
    $('#addDataForm').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var markCategoryId = "<?php echo $mark_category_id; ?>";
        formData.append('mark_category_id', markCategoryId); // Ensure mark_category_id is appended

        $.ajax({
            type: 'POST',
            url: 'saveData.php',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $('#addDataModal').modal('hide');
                location.reload();
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });


    // Rest of your code including edit and save functionality...
    function goBack() {
        window.history.back();
    }

    // Edit and Save functionality for type and mark
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
            },
            error: function () {
                alert('Error occurred while updating data.');
            }
        });
    });
});
