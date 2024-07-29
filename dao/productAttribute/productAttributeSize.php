<?php
require_once '../dao/pdo.php';

function productAttGetAllSize()
{
  $sql = "SELECT `id`, `size` FROM `product_size`";
  return pdo_query($sql);
}

function productAttGetAllSizeByIdPro($id)
{
  $sql = "SELECT 
            id_pro,
            id_size,
            `product_size`.size AS `name_size`,
            MIN(product_attributes.id) AS id_attribute
          FROM
            product_attributes
                LEFT JOIN
            `product_size` ON `product_attributes`.id_size = `product_size`.id
          WHERE
            id_pro = $id
          GROUP BY id_size";
  return pdo_query($sql);
}

function productAttSizeGetNameById($id)
{
  $sql = "SELECT `size` FROM `product_size` WHERE `id` = $id";
  return pdo_query_one($sql);
}
