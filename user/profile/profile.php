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
                Account
              </a>
              <a class="list-group-item list-group-item-action" href="?act=resetpassword" role="tab">
                Password
              </a>
            </div>
          </div>
        </div>

        <div class="col-md-9 col-xl-10">
          <div class="tab-content">
            <div class="tab-pane fade show active" id="account" role="tabpanel">
              <div class="card">
                <div class="card-header">
                  <h5 class="card-title mb-0">Info</h5>
                </div>
                <div class="card-body">
                  <form method="post" enctype="multipart/form-data" id="validation-form">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <div class="row">
                      <div class="col-md-8">
                        <div class="form-group">
                          <label for="inputUsername">Email</label>
                          <input type="text" class="form-control" value="<?= $email ?>" name="email" placeholder="Email" disabled />
                        </div>
                        <div class="form-group">
                          <label for="inputUsername">Fullname</label>
                          <input type="text" class="form-control" value="<?= $fullname ?>" name="fullname" placeholder="Fullname" />
                        </div>
                        <div class="form-group">
                          <label for="inputUsername">Phone</label>
                          <input type="text" class="form-control" value="<?= $phone ?>" name="phone" placeholder="Phone" />
                        </div>
                        <div class="form-group">
                          <label for="inputUsername">Address</label>
                          <input type="text" class="form-control" value="<?= $address ?>" name="address" placeholder="Address" />
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="text-center">
                          <input type="hidden" name="oldImage" value="<?= $image ?>">
                          <img src="../uploads/<?= $image ?>" class="rounded-circle img-responsive mt-2" width="128" height="128" />
                          <div class="mt-2">
                            <input style="display: none;" type="file" id="fileInput" name="image">
                            <label for="fileInput" class="btn btn-primary"><i class="fas fa-upload"></i>Upload</label>
                          </div>
                          <small>For best results, use an image at least 128px by
                            128px in .jpg format</small>
                        </div>
                      </div>
                    </div>

                    <button type="submit" name="profile" class="btn btn-primary">
                      Save changes
                    </button>
                  </form>
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
      email: {
        maxlength: 50
      },
      fullname: {
        maxlength: 100
      },
      phone: {
        maxlength: 11
      },
      address: {
        maxlength: 50
      },
      image: {
        maxlength: 255
      }
    },
    messages: {
      email: {
        required: "Please enter your email",
        maxlength: "Your email is long"
      },
      fullname: {
        maxlength: "Your fullname is long"
      },
      phone: {
        maxlength: "Your phone is long"
      },
      address: {
        maxlength: "Your address is long"
      },
      image: {
        maxlength: "Your image is long"
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