<form id="validation-form" action="vnpay_create_payment.php" method="post">
  <!-- Checkout Start -->
  <input type="hidden" name="buynow" id="" value="<?= isset($_GET['buynow']) ?>">
  <div class="container-fluid pt-5">
    <div class="row px-xl-5">

      <!-- Info -->
      <div class="col-lg-8">
        <?php if (isset($_SESSION['user'])) : ?>
          <?php extract($_SESSION['user']) ?>
          <div class="mb-4">
            <h4 class="font-weight-semi-bold mb-4">Billing Address</h4>
            <div class="row">
              <div class="col-md-6 form-group">
                <label>Full Name</label>
                <input class="form-control" name="fullname" type="text" placeholder=" John" value="<?= $fullname ?>" />
              </div>
              <div class="col-md-6 form-group">
                <label>E-mail</label>
                <input class="form-control" type="text" placeholder="example@email.com" name="email" value="<?= $email ?>" />
              </div>
              <div class="col-md-6 form-group">
                <label>Phone Number</label>
                <input class="form-control" type="text" placeholder="+123 456 789" name="phone" value="<?= $phone ?>" />
              </div>
              <div class="col-md-6 form-group">
                <label>Address</label>
                <input class="form-control" type="text" placeholder="123 Street" name="address" value="<?= $address ?>" />
              </div>
            </div>
          </div>
          <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
        <?php else : ?>
          <div class="mb-4">
            <h4 class="font-weight-semi-bold mb-4">Billing Address</h4>
            <div class="row">
              <div class="col-md-6 form-group">
                <label>Full Name</label>
                <input class="form-control" name="fullname" type="text" placeholder="John" />
              </div>
              <div class="col-md-6 form-group">
                <label>E-mail</label>
                <input class="form-control" type="text" placeholder="example@email.com" name="email" />
              </div>
              <div class="col-md-6 form-group">
                <label>Phone Number</label>
                <input class="form-control" type="text" placeholder="+123 456 789" name="phone" />
              </div>
              <div class="col-md-6 form-group">
                <label>Address</label>
                <input class="form-control" type="text" placeholder="123 Street" name="address" />
              </div>
            </div>
          </div>
        <?php endif ?>
      </div>

      <!-- Orders -->
      <div class="col-lg-4">
        <div class="card border-secondary mb-5">
          <div class="card-header bg-secondary border-0">
            <h4 class="font-weight-semi-bold m-0">Order Total</h4>
          </div>
          <div class="card-body">
            <h5 class="font-weight-medium">Products</h5>
            <div id="products">
            </div>
            <hr class="mt-2" />
            <div class="d-flex justify-content-between mb-3 pt-1">
              <h6 class="font-weight-medium">Subtotal</h6>
              <h6 class="font-weight-medium" id="subTotal"></h6>
            </div>
            <div class="d-flex justify-content-between">
              <h6 class="font-weight-medium">Shipping</h6>
              <h6 class="font-weight-medium">$0</h6>
            </div>
          </div>
          <div class="card-footer border-secondary bg-transparent">
            <div class="d-flex justify-content-between mt-2">
              <h5 class="font-weight-bold">Total</h5>
              <h5 class="font-weight-bold" id="totalSummary"></h5>
              <input type="hidden" value="" id="totalID" name="total">
            </div>
          </div>
        </div>
        <div class="card border-secondary mb-5">
          <div class="card-header bg-secondary border-0">
            <h4 class="font-weight-semi-bold m-0">Payment</h4>
          </div>
          <div class="card-body">
            <div class="form-group">
              <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" name="payment" value="1" id="paypal" />
                <label class="custom-control-label" for="paypal">Paypal</label>
              </div>
            </div>
            <div class="form-group">
              <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" name="payment" value="2" id="directcheck" />
                <label class="custom-control-label" for="directcheck">Direct Check</label>
              </div>
            </div>
            <div class="">
              <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" name="payment" value="3" id="banktransfer" />
                <label class="custom-control-label" for="banktransfer">Bank Transfer</label>
              </div>
            </div>
          </div>
          <div class="card-footer border-secondary bg-transparent">
            <button name="order" class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">
              Place Order
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Checkout End -->
</form>

<script>
  function showItemProductCart() {
    let cartProductList;
    if (localStorage.getItem("cartProductList") == null) {
      cartProductList = [];
    } else {
      cartProductList = JSON.parse(localStorage.getItem("cartProductList"));
    }
    return JSON.stringify(cartProductList);
  }

  function showItemInSession() {
    let product;
    if (sessionStorage.getItem("product") == null) {
      product = [];
    } else {
      product = JSON.parse(sessionStorage.getItem("product"));
    }
    return JSON.stringify(product);
  }

  function totalAmount() {
    let rows = document.querySelectorAll('#products .itemPro');
    let totals = 0;
    for (let i = 0; i < rows.length; i++) {
      let total = $(`#totalAmount-${i}`).text();
      totals += Number(total.replace('$', ''));
    }
    totals = Math.round(100 * totals) / 100;
    $("#subTotal").text("$" + totals);
    $("#totalSummary").text("$" + totals);
    $("#totalID").val(totals);
  }

  // Call to local
  let product = showItemInSession();
  let carts = showItemProductCart();
  let items = product;
  let length = JSON.parse(product).length;

  if (length > 0) {
    items = product;
  } else {
    items = carts;
  }
  console.log(JSON.parse(items));
  $.ajax({
    url: "checkoutDetail.php",
    type: "post",
    data: {
      carts: items
    },
    success: function(data) {
      // console.log(data);
      $("#products").empty();
      $("#products").append(data);
      totalAmount();
    },
    error: function() {
      console.error('Error sending data');
    }
  });
</script>

<!-- Validation -->
<script>
  $('#validation-form').validate({
    rules: {
      fullname: {
        required: true,
        maxlength: 100,
      },
      email: {
        required: true,
        email: true,
        maxlength: 50,
      },
      phone: {
        required: true,
        maxlength: 11,
      },
      address: {
        required: true,
        maxlength: 50
      },
      payment: {
        required: true
      }
    },
    messages: {
      fullname: {
        required: "Please enter your full name",
        maxlength: "Your fullname is long"
      },
      email: {
        required: "Please enter your email",
        email: "Please enter valid email",
        maxlength: "Your email is long"
      },
      mobile: {
        required: "Please enter your phone number",
        maxlength: "Phone number no more than 11 characters."
      },
      address: {
        required: "Please enter your address",
        maxlength: "Your address is long"
      },
      payment: {
        required: "Choose the payment methods."
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