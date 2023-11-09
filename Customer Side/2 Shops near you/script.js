function next(shopId, shopName) {
    document.cookie = "shop_id=" + shopId + ";path=/";
    document.cookie = "shop_name=" + shopName + ";path=/";
    window.location.href = "../3 Selected shop/index.php";
}