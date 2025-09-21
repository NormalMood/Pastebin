const logoutLink = document.getElementById('logoutLink');
const logoutFormHidden = document.getElementById('logoutFormHidden');

if ((logoutLink !== null) && (logoutFormHidden !== null)) {
    logoutLink.addEventListener('click', function(event) {
        event.preventDefault();
        logoutFormHidden.submit(); 
    });
}