const deleteAccountForm = document.getElementById('deleteAccountForm');
if (deleteAccountForm !== null) {
    deleteAccountForm.addEventListener('submit', function(event) {
        event.preventDefault();
        if (confirm('Вы уверены, что хотите удалить аккаунт?')) {
            this.submit();
        }
    });
}