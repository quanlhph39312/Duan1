<?php
// Navbar
include_once("_navbar.php");

// Controller
if (isset($_GET['act'])) {
  $act = $_GET['act'];
  switch ($act) {
    case 'home':
      include_once("./home/index.php");
      break;

      // Detail 
    case 'detail':
      if (isset($_GET['idProduct'])) {
        $id = $_GET['idProduct'];
        $product = productSelectOne($id);
        extract($product);
        $products = productSelectByIdCate($id_cate, $id);
        $comments = commentGetAllForProduct($id);
        $imageProducts = productAttGetAllImageByIdPro($id);
        $colors = productAttGetAllColorByIdPro($id);
        $sizes = productAttGetAllSizeByIdPro($id);
        // comment
        // if (isset($_POST['submit']) && ($_POST['submit'])) {
        //   $content = $_POST['content'];
        //   $idUser = $_SESSION['user']['id'];
        //   commentInsert($content, $id, $idUser);
        //   // header("location:?act=detail&idProduct=$id");
        // }
      }
      include_once("./detail.php");
      break;

      // Shop 
    case 'shop':
      $categories = categoryGetAllStatus();
      $itemPerPage = !empty($_GET['perPage']) ? $_GET['perPage'] : 9;
      $currentPage = !empty($_GET['Page']) ? $_GET['Page'] : 1;
      $offset = ($currentPage - 1) * $itemPerPage;
      $totalRecords = productRowAll();
      $totalPage = ceil($totalRecords / $itemPerPage);
      $products = productSelectAll($itemPerPage, $offset);
      // Filter by category
      if (isset($_GET['idCategory'])) {
        $id = $_GET['idCategory'];
        $offset = ($currentPage - 1) * $itemPerPage;
        $totalRecords = productRow($id);
        $totalPage = ceil($totalRecords / $itemPerPage);
        $products = productFilterByIdCate($id, $itemPerPage, $offset);
      }
      // Search by name
      if (isset($_POST['searchByName'])) {
        $searchByName = $_POST['searchProduct'];
        $products = productSearchByName($searchByName);
      }
      // Sort price
      if (isset($_GET['sortPrice'])) {
        $sort = $_GET['sortPrice'];
        $products = productSortByPrice($sort);
      }
      include_once("./shop.php");
      break;

      // Contact
    case 'contact':
      include_once("./contact.php");
      break;

      // Cart
    case 'cart':
      include("./cart.php");
      break;

      // Checkout
    case 'checkout':
      if (isset($_POST['order'])) {
        $fullname = $_POST['fullname'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $payment = $_POST['payment'];
        $totalAmount = $_POST['total'];
        $method = $_POST['buynow'];
        orderInsert($fullname, $phone, $address, $email, $totalAmount, $payment);
        // lay ra bien id order
        $id = orderSelectLastId();
        $id_order = $id[0]['id'];

        $idProAtt = $_POST['idProAtt'];
        $quantity = $_POST['quantityPro'];
        for ($i = 0; $i < sizeof($quantity); $i++) {
          orderDetailInsert($id_order, $idProAtt[$i], $quantity[$i]);
        }

        if (isset($method) && $method == 1) {
          // Delete product in session
          echo "<script>
                  sessionStorage.removeItem('product');
                  window.location.href = '?act=orderSuccess';
                </script>";
        } else {
          // Delete product in local
          echo "<script>
                  localStorage.removeItem('cartProductList');
                  window.location.href = '?act=orderSuccess';
                </script>";
        }
        // header("location: ?act=orderSuccess");
      }
      include_once("./checkout.php");
      break;

      // Order detail
    case 'orderDetail':
      if (isset($_POST['searchOrder'])) {
        $id = $_POST['idOrder'];
        $order = orderGetOne($id);
        $showOrder = orderDetailSelectAll($id);
        $email = $_SESSION['user']['email'];
        $order = checkOrderSelectAll($email);
      }

      // Check user
      if (isset($_SESSION['user'])) {
        $orders = checkOrderSelectAll($email);
        include_once("./order/list-order.php");

       // Confirm success
       if (isset($_GET['isSuccessConfirm'])) {
        $isSuccessConfirm = $_GET['isSuccessConfirm'];
        if ($isSuccessConfirm == 1) {
          echo "<script>showToast('Confirm')</script>";
        }
      }

      // Refuse success
      if (isset($_GET['isSuccessRefuse'])) {
        $isSuccessRefuse = $_GET['isSuccessRefuse'];
        if ($isSuccessRefuse == 1) {
          echo "<script>showToast('Refuse')</script>";
        }
      }
     } else {
        include('./checkOrder.php');
      }
      break;

    case 'detailOrder':
      if (isset($_GET['idOrder'])) {
        $id = $_GET['idOrder'];
        $orderDetails = orderDetailGetAllById($id);
      }
      include("order/detail-order.php");
      break;

    case 'refuseOrder':
            if (isset($_GET['idOrder'])) {
              echo "đã vào";
              $id = $_GET['idOrder'];
              orderSetStatusOrder(-1, $id);
              header("location: ?act=orderDetail&isSuccessConfirm=1");
            }
            break;
      // Order success
    case 'orderSuccess':
      include("./orderSuccess.php");
      break;

      // Add to cart
    case 'buy':
      if (isset($_POST['buyNow'])) {
        $id = $_POST['idProduct'];
        echo $id;
      }
      include_once("./buyNow.php");
      break;

    case 'profile':
      if (isset($_POST['profile'])) {
        $id = $_POST['id'];
        $fullname = $_POST['fullname'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $image = $_POST['oldImage'];
        $newImage = $_FILES['image']['name'];
        if ($newImage != "") {
          $image = $newImage;
        }
        // save image
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        loginUpdateUser($fullname, $phone, $address, $image, $id);
        $_SESSION['user'] =  loginUserOne($id);
        header("location:?act=profile");
      }
      include("profile/profile.php");
      break;

      // 
    case 'resetpassword':
      include("profile/rePassword.php");
      break;

      // signOut
    case 'signOut':
      session_unset();
      header("location:?act=home");
      break;
    default:
      include_once("./home/index.php");
  }
} else {
  include_once("./home/index.php");
}

// Footer
include_once("_footer.php");
