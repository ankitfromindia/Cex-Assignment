$(document).ready(function() {

    /**
     * Delete a category
     */
    $('.btn-delete-item').click(function() {
        window.location.href = "/admin/categories/delete/" + $(this).attr('data-id');
    });

});
