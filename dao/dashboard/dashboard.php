<?php
require_once '../dao/pdo.php';

function dashboardGetByCate()
{
  $sql = "SELECT 
            c.id AS category_id,
            c.name AS category_name,
            SUM(pa.sold) AS sold_count
          FROM
            category c
                LEFT JOIN
            product p ON c.id = p.id_cate
                LEFT JOIN
            product_attributes pa ON p.id = pa.id_pro
          GROUP BY c.id , c.name
          ORDER BY sold_count DESC";

  return pdo_query($sql);
}


function dashboardGetTotalSales()
{
  $sql = "SELECT 
            SUM(sold)
          FROM
            `product_attributes`;";
  return pdo_query_value($sql);
}

function dashboardGetTotalProduct()
{
  $sql = "SELECT 
            SUM(quantity)
          FROM
            `product_attributes`;";
  return pdo_query_value($sql);
}


function dashboardGetTotalEarning()
{
  $sql = "SELECT 
          SUM(total_payment)
        FROM
          `order`
        WHERE
          `order_status` = '1'";
  return pdo_query_value($sql);
}


function dashboardGetTotalPendingOrder()
{
  $sql = "SELECT 
          COUNT(`id`)
        FROM
          `order`
        WHERE
          `order_status` = '0'";
  return pdo_query_value($sql);
}


function dashboardGetTotalOrder()
{
  $sql = "SELECT 
          COUNT(`id`)
        FROM
          `order`";
  return pdo_query_value($sql);
}


function dashboardGetSoldAndRevenue($month, $year)
{
  $sql = "SELECT 
            SUM(quantity) AS quantity,
            SUM(total_payment) AS revenue
          FROM
            order_detail
                JOIN
            `order` ON order_detail.id_order = `order`.id
          WHERE
            `order`.order_status = '1'
                AND MONTH(added_on) = $month
                AND YEAR(added_on) = $year
          GROUP BY  YEAR(added_on) , MONTH(added_on)";
  return pdo_query($sql);
}
