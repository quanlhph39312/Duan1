<?php
require_once '../dao/pdo.php';

function orderGetAll()
{
  $sql = "SELECT 
            `order`.id,
            `order`.fullname,
            `order`.phone,
            `order`.`address`,
            `order`.email,
            `order`.total_payment,
            `order`.added_on,
            `order`.order_status,
            `payment`.method
          FROM
            `order`
                LEFT JOIN
            `payment` ON `payment`.id = `order`.payment_id
          ORDER BY `order`.id DESC";
  return pdo_query($sql);
}

function orderSetStatusOrder($status, $id)
{
  $sql = "UPDATE `order` SET `order_status`= '$status' WHERE `id`=$id";
  pdo_execute($sql);
}
function orderDetailSetStatusOrder($status, $id)
{
  $sql = "UPDATE `order_detail` SET `status`= '$status' WHERE `id`=$id";
  pdo_execute($sql);
}
function orderInsert($fullname, $phone, $address, $email, $total, $payment)
{
  $sql = "INSERT INTO `order` (fullname,phone,address,email,total_payment,payment_id) VALUES ('$fullname','$phone','$address','$email','$total','$payment')";
  pdo_execute($sql);
}

function orderSelectLastId()
{
  $sql = "SELECT `id` FROM `order` ORDER BY id DESC LIMIT 1";
  return pdo_query($sql);
}


function orderGetOne($id)
{
  $sql = "SELECT * FROM `order` WHERE `id`=$id";
  return pdo_query_one($sql);
}

function orderSendEmailConfirm($email,$id,$name,$added_on,$total)
{
  require "../PHPMailer-master/src/PHPMailer.php"; 
  require "../PHPMailer-master/src/SMTP.php"; 
  require '../PHPMailer-master/src/Exception.php'; 
  $mail = new PHPMailer\PHPMailer\PHPMailer(true);//true:enables exceptions
  try {
      $mail->SMTPDebug = 0; //0,1,2: chế độ debug
      $mail->isSMTP();  
      $mail->CharSet  = "utf-8";
      $mail->Host = 'smtp.gmail.com';  //SMTP servers
      $mail->SMTPAuth = true; // Enable authentication
      $mail->Username = 'hongquan262001@gmail.com'; // SMTP username
      $mail->Password = 'rouz opce omts xfna';   // SMTP password
      $mail->SMTPSecure = 'ssl';  // encryption TLS/SSL 
      $mail->Port = 465;  // port to connect to                
      $mail->setFrom('hongquan262001@gmail.com', 'Hồng Quân' ); 
      $mail->addAddress($email,); 
      $mail->isHTML(true);  // Set email format to HTML
      $mail->Subject = "Order {$id} Confirmation";
      $noidungthu = "
      Dear {$name}, <br/>
      
      Thank you for choosing shopLQP! We are pleased to confirm your recent order. <br/>
      <br/>
      Here are the order details: <br/>
      <br/>
      Order Number: {$id} <br/>
      Date: {$added_on} <br/>
      Total Amount: {$total} <br/>
      We appreciate your trust in us and want to assure you that we are working hard to process your order promptly. <br/>
      <br/>
      If you have any questions or need further assistance, please contact our customer service department at PPT Polytechnic.
      <br/>
      Thank you for trusting and ordering at our shop. We look forward to serving you! <br/>
      <br/>
      Best regards, <br/>
      ShopLQP <br/>
      Phone: 0915531054 <br/>
      Email: Hongquan262001@gmail.com <br/>
";
      $mail->Body = $noidungthu;
      $mail->smtpConnect( array(
          "ssl" => array(
              "verify_peer" => false,
              "verify_peer_name" => false,
              "allow_self_signed" => true
          )
      ));
      $mail->send();
      echo 'Đã gửi mail xong';
  } catch (Exception $e) {
      echo 'Error: ', $mail->ErrorInfo;
  }
}

function orderSendEmailRefuse($email,$id,$name,$added_on,$total)
{
  require "../PHPMailer-master/src/PHPMailer.php"; 
  require "../PHPMailer-master/src/SMTP.php"; 
  require '../PHPMailer-master/src/Exception.php'; 
  $mail = new PHPMailer\PHPMailer\PHPMailer(true);//true:enables exceptions
  try {
      $mail->SMTPDebug = 0; //0,1,2: chế độ debug
      $mail->isSMTP();  
      $mail->CharSet  = "utf-8";
      $mail->Host = 'smtp.gmail.com';  //SMTP servers
      $mail->SMTPAuth = true; // Enable authentication
      $mail->Username = 'hongquan262001@gmail.com'; // SMTP username
      $mail->Password = 'rouz opce omts xfna';   // SMTP password
      $mail->SMTPSecure = 'ssl';  // encryption TLS/SSL 
      $mail->Port = 465;  // port to connect to                
      $mail->setFrom('hongquan262001@gmail.com', 'Hồng Quân' ); 
      $mail->addAddress($email,); 
      $mail->isHTML(true);  // Set email format to HTML
      $mail->Subject = "Order {$id} Confirmation";
      $noidungthu = "
      Dear {$name}, <br/>
        
         We regret to inform you that your order has been canceled. <br/>
         <br/>
         Here are the details of the canceled order: <br/>
         <br/>
         Order Number: {$id} <br/>
         Date: {$added_on} <br/>
         Total Amount: {$total} <br/>
         <br/>
         If you have any questions or concerns regarding the cancellation, please contact our customer service department at PPT Polytechnic. <br/>
         <br/>
         We apologize for any inconvenience this may have caused. <br/>
         <br/>
         Thank you for considering shopLQP. We hope to serve you in the future. <br/>
         <br/>
         Best regards, <br/>
         ShopLQP <br/>
         Phone: 0915531054 <br/>
         Email: Hongquan262001@gmail.com <br/>
";
      $mail->Body = $noidungthu;
      $mail->smtpConnect( array(
          "ssl" => array(
              "verify_peer" => false,
              "verify_peer_name" => false,
              "allow_self_signed" => true
          )
      ));
      $mail->send();
      echo 'Đã gửi mail xong';
  } catch (Exception $e) {
      echo 'Error: ', $mail->ErrorInfo;
  }
}