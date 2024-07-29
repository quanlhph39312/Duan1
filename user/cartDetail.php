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
    $quantity = $item->quantityPro;
    $image = "../uploads/" . $product['image'];
    $totalAmount = $price * $quantity;
    echo "<tr id='item-" . ($key + 1) . "'>
          <td class='align-middle'>
            <div class='d-flex flex-column'>
              <div>
                <img src='$image' alt='' style='width: 50px' class='mr-2' />
                $namePro
              </div>
              <div>
                <small>Size : $nameSize - </small>
                <small>Color : $nameColor</small>
              </div>
            </div>
          </td>
          <td class='align-middle'>$$price</td>
          <td class='align-middle'>
            <div class='input-group quantity mx-auto' style='width: 100px'>
              <div class='input-group-btn'>
                <button class='btn btn-sm btn-primary btn-minus' onclick='minusQuantity(" . ($key + 1) . ",$price)'>
                  <i class='fa fa-minus'></i>
                </button>
              </div>
              <input type='text' class='form-control form-control-sm bg-secondary text-center' id='quantityPro-" . ($key + 1) . "' value='$quantity' disabled/>
              <div class='input-group-btn'>
                <button class='btn btn-sm btn-primary btn-plus' onclick='plusQuantity(" . ($key + 1) . ",$price)'>
                  <i class='fa fa-plus'></i>
                </button>
              </div>
            </div>
          </td>
          <td class='align-middle totalAmount' id='totalAmount-" . ($key + 1) . "'>$$totalAmount</td>
          <td class='align-middle'>
            <button class='btn btn-sm btn-primary' 
            onclick='removeItem(" . ($key + 1) . ")'>
              <i class='fa fa-times'></i>
            </button>
          </td>
          </tr>";
  }
} else {
  echo "<h3>Cart null</h3>";
}
