<main class="content">
  <div class="container-fluid p-0">
    <h1 class="h3 mb-3">Update Product Attribute</h1>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title mb-0">Product Attribute</h5>
          </div>

          <div class="d-flex justify-content-center align-items-end">
            <a href="?act=attributeProduct&idProduct=<?= $_GET['idProduct'] ?>" class="btn btn-primary ml-auto mr-3">
              <span id="payment-button-amount" class="text-white">List Attribute</span>
            </a>
          </div>
          <div class="card-body">
            <form id="validation-form" method="post" enctype="multipart/form-data" action="?act=updateProductAttribute">
              <input type="hidden" name="idProductAttribute" value="<?= $_GET['idProductAttribute'] ?>">
              <input type="hidden" name="idProduct" value="<?= $_GET['idProduct'] ?>">
              <!-- Product attributes -->
              <div id="product_attr_box">
                <div class="d-flex justify-content-between align-items-end">
                  <div>
                    <span>Product attributes</span>
                  </div>
                </div>

                <div class="row mt-3" id="attr_1">

                  <!-- Price -->
                  <div class="form-group col-lg-3">
                    <label class="form-label">Price</label>
                    <input type="number" name="validation-product-att-price" placeholder="Price" class="product-att-price form-control" value="<?= $proAtt['price'] ?>">
                  </div>

                  <!-- Quantity -->
                  <div class="form-group col-lg-2">
                    <label class="form-label">Quantity</label>
                    <input type="number" name="validation-product-att-qty" placeholder="Quantity" class="form-control" value="<?= $proAtt['quantity'] ?>">
                  </div>

                  <!-- Size -->
                  <div class="form-group col-lg-2">
                    <label class="form-label">Size</label>
                    <select class="form-control" name="validation-product-att-size-id" id="size_id" disabled>
                      <?php foreach ($productSizes as $productSize) : ?>
                        <option value="<?= $productSize['id'] ?>" <?php if ($proAtt['id_size'] == $productSize['id']) : ?> selected <?php endif; ?>>
                          <?= $productSize['size'] ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>

                  <!-- Color -->
                  <div class="form-group col-lg-2">
                    <label class="form-label">Color</label>
                    <select class="form-control" name="validation-product-att-color-id" id="color_id" disabled>
                      <?php foreach ($productColors as $productColor) : ?>
                        <option value="<?= $productColor['id'] ?>" <?php if ($proAtt['id_color'] == $productColor['id']) : ?> selected <?php endif; ?>>
                          <?= $productColor['color'] ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>

                  <!-- Image -->
                  <div class="form-group col-lg-2">
                    <label class="form-label">Image</label>
                    <input type="hidden" name="oldImage" id="image" class="validation-file" value="<?= $proAtt['image'] ?>">
                    <input type="file" name="validation-product-att-image" id="image" class="validation-file">
                  </div>

                </div>
              </div>

              <div class="d-flex mt-5 justify-content-center align-item-center">
                <button type="submit" name="updateProAtt" class="btn btn-lg btn-primary">Update</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</main>

<!-- validation  -->
<script>
  $(function() {
    // Trigger validation on tagsinput change
    $("input[name=\"validation-bs-tagsinput\"]").on("itemAdded itemRemoved", function() {
      $(this).valid();
    });
    // Initialize validation
    $("#validation-form").validate({
      rules: {
        "validation-product-att-qty": {
          required: true
        },
        "validation-product-att-image": {
          extension: "jpg|jpeg|png",
          maxlength: 255
        },
        "validation-product-att-price": {
          required: true
        }
      },
      messages: {
        "validation-product-att-qty": {
          required: "Do not leave the name product blank."
        },
        "validation-product-att-image": {
          extension: "Please upload file in these format only (jpg, jpeg, png).",
          maxlength: "Your name image product is long"
        },
        "validation-product-att-price": {
          required: "Do not leave the price blank."
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
        // Select2 and Tagsinput
        if ($el.hasClass("select2-hidden-accessible") || $el.attr("data-role") === "tagsinput") {
          $el.parent().addClass("is-invalid");
        }
      },
      unhighlight: function(element) {
        $(element).parents(".form-group").find(".is-invalid").removeClass("is-invalid");
      },
    });

    // Pro ATT

  });
</script>


<!-- Show notification -->
<script>
  function showToast() {
    var title = "Product Attribute";
    var message = "Update product attribute success";
    var type = "success";

    toastr[type](message, title, {
      positionClass: 'toast-top-right',
      closeButton: 'checked',
      progressBar: 'checked',
      newestOnTop: 'checked',
      rtl: $('body').attr('dir') === 'rtl' || $('html').attr('dir') === 'rtl',
      timeOut: 5000,
    });
  }

  function showError(title, message, type) {
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