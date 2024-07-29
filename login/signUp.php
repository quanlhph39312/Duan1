<?php
include "../dao/login/login.php";
if (isset($_POST['signUp'])) {
  $email = $_POST['email'];
  $fullname = $_POST['fullname'];
  $password = $_POST['password'];
  $rePassword = $_POST['rePassword'];
  $isSuccessSignUp = 0;
  $result = checkUser($email);

  if (is_array($result)) {
    // "Tài khoản hoặc email bạn vừa nhập đã tồn tại."
    $isSuccessSignUp = 1;
  } else {
    // "Đăng ký tài khoản thành công";
    userInsert($email, $fullname, substr(md5($password), 0, 8));
    header("location:signIn.php?act=signUp&isSuccessSignUp=$isSuccessSignUp");
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <title>Sign Up</title>

  <link href="../admin/css/classic.css" rel="stylesheet" />
</head>

<body>
  <main class="main d-flex w-100">
    <div class="container d-flex flex-column">
      <div class="row h-100">
        <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
          <div class="d-table-cell align-middle">
            <div class="text-center mt-4">
              <h1 class="h2">Get started</h1>
              <p class="lead">
                Start creating the best possible user experience for you
                customers.
              </p>
            </div>

            <div class="card">
              <div class="card-body">
                <div class="m-sm-4">
                  <form method="post" action="" id="validation-form">
                    <div class="form-group">
                      <label>Email</label>
                      <input class="form-control form-control-lg" type="email" name="email" placeholder="Enter your email" />
                    </div>
                    <div class="form-group">
                      <label>Fullname</label>
                      <input class="form-control form-control-lg" type="text" name="fullname" placeholder="Enter your name" />
                    </div>
                    <div class="form-group">
                      <label>Password</label>
                      <input class="form-control form-control-lg" type="password" name="password" id="password" placeholder="Enter password" />
                    </div>
                    <div class="form-group">
                      <label>Re Password</label>
                      <input class="form-control form-control-lg" type="password" name="rePassword" placeholder="Enter re-password" />
                    </div>

                    <div class="d-flex mt-2">
                      <a href="signIn.php" name="" class="ml-auto">You have account? Sign in?</a>
                    </div>

                    <div class="text-center mt-3">
                      <!-- <a href="?act=signUp.php" class="btn btn-lg btn-primary"
                          >Sign up</a
                        > -->
                      <button type="submit" name="signUp" class="btn btn-lg btn-primary">Sign up</button>
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


<script src="../admin/js/app.js"></script>
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
          email: true,
          maxlength: 50
        },
        "fullname": {
          required: true,
          maxlength: 100
        },
        "password": {
          required: true,
          maxlength: 10
        },
        "rePassword": {
          required: true,
          equalTo: "#password",
          maxlength: 10
        }
      },
      messages: {
        "email": {
          required: "Do not leave the email blank.",
          email: "Is not a email",
          maxlength: "Your email is long"
        },
        "fullname": {
          required: "Do not leave the fullname blank.",
          maxlength: "Your fullname is long"
        },
        "password": {
          required: "Do not leave the password blank.",
          maxlength: "Your password is long"
        },
        "rePassword": {
          required: "Do not leave the re-password blank.",
          equalTo: "Please enter the same password as above",
          maxlength: "Your re-password is long"
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
// Sign up
if (isset($isSuccessSignUp)) {
  switch ($isSuccessSignUp) {
    case 1:
      echo "<script>
              showToast('Account','Email already exists','error')
            </script>";
      break;
  }
}

?>