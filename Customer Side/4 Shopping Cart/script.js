function delet(productName) {
    fetch('delete_product.php?name=' + productName)
    .then(response => {
        console.log("Got response", response);
        return response.json();
    })
    .then(data => {
        console.log("Parsed data", data);
        if(data.success) {
            console.log("Reloading...");
            location.reload();
        } else {
            console.error('Failed to delete the product.');
        }
    });
    
}

function payment() {
    const cust_id = getCookie("cust_id");
    const shop_id = getCookie("shop_id");

    fetch('make_payment.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            cust_id: cust_id,
            shop_id: shop_id
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Payment successful!');
            window.location.href = "../5 Transaction/index.php";
        } else {
            alert('Payment failed.');
        }
    });
}

function getCookie(name) {
    let value = "; " + document.cookie;
    let parts = value.split("; " + name + "=");
    if (parts.length == 2) return parts.pop().split(";").shift();
}
