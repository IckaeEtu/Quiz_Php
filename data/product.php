<?php
function getProduct() {
    return json_decode(file_get_contents("_inc/data/product.json"), true);
}
?>