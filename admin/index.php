<?php
session_start();
include_once "../dao/category/category.php";
include_once "../dao/product/product.php";
include_once "../dao/productAttribute/productAttributes.php";
include_once "../dao/productAttribute/productAttributeColor.php";
include_once "../dao/productAttribute/productAttributeSize.php";
include_once "../dao/user/user.php";
include_once "../dao/comment/comment.php";
include_once "../dao/order/order.php";
include_once "../dao/orderDetail/orderDetail.php";
include_once "../dao/login/login.php";
include_once "../dao/dashboard/dashboard.php";
ob_start();
if (!isset($_SESSION['user'])) {
  header("location: ../login/signIn.php");
} else {
  if ($_SESSION['user']['role'] == 0) {
    //Tai khoan khong co quyen dang nhap admin
    header("location: ../user/");
  }
  extract($_SESSION['user']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="Responsive Bootstrap 4 Admin &amp; Dashboard Template" />

  <title>Admin</title>

  <link rel="preconnect" href="//fonts.gstatic.com/" crossorigin="" />

  <!-- PICK ONE OF THE STYLES BELOW -->
  <link href="./css/classic.css" rel="stylesheet" />
</head>

<body>
  <!-- Default setting -->
  <script src="./js/app.js"></script>
  <div class="wrapper">
    <!-- Left menu -->
    <?php include("left-menu.php") ?>
    <div class="main">
      <?php
      // Header
      include("header.php");

      // Main
      if (isset($_GET['act'])) {
        $act = $_GET['act'];
        switch ($act) {
          case 'home':
          case 'dashboard':
            $totalSales = dashboardGetTotalSales();
            $totalProducts = dashboardGetTotalProduct();
            $totalEarning = dashboardGetTotalEarning();
            $totalPendingOrder = dashboardGetTotalPendingOrder();
            $totalOrder = dashboardGetTotalOrder();
            $categorySolds = dashboardGetByCate();

            //Get data per month
            $monthDatas = [];
            $year = 2023;
            if (isset($_GET['year'])) {
              $year = $_GET['year'];
            }

            for ($month = 1; $month <= 12; $month++) {
              $result = dashboardGetSoldAndRevenue($month, $year);

              if ($result) {
                $monthlyData = [
                  'quantity' => $result[0]['quantity'],
                  'revenue' => $result[0]['revenue'],
                ];

                $monthDatas[] = $monthlyData;
              } else {
                $monthlyData = [
                  'quantity' => 0,
                  'revenue' => 0,
                ];
                $monthDatas[] = $monthlyData;
              }
            }
            // var_dump($monthDatas);
            $chartLine = json_encode($monthDatas);
            echo '<script>';
            echo 'var chartData = ' . $chartLine . ';';
            echo '</script>';
            include("dashboard/dashboard.php");
            break;

            // Category
            // List category
          case 'listCategory':
            $categories = categoryGetAll();
            include("category/list-category.php");
            // Update success
            if (isset($_GET['isSuccessUpdate'])) {
              $isSuccessUpdate = $_GET['isSuccessUpdate'];
              if ($isSuccessUpdate == 1) {
                echo "<script>showToast('Update')</script>";
              }
            }
            // Delete success
            if (isset($_GET['isSuccessDelete'])) {
              $isSuccessUpdate = $_GET['isSuccessDelete'];
              if ($isSuccessUpdate == 1) {
                echo "<script>showToast('Delete')</script>";
              }
            }
            // Restore success
            if (isset($_GET['isSuccessRestore'])) {
              $isSuccessRestore = $_GET['isSuccessRestore'];
              if ($isSuccessRestore == 1) {
                echo "<script>showToast('Restore')</script>";
              }
            }
            break;

            // Add category
          case 'addCategory':
            $success = 0;
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
              $name = $_POST['validation-category-name'];
              $image = $_FILES['validation-category-file'];
              // Save image
              $target_dir = "../uploads/";
              $target_file = $target_dir . basename($image['name']);
              move_uploaded_file($image["tmp_name"], $target_file);

              // check Name Category
              $categoryCheck = categoryCheck($name);
              if (is_array($categoryCheck)) {
                $success = -1;
              } else {
                // Insert
                categoryInsert($name, $image['name']);
                $success = 1;
              }
            }
            include("category/add-category.php");
            if ($success == 1) {
              $success = 0;
              echo "<script>
                      showToast('Add category success','success')
                    </script>";
            } elseif ($success == -1) {
              $success = 0;
              echo "<script>
                      showError('Category','Category name already exists','error')
                    </script>";
            }
            break;

            // Update category
          case 'updateCategory':
            $success = 0;
            if (isset($_GET['idCategory']) & $_GET['idCategory'] > 0) {
              $idCate = $_GET['idCategory'];
              $category = categoryGetOne($idCate);
            }
            if (isset($_POST['updateCategory'])) {
              $newname = $_POST['validation-category-name'];
              $name = $_POST['oldName'];
              $image = $_POST['oldImage'];
              $newImage = $_FILES['validation-category-file']['name'];
              $idCate = $_POST['idCategory'];

              if ($newImage != "") {
                $image = $newImage;
              }
              // Save image
              $target_dir = "../uploads/";
              $target_file = $target_dir . basename($image);
              move_uploaded_file($_FILES["validation-category-file"]["tmp_name"], $target_file);
              // check Trùng name
              $categoryCheck = categoryCheckUpdate($newname, $name);
              if (is_array($categoryCheck)) {
                $success = -1;
              } else {
                categoryUpdate($newname, $image, $idCate);
                header("location: ?act=listCategory&isSuccessUpdate=1");
              }
            }
            include("category/update-category.php");
            if ($success == -1) {
              $success = 0;
              echo "<script>
                      showError('Category','Name category is valid','error')
                    </script>";
            }
            break;

            // Delete cate
          case 'deleteCategory':
            if (isset($_GET['idCategory'])) {
              $idCate = $_GET['idCategory'];
              $cateStatus = categoryGetOne($idCate)['status'];
              if ($cateStatus == 0) {
                $cateStatus = 1;
              }
              categoryDelete($idCate, $cateStatus);
              header("location: ?act=listCategory&isSuccessDelete=1");
            }
            break;

          case 'restoreCategory':
            if (isset($_GET['idCategory'])) {
              $idCate = $_GET['idCategory'];
              $cateStatus = categoryGetOne($idCate)['status'];
              if ($cateStatus == 1) {
                $cateStatus = 0;
              }
              categoryDelete($idCate, $cateStatus);
              header("location: ?act=listCategory&isSuccessRestore=1");
            }
            break;


            // Product
          case 'listProduct':
            $products = productGetAll();
            include("product/list-product.php");
            // Update success
            if (isset($_GET['isSuccessUpdate'])) {
              $isSuccessUpdate = $_GET['isSuccessUpdate'];
              if ($isSuccessUpdate == 1) {
                echo "<script>showToast('Update')</script>";
              }
            }
            // Delete success
            if (isset($_GET['isSuccessDelete'])) {
              $isSuccessUpdate = $_GET['isSuccessDelete'];
              if ($isSuccessUpdate == 1) {
                echo "<script>showToast('Delete')</script>";
              }
            }
            // Restore success
            if (isset($_GET['isSuccessRestore'])) {
              $isSuccessRestore = $_GET['isSuccessRestore'];
              if ($isSuccessRestore == 1) {
                echo "<script>showToast('Restore')</script>";
              }
            }
            break;

          case 'addProduct':
            $isSuccess = 0;
            if (isset($_POST['addPro'])) {
              // Product
              $name = $_POST['validation-product-name'];
              $image = $_FILES["validation-product-file"];
              $price = $_POST['validation-product-price'];
              $description = $_POST['validation-product-description'];
              $category = $_POST['validation-product-select'];

              // Save image
              $target_dir = "../uploads/";
              $target_file = $target_dir . basename($image['name']);
              move_uploaded_file($image["tmp_name"], $target_file);

              // check name Product
              $productCheck = productCheck($name);
              if (is_array($productCheck)) {
                $isSuccess = -1;
              } else {
                // Insert
                productInsert($name, $image['name'], $description, $price, $category);

                // Lay ra id cua san pham vua them vao
                $idCurrent = productSelectLast();
                $idPro = $idCurrent[0]['id'];

                // Product att
                $priceAtt = $_POST['validation-product-att-price'];
                $quantityAtt = $_POST['validation-product-att-qty'];
                $colorAtt = $_POST['validation-product-att-color-id'];
                $sizeAtt = $_POST['validation-product-att-size-id'];
                $imgAtt = $_FILES['validation-product-att-image'];
                $color = implode(', ', $colorAtt);
                $size = implode(', ', $sizeAtt);

                for ($i = 0; $i < sizeof($priceAtt); $i++) {
                  // Save image
                  $target_dir = "../uploads/";
                  $target_file = $target_dir . basename($imgAtt['name'][$i]);
                  move_uploaded_file($imgAtt["tmp_name"][$i], $target_file);

                  // check size color product
                  $productAttCheck = productAttCheck($color, $size, $idPro);
                  if (is_array($productAttCheck)) {
                    $isSuccess = -2;
                    break;
                  } else {
                    // Insert
                    productAttInsert($idPro, $priceAtt[$i], $colorAtt[$i], $sizeAtt[$i], $quantityAtt[$i], $imgAtt['name'][$i]);
                    $isSuccess = 1;
                  }
                }
              }
            }

            $categories = categoryGetAll();
            $productSizes = productAttGetAllSize();
            $productColors = productAttGetAllColor();

            include("product/add-product.php");

            if ($isSuccess == 1) {
              $isSuccess = 0;
              echo "<script>showToast()</script>";
            } elseif ($isSuccess == -1) {
              $isSuccess = 0;
              echo "<script>
                      showError('Product','Product name already exists','error')
                    </script>";
            } elseif ($isSuccess == -2) {
              $isSuccess = 0;
              echo "<script>
                      showError('Product','Size or color already exists','error')
                    </script>";
            }
            break;

          case 'updateProduct':
            $isSuccess = 0;
            if (isset($_GET['idProduct'])) {
              $id = $_GET['idProduct'];
              $product = productSelectOne($id);
            }
            if (isset($_POST['updateProduct'])) {
              $id = $_POST['idProduct'];
              $name = $_POST['oldName'];
              $newName = $_POST['validation-product-name'];
              $image = $_POST['oldImage'];
              $newImage = $_FILES["validation-product-file"]['name'];
              $price = $_POST['validation-product-price'];
              $description = $_POST['validation-product-description'];
              $category = $_POST['validation-product-select'];

              if ($newImage != "") {
                $image = $newImage;
              }
              // Save image
              $target_dir = "../uploads/";
              $target_file = $target_dir . basename($image);
              move_uploaded_file($_FILES["validation-product-file"]["tmp_name"], $target_file);

              //  check name product
              $productCheck = productCheckUpdate($newName, $name);
              if (is_array($productCheck)) {
                $isSuccess = -1;
              } else {
                // Update
                productUpdate($id, $newName, $price, $image, $description, $category);
                header("location: ?act=listProduct&isSuccessUpdate=1");
              }
            }
            $categories = categoryGetAll();
            include("product/update-product.php");
            if ($isSuccess == -1) {
              $isSuccess = 0;
              echo "<script>
                      showError('Product','Product name already exists','error')
                    </script>";
            } elseif ($isSuccess == 0) {
              echo  "<script>
                        showToast()
                    </script>";
            }
            break;

            // Delete product
          case 'deleteProduct':
            if (isset($_GET['idProduct'])) {
              $id = $_GET['idProduct'];
              $status = productSelectOne($id)['status'];
              if ($status == 0) {
                $status = 1;
              } else {
                $status = 0;
              }
              productDelete($id, $status);
              header("location: ?act=listProduct&isSuccessDelete=1");
            }
            break;
            // restoreProduct
          case 'restoreProduct':
            if (isset($_GET['idProduct'])) {
              $idPro = $_GET['idProduct'];
              $proStatus = productSelectOne($idPro)['status'];
              if ($proStatus == 1) {
                $proStatus = 0;
              }
              productDelete($idPro, $proStatus);
              header("location: ?act=listProduct&isSuccessRestore=1");
            }
            break;

            // Product Attributes
          case 'attributeProduct':
            $idProduct = $_GET['idProduct'];
            $productAttributes = productAttGetByIdProduct($idProduct);
            include("productAttribute/list-attribute.php");
            // Update success
            if (isset($_GET['isSuccessUpdate'])) {
              $isSuccessUpdate = $_GET['isSuccessUpdate'];
              if ($isSuccessUpdate == 1) {
                echo "<script>showToast('Update')</script>";
              }
            }
            // Delete success
            if (isset($_GET['isSuccessDelete'])) {
              $isSuccessUpdate = $_GET['isSuccessDelete'];
              if ($isSuccessUpdate == 1) {
                echo "<script>showToast('Delete')</script>";
              }
            }

            // Restore success
            if (isset($_GET['isSuccessRestore'])) {
              $isSuccessRestore = $_GET['isSuccessRestore'];
              if ($isSuccessRestore == 1) {
                echo "<script>showToast('Restore')</script>";
              }
            }
            break;

            // Add product att
          case 'addProductAttribute':
            $isSuccess = 0;
            if (isset($_POST['addProAtt'])) {
              // Product att
              $idPro = $_GET['idProduct'];
              $priceAtt = $_POST['validation-product-att-price'];
              $quantityAtt = $_POST['validation-product-att-qty'];
              $colorAtt = $_POST['validation-product-att-color-id'];
              $sizeAtt = $_POST['validation-product-att-size-id'];
              $imgAtt = $_FILES['validation-product-att-image']['name'];
              $color = implode(', ', $colorAtt);
              $size = implode(', ', $sizeAtt);
              $price = implode($priceAtt);
              $quantity = implode($quantityAtt);
              $image = implode($imgAtt);

              // save Image
              $target_dir = "../uploads/";
              $target_file = $target_dir . basename($image);
              move_uploaded_file(implode($_FILES['validation-product-att-image']['tmp_name']), $target_file);
              // check size color
              $productAttCheck = productAttCheck($color, $size, $idPro);
              if (is_array($productAttCheck)) {
                $isSuccess = -1;
                break;
              } else {
                for ($i = 0; $i < sizeof($priceAtt); $i++) {
                  productAttInsert($idPro, $priceAtt[$i], $colorAtt[$i], $sizeAtt[$i], $quantityAtt[$i], $imgAtt[$i]);
                }
                $isSuccess = 1;
              }
            }
            $categories = categoryGetAll();
            $productSizes = productAttGetAllSize();
            $productColors = productAttGetAllColor();
            include("productAttribute/add-attribute.php");
            if ($isSuccess == 1) {
              $isSuccess = 0;
              echo "<script>showToast()</script>";
            } elseif ($isSuccess == -1) {
              echo "<script>
                      showError('Product Attribute','Size or color already exists','error')
                    </script>";
            }
            break;

            // Update product att
          case 'updateProductAttribute':
            if (isset($_GET['idProductAttribute'])) {
              $proAtt = productAttGetOne($_GET['idProductAttribute']);
            }
            if (isset($_POST['updateProAtt'])) {
              $idAtt = $_POST['idProductAttribute'];
              $idPro = $_POST['idProduct'];
              $price = $_POST['validation-product-att-price'];
              $quantity = $_POST['validation-product-att-qty'];
              $image = $_POST['oldImage'];
              $newImage = $_FILES['validation-product-att-image']['name'];
              if ($newImage != "") {
                $image = $newImage;
              }
              // save Image
              $target_dir = "../uploads/";
              $target_file = $target_dir . basename($image);
              move_uploaded_file($_FILES['validation-product-att-image']['tmp_name'], $target_file);

              $productAttCheck = productAttCheck($color, $size, $idPro);
              if (is_array($productAttCheck)) {
              }
              productAttUpdate($idAtt, $price, $quantity, $image);
              header("location: ?act=attributeProduct&idProduct=$idPro&isSuccessUpdate=1");
            }
            $productSizes = productAttGetAllSize();
            $productColors = productAttGetAllColor();
            include("productAttribute/update-attribute.php");
            break;

            // Delete product att
          case 'deleteProductAttribute':
            if (isset($_GET['idProductAttribute']) && $_GET['idProductAttribute'] > 0) {
              $idPro = $_GET['idProduct'];
              $idProAtt = $_GET['idProductAttribute'];
              $proAtt =  productAttGetOne($idProAtt);

              if ($proAtt['status'] == 0) {
                $message = "isSuccessDelete";
                $status = 1;
              } else {
                $message = "isSuccessRestore";
                $status = 0;
              }
              productAttDelete($idProAtt, $status);
              header("location: ?act=attributeProduct&idProduct=$idPro&$message=1");
            }
            break;

            // User
          case 'listUser':
            $users = userGetAll();
            include("user/list-user.php");
            // block success
            if (isset($_GET['isSuccessDelete'])) {
              $isSuccessUpdate = $_GET['isSuccessDelete'];
              if ($isSuccessUpdate == 1) {
                echo "<script>showToast('Block')</script>";
              }
            }
            // Activated success
            if (isset($_GET['isSuccessActivated'])) {
              $isSuccessActivated = $_GET['isSuccessActivated'];
              if ($isSuccessActivated == 1) {
                echo "<script>showToast('Activated')</script>";
              }
            }
            break;
          case 'addUser':
            include("../admin/pages-404.php");
            break;
          case 'updateUser':
            include("../admin/pages-404.php");
            break;

          case 'deleteUser':
            $isSuccess = 0;
            if (isset($_GET['idUser'])) {
              $id = $_GET['idUser'];
              $status = userGetOne($id)['status'];
              if ($status == 0) {
                $status = 1;
              } else {
                $status = 0;
              }
              userDelete($id, $status);
              $isSuccess = 1;
              header("location: ?act=listUser&isSuccessDelete=$isSuccess");
            }
            break;

            // Activated User
          case 'ActivatedUser':
            if (isset($_GET['idUser'])) {
              $idUser = $_GET['idUser'];
              $userStatus = userGetOne($id)['status'];
              if ($userStatus == 1) {
                $userStatus = 0;
              }
              userDelete($idUser, $userStatus);
              header("location: ?act=listUser&isSuccessActivated=1");
            }
            break;

            // Comment
          case 'comment':
            $comments = commentGetAll();
            include("comment/list-comment.php");
            break;
          case 'detailComment':
            if (isset($_GET['idPro'])) {
              $id = $_GET['idPro'];
              $comments = commentGetDetail($id);
            }
            include("comment/detail-comment.php");
            if (isset($_GET['isSuccessDelete'])) {
              $isSuccessUpdate = $_GET['isSuccessDelete'];
              if ($isSuccessUpdate == 1) {
                echo "<script>showToast('Delete')</script>";
              }
            }
            break;

          case 'deleteComment':
            $isSuccess = 0;
            if (isset($_GET['idComment'])) {
              $idPro = $_GET['idPro'];
              $id = $_GET['idComment'];
              commentDelete($id);
              $isSuccess = 1;
              header("location: ?act=detailComment&idPro=$idPro&isSuccessDelete=$isSuccess");
            }
            break;

            // Order
          case 'order':
            $orders =  orderGetAll();
            include("order/list-order.php");
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
            break;
          case 'detailOrder':
            if (isset($_GET['idOrder'])) {
              $id = $_GET['idOrder'];
              $orderDetails = orderDetailGetAllById($id);
            }
            include("order/detail-order.php");
            break;

          case 'confirmOrder':
            if (isset($_GET['idOrder'])) {
              $id = $_GET['idOrder'];
              orderSetStatusOrder(1, $id);
              $order = orderDetailGetAllId($id);
              if (!empty($order)) {
                $email = $order[0]['email'];
                $fullname = $order[0]['fullname'];
                $id_order = $order[0]['id_order'];
                $total_payment = $order[0]['total_payment'];
                $added_on = $order[0]['added_on'];
                orderSendEmailconfirm($email, $id_order, $fullname, $added_on, $total_payment);

                header("location: ?act=order&isSuccessConfirm=1");
              } else {
                echo "Order not found.";
              }
            }
            break;

          case 'refuseOrder':
            if (isset($_GET['idOrder'])) {
              $id = $_GET['idOrder'];
              orderSetStatusOrder(-1, $id);
              $order = orderDetailGetAllId($id);
              if (!empty($order)) {
                $email = $order[0]['email'];
                $fullname = $order[0]['fullname'];
                $name = $order[0]['name'];
                $quantity = $order[0]['quantity'];
                $price = $order[0]['price'];
                $id_order = $order[0]['id_order'];
                $total_payment = $order[0]['total_payment'];
                $added_on = $order[0]['added_on'];
                orderSendEmailRefuse($email, $id_order, $fullname, $added_on, $name, $quantity, $total_payment);
                header("location: ?act=order&isSuccessRefuse=1");
              } else {
                echo "Order not found.";
              }
            }
            break;

            // signOut
          case 'signOut':
            session_unset();
            header("location: ../user/index.php");
            break;

            // Help
          case 'help':
            include("../admin/pages-404.php");
            break;

            // Default
          default:
            header("location: ?act=home");
            break;
        }
      } else {
        header("location: ?act=home");
        // include("dashboard/dashboard.php");
      }

      // Footer
      include("footer.php");
      ?>
    </div>
  </div>

</body>

</html>


<?php
ob_end_flush();
?>