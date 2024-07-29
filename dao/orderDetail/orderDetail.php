<?php
require_once '../dao/pdo.php';


function orderDetailGetAllById($id)
{
  $sql = "SELECT 
            `order_detail`.id,
            `order_detail`.id_order,
            `order_detail`.quantity,
            `product`.`name`,
            `product_size`.`size`,
            `product_color`.color,
            `product_attributes`.price,
            `order`.order_status
          FROM
            `order_detail`
                LEFT JOIN `product_attributes` 
                ON `product_attributes`.id = `order_detail`.id_pro_att
                LEFT JOIN `product` 
                ON `product_attributes`.id_pro = `product`.id
                LEFT JOIN `product_size` 
                ON `product_attributes`.id_size = `product_size`.id
                LEFT JOIN `product_color` 
                ON `product_attributes`.id_color = `product_color`.id
                LEFT JOIN `order` 
                ON `order`.id = `order_detail`.id_order
          WHERE
            `order_detail`.`id_order` = $id
          ORDER BY `order_detail`.id DESC";
  return pdo_query($sql);
}
function orderDetailInsert($id_order, $idProAtt, $quantity)
{
  $sql = " INSERT INTO `order_detail`(id_order,id_pro_att,quantity) VALUES ('$id_order','$idProAtt','$quantity') ";
  pdo_execute($sql);
}

function orderDetailGetAllId($id)
{
  $sql = "SELECT 
            `order_detail`.id,
            `order_detail`.id_order,
            `product`.`name`,
            `order`.fullname,
            `order`.email,
            `order`.total_payment
          FROM
            `order_detail`
                LEFT JOIN `product_attributes` 
                ON `product_attributes`.id = `order_detail`.id_pro_att
                LEFT JOIN `product` 
                ON `product_attributes`.id_pro = `product`.id
                LEFT JOIN `order` 
                ON `order`.id = `order_detail`.id_order
          WHERE
            `order_detail`.`id_order` = $id
          ORDER BY `order_detail`.id DESC";
  return pdo_query($sql);
}

function orderDetailSelectAll($id)
{
  $sql = "SELECT 
            `order_detail`.id_order,
            `order_detail`.quantity,
            `product`.`name`,
            `product_attributes`.price,
            `product_color`.color,
            `product_size`.size
          FROM
            `order_detail`
                LEFT JOIN
            `product_attributes` ON `product_attributes`.id = `order_detail`.id_pro_att
                LEFT JOIN
            `product` ON `product_attributes`.id_pro = `product`.id
                LEFT JOIN
            `product_size` ON `product_attributes`.id_size = `product_size`.id
                LEFT JOIN
            `product_color` ON `product_attributes`.id_color = `product_color`.id
          WHERE
            `order_detail`.`id_order` = $id
          ORDER BY `order_detail`.id DESC";
  return pdo_query($sql);
}
