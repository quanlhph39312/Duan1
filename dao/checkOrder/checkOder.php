<?php 

function checkOrderSelectAll($email){
    $sql = " 
    SELECT
    o.id AS order_id,
    o.fullname,
    o.phone,
    o.address,
    o.email,
    o.total_payment,
    p.method AS payment_method,
    o.added_on ,
    o.order_status
FROM
    `order` o
JOIN
    `user` u ON o.email = u.email
JOIN
    `payment` p ON o.payment_id = p.id
WHERE
    u.email = '".$email."';
";
        return pdo_query($sql);
}


