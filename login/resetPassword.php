<?php
include "../dao/login/login.php";
if (isset($_POST['resetPassword'])) {
  $email = $_POST['email'];
  $checkEmail = checkUser($email);
  $isSuccess = 0;
  if (is_array($checkEmail)) {
    $passwordNew = substr((rand(0, 9999)), 0, 8);
    loginGetPassword($email, $passwordNew);
    loginUpdatePassword(substr(md5($passwordNew), 0, 8), $email);
    header("location: signIn.php?act=forgotPassword&isSuccess=$isSuccess");
  } else {
    $isSuccess = 1;
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Reset Password</title>

  <link rel="preconnect" href="//fonts.gstatic.com/" crossorigin="" />

  <link href="../admin/css/classic.css" rel="stylesheet" />
</head>

<body>
  <main class="main d-flex w-100">
    <div class="container d-flex flex-column">
      <div class="row h-100">
        <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
          <div class="d-table-cell align-middle">
            <div class="text-center mt-4">
              <h1 class="h2">Reset password</h1>
              <p class="lead">Enter your email to reset your password.</p>
            </div>

            <div class="card">
              <div class="card-body">
                <div class="m-sm-4">
                  <form method="post" id="validation-form">
                    <div class="form-group">
                      <label>Email</label>
                      <input class="form-control form-control-lg" type="email" name="email" placeholder="Enter your email" />
                    </div>

                    <div class="d-flex mt-2">
                      <a href="signIn.php" name="" class="ml-auto">You have account? Sign in?</a>
                    </div>
                    <div class="text-center mt-3">
                      <!-- <a href="signIn.html" class="btn btn-lg btn-primary"
                          >Reset password</a
                        > -->
                      <button type="submit" name="resetPassword" class="btn btn-lg btn-primary">Reset password</button>
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
          email: true
        }
      },
      messages: {
        "email": {
          required: "Do not leave the email blank.",
          email: "Is not a email"
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
  function showToast() {
    var title = "Password";
    var message = "Invalid email";
    var type = "error";

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
// Invalid email
if (isset($isSuccess) && $isSuccess == 1) {
  echo "<script>showToast()</script>";
}
?>