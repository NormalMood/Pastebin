const deletePostForm = document.getElementById('deletePostForm');
deletePostForm.addEventListener('submit', function(event) {
    event.preventDefault();
    if (confirm('Вы уверены, что хотите удалить пост?')) {
        this.submit();
    }
});