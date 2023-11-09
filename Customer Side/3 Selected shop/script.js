document.addEventListener('DOMContentLoaded', function() {
    // Setting shop name
    document.getElementById("shopname").innerText = decodeURIComponent(getCookie("shop_name"));
});

function getCookie(name) {
    let value = "; " + document.cookie;
    let parts = value.split("; " + name + "=");
    if (parts.length == 2) return parts.pop().split(";").shift();
}

function addToCart(prodId, name, price, quan) {
    let quantity = document.querySelector(`#quantity-${prodId}`).value;

    if (Math.floor(quantity) !== Number(quantity)) {
        alert("Quantity cannot be in decimal!");
        return;
    }
    else if (quantity <= 0) {
        alert('Please enter a valid quantity.');
        return;
    }
    else if (quantity > quan) {
        alert(`Entered quantity (${quantity}) exceeds available quantity (${quan}). Please enter a new quantity.`);
        return;
    }
    else {
        // Send the data to the server to save in the "Cart" table
        fetch('addToCart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `name=${name}&price=${price}&quantity=${quantity}&prod_id=${prodId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Product added to cart successfully!');
            } else {
                alert('Error: ' + data.message);
            }
        });
    }
}

function logout() {
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


function viewcart() {
    window.location.href = "../4 Shopping Cart/index.php";
}

function search() {
    let input, filter, table, tr, td, i, j, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("tableid"); // Make sure to replace "yourTableId" with the actual ID of your table
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 1; i < tr.length; i++) {
        tr[i].style.display = "none";
        td = tr[i].getElementsByTagName("td");
        for (j = 0; j < td.length; j++) {
            if (td[j]) {
                txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                    break;
                }
            }
        }
    }
}

function selectcat() {
    let selectedCategory = document.querySelector('input[name="category"]:checked').value;
    let table, tr;
    table = document.getElementById("tableid");
    tr = table.getElementsByTagName("tr");

    for (let i = 1; i < tr.length; i++) {
        let row = tr[i];
        let category = row.getAttribute("data-category");

        if (category === selectedCategory || selectedCategory === "All") {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    }
}
