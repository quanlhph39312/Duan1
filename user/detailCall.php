<?php
include_once("../dao/productAttribute/productAttributes.php");

$aResult = array();
if (!isset($_POST['functionname'])) {
  $aResult['error'] = 'No function name!';
}

if (!isset($_POST['arguments'])) {
  $aResult['error'] = 'No function arguments!';
}

if (!isset($aResult['error'])) {

  switch ($_POST['functionname']) {
    case 'getAllColorBySize':
      if (!is_array($_POST['arguments']) || (count($_POST['arguments']) < 2)) {
        $aResult['error'] = 'Error in arguments!';
      } else {
        $colors = productAttGetColorBySize(floatval($_POST['arguments'][0]), floatval($_POST['arguments'][1]));
        foreach ($colors as $color) {
          $aResult['result']['id'][] = $color['id_color'];
          $aResult['result']['color'][] = $color['color'];
        }
      }
      break;
    case 'getAllPriceAndImageByIdPro':
      if (!is_array($_POST['arguments']) || (count($_POST['arguments']) < 3)) {
        $aResult['error'] = 'Error in arguments!';
      } else {

        // Truyen tham so 
        // Float val lấy ra giá trị là float
        $proAtt = productAttGetPriceAndImage(floatval($_POST['arguments'][0]), floatval($_POST['arguments'][1]), floatval($_POST['arguments'][2]));
        $aResult['result']['price'] = $proAtt['price'];
        $aResult['result']['image'] = $proAtt['image'];
        $aResult['result']['quantity'] = $proAtt['quantity'];
        // echo $proAtt['price'];
      }
      break;
    default:
      $aResult['error'] = 'Not found function ' . $_POST['functionname'] . '!';
      break;
  }
}

echo json_encode($aResult);
