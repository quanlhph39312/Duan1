<div class="container-fluid p-5">
  <?php
  if (isset($_SESSION['user'])) {
    extract($_SESSION['user']);
  }
  ?>
  <main class="content">
    <div class="container-fluid p-0">

      <div class="row">
        <div class="col-md-3 col-xl-2">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title mb-0">Profile Settings</h5>
            </div>

            <div class="list-group list-group-flush" role="tablist">
              <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account" role="tab">
                Password
              </a>
              <a class="list-group-item list-group-item-action" href="?act=profile" role="tab">
                Account
              </a>
            </div>
          </div>
        </div>

        <div class="col-md-9 col-xl-10">
          <div class="tab-content">
            <!-- <div class="tab-pane fade" id="password" role="tabpanel"> -->
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Password</h5>

                <form method="post" id="validation-form">
                  <div class="form-group">
                    <label for="inputPasswordCurrent">Current password</label>
                    <input type="password" name="password" class="form-control" id="inputPasswordCurrent" />
                    <small><a href="/login/resetPassword.php">Forgot your password?</a></small>
                  </div>
                  <div class="form-group">
                    <label for="inputPasswordNew">New password</label>
                    <input name="newPassword" type="password" class="form-control" id="inputPasswordNew" />
                  </div>
                  <div class="form-group">
                    <label for="inputPasswordNew2">Verify password</label>
                    <input type="password" name="newPass" class="form-control" id="inputPasswordNew2" />
                  </div>
                  <button name="submit" type="submit" class="btn btn-primary">
                    Save changes
                  </button>
                </form>
                <?php
                if (isset($_POST['submit'])) {
                  $currentPass = $_POST['password'];
                  $password = substr(md5($currentPass), 0, 8);
                  $newPassword = $_POST['newPassword'];
                  $newPass = $_POST['newPass'];
                  $checkPass = loginCheckPass($password);
                  if (is_array($checkPass)) {
                    if ($currentPass == $newPassword) {
                      echo "New password do not same current password";
                    } else {
                      loginUpdatePassword(substr(md5($newPassword), 0, 8), $email);
                      echo "Change password success";
                    }
                  } else {
                    echo "Incorrect password";
                  }
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
</main>
</div>

<!-- Validation -->
<script>
  $('#validation-form').validate({
    rules: {
      password: {
        required: true
      },
      newPassword: {
        required: true,
      },
      newPass: {
        required: true,
        equalTo: "#inputPasswordNew"

      }
    },
    messages: {
      password: {
        required: "Enter current password"
      },
      newPassword: {
        required: "Enter new password"
      },
      newPass: {
        required: "Enter verify password",
        equalTo: "Verify password do not same new password"
      }
    },
    errorElement: 'div', // Add this line to use a div for error messages
    errorPlacement: function(error, element) {
      error.css('color', 'red');
      error.insertAfter(element); // Display error message after the input element
    },
    submitHandler: function(form) {
      form.submit();
    },
    highlight: function(element) {
      $(element).css('border-color', 'red'); // Highlight input with red border
    },
    unhighlight: function(element) {
      $(element).css('border-color', ''); // Reset to default border color
    }
  });
</script>