<?php
require_once '../dao/pdo.php';

function productAttGetAllColor()
{
  $sql = "SELECT `id`, `color`  FROM `product_color`";
  return pdo_query($sql);
}

function productAttGetAllColorByIdPro($id)
{
  $sql = "SELECT 
            id_pro,
            id_color,
            `product_color`.color AS `name_color`,
            MIN(product_attributes.id) AS id_attribute
          FROM
            product_attributes
                LEFT JOIN
            `product_color` ON product_attributes.id_color = `product_color`.id
          WHERE
            id_pro =$id
          GROUP BY id_color";
  return pdo_query($sql);
}


function productAttColorGetNameById($id)
{
  $sql = "SELECT `color` FROM `product_color` WHERE `id` = $id";
  return pdo_query_one($sql);
}
