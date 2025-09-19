const deleteAccountForm = document.getElementById('deleteAccountForm');
deleteAccountForm.addEventListener('submit', function(event) {
    event.preventDefault();
    if (confirm('Вы уверены, что хотите удалить аккаунт?')) {
        this.submit();
    }
});
