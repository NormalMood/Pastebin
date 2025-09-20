const deletePostForms = document.querySelectorAll('.deletePostForm');
if (deletePostForms !== null) {
    deletePostForms.forEach(deletePostForm => {
        deletePostForm.addEventListener('submit', function(event) {
            event.preventDefault();
            if (confirm('Вы уверены, что хотите удалить пост?')) {
                this.submit();
            }
        });
    });
}