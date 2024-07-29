<?php
require_once '../dao/pdo.php';

function productInsert($name, $image, $description, $price, $category)
{
    $sql = "INSERT INTO product (name, image, description, price, id_cate) VALUES ('$name','$image','$description','$price','$category')";
    pdo_execute($sql);
}

function productSelectAll($itemPerPage, $offset)
{
    $sql = "SELECT * FROM product WHERE `status` = '0' ORDER BY id DESC LIMIT " . $itemPerPage . " OFFSET " . $offset . "";
    return pdo_query($sql);
}

function productSelectOne($id)
{
    $sql = "SELECT * FROM product WHERE id =" . $id;
    $pro = pdo_query_one($sql);
    return $pro;
}

function productSelectLast()
{
    $sql = "SELECT `id` FROM `product` ORDER BY id DESC LIMIT 1;";
    return pdo_query($sql);
}

function productUpdate($id, $name, $price, $image, $description, $category)
{
    $sql = "UPDATE product SET id_cate ='" . $category . "', name ='" . $name . "', price ='" . $price . "', image ='" . $image . "', description ='" . $description . "' WHERE id=" . $id;
    pdo_execute($sql);
}

function productDelete($id, $status)
{
    $sql = "UPDATE product SET status = '$status' where id=?";
    pdo_execute($sql, $id);
}



function proView($id)
{
    $sql = "UPDATE product SET view += 1 WHERE id=?";
    pdo_execute($sql, $id);
}


function productGetAll()
{
    $sql = "SELECT `product`.id AS `pro_id`, `product`.`name` AS `pro_name`, `product`.image, `product`.`description`, `product`.price, `category`.`name` AS `cate_name`, `product`.`view`, `product`.added_on ,`product`.`status`
    FROM `product`
    LEFT JOIN `category` on `category`.id = `product`.id_cate
    ORDER BY `product`.id DESC";
    return  pdo_query($sql);
}


function productCountByCategory($id)
{
    $sql = "SELECT COUNT(`id_cate`) FROM `product` WHERE `id_cate`=$id";
    return pdo_query_value($sql);
}


function productFilterByIdCate($id, $itemPerPage, $offset)
{
    $sql = "SELECT * FROM `product` WHERE `id_cate`=$id AND `status` = '0' ORDER BY id DESC LIMIT " . $itemPerPage . " OFFSET " . $offset . "";
    return pdo_query($sql);
}

function productSelectByIdCate($id_cate, $id_pro)
{
    $sql = "SELECT * FROM `product` WHERE `id_cate`=$id_cate AND `status` = '0' AND `id` <> $id_pro ORDER BY id DESC ";
    return pdo_query($sql);
}

function productSearchByName($name)
{
    $sql = "SELECT * FROM `product` WHERE `name` LIKE '%$name%'";
    return pdo_query($sql);
}

function productSortByPrice($status)
{
    $sql = "SELECT * FROM `product` ORDER BY `price` $status";
    return pdo_query($sql);
}

function productCheck($name)
{
    $sql = "SELECT `name`,`status`,`id`  FROM `product` WHERE `name`= '" . $name . "'";
    return pdo_query_one($sql);
}

function productCheckUpdate($newName, $name)
{
    $sql = "SELECT `name`  FROM `product` WHERE `name`= '" . $newName . "' AND `name` <> '" . $name . "' ";
    return pdo_query_one($sql);
}

function productReUpdate($category, $price, $image, $description, $id)
{
    $sql = "UPDATE `product` 
    SET id_cate ='" . $category . "', price ='" . $price . "', image ='" . $image . "', description ='" . $description . "',status='0' 
    WHERE id= $id";
    pdo_execute($sql);
}

function productRow($id)
{
    $sql = "SELECT * FROM `product` WHERE `id_cate`=$id AND `status` = '0' ";
    return pdo_query_row($sql);
}
function productRowAll()
{
    $sql = "SELECT * FROM `product` WHERE `status` = '0' ";
    return pdo_query_row($sql);
}

function productBestSeller()
{
    $sql = "SELECT 
    p.id,
    p.name, 
    p.image, 
    p.price,
    SUM(pa.sold) AS total_sold
FROM 
    product p
LEFT JOIN 
    product_attributes pa ON p.id = pa.id_pro
GROUP BY 
    p.id, p.name, p.image
ORDER BY 
    total_sold DESC
    LIMIT 4";
    return pdo_query($sql);
}
