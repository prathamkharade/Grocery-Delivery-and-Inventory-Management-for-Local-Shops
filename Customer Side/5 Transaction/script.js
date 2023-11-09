function logout() {
    // Clear all cookies
    var cookies = document.cookie.split("; ");
    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];
        var eqPos = cookie.indexOf("=");
        var name = eqPos > -1 ? cookie.substring(0, eqPos) : cookie;
        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/";
    }
    
    // Make an AJAX request to truncate the table
    fetch('truncate_cart.php')
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            window.location.href = "../../Opening Page/index.html";
        } else {
            console.error('Failed to truncate the cart.');
            // Handle error or notify user here
        }
    });
}