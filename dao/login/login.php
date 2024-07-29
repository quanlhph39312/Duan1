<?php
require_once '../dao/pdo.php';
function checkUser($email){
    $sql = "SELECT * FROM user where email ='" . $email . "'";
    return  pdo_query_one($sql);
}
function loginUser($email,$password){
    $sql = "SELECT * FROM user where email ='".$email."' AND password ='".$password."'";
    return  pdo_query_one($sql);
}
function loginCheckPass($password){
    $sql = "SELECT password FROM user WHERE password ='".$password."'";
    return pdo_query_one($sql);
}
function userInsert($email,$fullname,$password){
    $sql = "INSERT INTO user (email,fullname,password) VALUES ('$email','$fullname','$password')";
    pdo_execute($sql);
}
function loginUpdateUser($fullname,$phone,$address,$image,$id){
    $sql = "UPDATE user SET fullname ='".$fullname."',phone='".$phone."',address='".$address."',image ='".$image."' WHERE id=$id";
    pdo_execute($sql);
}
function loginUserOne($id){
    $sql ="SELECT * FROM user WHERE id = $id";
    return pdo_query_one($sql);
}
function loginGetPassword($email,$passwordNew){
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
        $mail->Subject = 'Thư gửi mật khẩu';
        $noidungthu = "Mật khẩu của bạn là {$passwordNew} <br/>"."Vui lòng không chia sẻ mật khẩu này"; 
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

function loginUpdatePassword($password,$email){
    $sql = "UPDATE `user` SET `password`= '".$password."' WHERE `email` = '".$email."'";
    pdo_execute($sql);
}
function loginGetById($idUser){
    $sql = "SELECT `id` FROM user WHERE id = $idUser";
    return pdo_query_one($sql);
}


?>