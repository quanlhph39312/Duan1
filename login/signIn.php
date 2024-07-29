<?php
session_start();
include "../dao/login/login.php";
if (isset($_POST['signIn'])) {
  $isSuccessLogin = 0;
  $email = $_POST['email'];
  $password = substr(md5($_POST['password']), 0, 8);
  $checkUser = loginUser($email, $password);
  if (is_array($checkUser)) {
    extract($checkUser);
    if (isset($status) && $status == 0) {
      $_SESSION['user'] = $checkUser;
      header("location: ../user/");
    } else {
      // Tai khoan bi khoa
      $isSuccessLogin = 1;
    }
  } else {
    // Sai ten tai khoan hoac mat khau
    $isSuccessLogin = 2;
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Sign In - AppStack - Admin &amp; Dashboard Template</title>

  <link rel="preconnect" href="//fonts.gstatic.com/" crossorigin="" />

  <link href="../admin/css/classic.css" rel="stylesheet" />
  <script src="../admin/js/app.js"></script>
</head>

<body>
  <main class="main d-flex w-100">
    <div class="container d-flex flex-column">
      <div class="row h-100">
        <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
          <div class="d-table-cell align-middle">
            <div class="text-center mt-4">
              <h1 class="h2">Welcome back</h1>
              <p class="lead">Sign in to your account to continue</p>
            </div>

            <div class="card">
              <div class="card-body">
                <div class="m-sm-4">
                  <div class="text-center">
                    <img src="../admin/img/avatars/avatar.jpg" alt="Chris Wood" class="img-fluid rounded-circle" width="132" height="132" />
                  </div>
                  <form method="post" id="validation-form">
                    <div class="form-group">
                      <label>Email</label>
                      <input class="form-control form-control-lg" type="email" name="email" placeholder="Enter your email" />
                    </div>
                    <div class="form-group">
                      <label>Password</label>
                      <input class="form-control form-control-lg" type="password" name="password" required placeholder="Enter your password" />
                    </div>

                    <div class="d-flex mt-2">
                      <a href="resetPassword.php">Forgot password?</a>
                      <a href="signUp.php" name="" class="ml-auto">You don't have account? Sign up?</a>
                    </div>

                    <div class="text-center mt-3">
                      <!-- <a href="../user/" class="btn btn-lg btn-primary"
                          >Sign in</a
                        > -->

                      <button type="submit" name="signIn" class="btn btn-lg btn-primary">Sign in</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

</body>

</html>


<!-- Validate -->
<script>
  // Trigger validation on tagsinput change
  $("input[name=\"validation-bs-tagsinput\"]").on("itemAdded itemRemoved", function() {
    $(this).valid();
  });

  $(function() {
    $("#validation-form").validate({
      rules: {
        "email": {
          required: true,
          email: true
        },
        "password": {
          required: true
        }
      },
      messages: {
        "email": {
          required: "Do not leave the email blank.",
          email: "Is not a email"
        },
        "password": {
          required: "Do not leave the password blank.",
        }
      },
      // Errors
      errorPlacement: function errorPlacement(error, element) {
        var $parent = $(element).parents(".form-group");
        // Do not duplicate errors
        if ($parent.find(".jquery-validation-error").length) {
          return;
        }
        $parent.append(
          error.addClass("jquery-validation-error small form-text invalid-feedback")
        );
      },
      highlight: function(element) {
        var $el = $(element);
        var $parent = $el.parents(".form-group");
        $el.addClass("is-invalid");
      },
      unhighlight: function(element) {
        $(element).parents(".form-group").find(".is-invalid").removeClass("is-invalid");
      }
    });
  });
</script>

<!-- Show notification -->
<script>
  function showToast(title, message, type) {
    var title = title;
    var message = message;
    var type = type;

    toastr[type](message, title, {
      positionClass: 'toast-top-right',
      closeButton: 'checked',
      progressBar: 'checked',
      newestOnTop: 'checked',
      rtl: $('body').attr('dir') === 'rtl' || $('html').attr('dir') === 'rtl',
      timeOut: 5000,
    });
  }

  function clearToast() {
    toastr.clear();
  }
</script>


<!-- Show notification -->
<?php
// Forgot password
if (isset($_GET['act']) && $_GET['act'] = "forgotPassword") {
  if (isset($_GET['isSuccess']) && $_GET['isSuccess'] == 0) {
    echo "<script>
             showToast('Password','Forgot password success','success')
          </script>";
  }
}

// Login
if (isset($isSuccessLogin)) {
  switch ($isSuccessLogin) {
    case 1:
      echo "<script>
              showToast('Account','Your account has been locked','error')
            </script>";
      break;
    case 2:
      echo "<script>
              showToast('Account','Email or password is incorrect','error')
            </script>";
      break;
  }
}


// Sign up
if (isset($_GET['act']) && $_GET['act'] = "signUp") {
  if (isset($_GET['isSuccessSignUp']) && $_GET['isSuccessSignUp'] == 0) {
    echo "<script>
             showToast('Account','Sign up account success','success')
          </script>";
  }
}
?>