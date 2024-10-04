$('#editModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var id = button.data('id'); // Extract info from data-* attributes
    var title = button.data('title');
    var description = button.data('description');
    var image = button.data('image');

    // Update the modal's content
    var modal = $(this);
    modal.find('#editId').val(id);
    modal.find('#editTitle').val(title);
    modal.find('#editDescription').val(description);
    if (image) {
        modal.find('#editImagePreview').attr('src', image).show();
    } else {
        modal.find('#editImagePreview').hide();
    }
});
