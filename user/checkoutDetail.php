<?php
include_once("../dao/product/product.php");
include_once("../dao/productAttribute/productAttributeColor.php");
include_once("../dao/productAttribute/productAttributeSize.php");
include_once("../dao/productAttribute/productAttributes.php");
$items = json_decode($_POST['carts']);
if (sizeof($items) > 0) {
  foreach ($items as $key => $item) {
    $product = productSelectOne($item->idPro);
    $nameSize = productAttSizeGetNameById($item->idSize)['size'];
    $nameColor = productAttColorGetNameById($item->idColor)['color'];
    $namePro = $product['name'];
    $price = productAttGetPrice($item->idColor, $item->idSize, $item->idPro)['price'];
    $idProAtt =  productAttGetPrice($item->idColor, $item->idSize, $item->idPro)['id'];
    $quantity = $item->quantityPro;
    $image = "../uploads/" . $product['image'];
    $totalAmount = $price * $quantity;
    echo "<div class='d-flex justify-content-between mt-2 itemPro'>
            <div>
              <p class='mb-0'>" . $product['name'] . "</p>
              <small>Size : " . $nameSize . " - Color : " . $nameColor . " - Quantity : " . $quantity . "</small>
            </div>
            <p id='totalAmount-" . $key . "'>$" . $totalAmount . "</p>
          </div>
          <div>
            <input type='hidden' value='" . $item->idPro . "' name='idPro'>
            <input type='hidden' value='" . $item->idSize . "' name='idSize'>
            <input type='hidden' value='" . $item->idColor . "' name='idColor'>
            <input type='hidden' value='" . $item->quantityPro . "' name='quantityPro[]'>   
            <input type='hidden' value='" . $idProAtt . "' name='idProAtt[]'>
          </div>
          ";
  }
}
