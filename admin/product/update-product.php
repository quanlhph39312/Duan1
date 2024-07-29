<main class="content">
  <div class="container-fluid p-0">
    <h1 class="h3 mb-3">Update product</h1>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title mb-0">Product</h5>
          </div>
          <div class="d-flex justify-content-center align-items-end">
            <a href="?act=listProduct" class="btn btn-primary ml-auto mr-5">
              <span id="payment-button-amount" class="text-white">List Product</span>
            </a>
          </div>
          <div class="card-body">
            <form id="validation-form" method="post" enctype="multipart/form-data">
              <input type="hidden" value="<?= $product['id'] ?>" name="idProduct">
              <div class="form-group">
                <label class="form-label">Name product</label>
                <input type="text" class="form-control" name="validation-product-name" placeholder="Name product" value="<?= $product['name'] ?>">
                <input type="hidden" class="form-control" name="oldName" placeholder="Name product" value="<?= $product['name'] ?>">
              </div>

              <div class="form-group">
                <label class="form-label">Category</label>
                <select class="form-control" name="validation-product-select">
                  <?php foreach ($categories as $category) : ?>
                    <?php extract($category) ?>
                    <option value="<?= $id ?>" <?= $product['id_cate'] == $id ? 'selected' : '' ?>><?= $name ?></option>
                  <?php endforeach ?>

                </select>
              </div>

              <div class="form-group">
                <label class="form-label">Image</label>
                <div>
                  <input type="hidden" name="oldImage" value="<?= $product['image'] ?>">
                  <input type="file" class="validation-file" name="validation-product-file">
                </div>
              </div>

              <div class="form-group">
                <label class="form-label">Price</label>
                <input type="number" class="price form-control" name="validation-product-price" placeholder="Price" value="<?= $product['price'] ?>">
              </div>

              <div class="form-group">
                <label class="form-label">Description</label>
                <textarea class="form-control" name="validation-product-description"><?= $product['description'] ?></textarea>
              </div>

              <div class="d-flex mt-5 justify-content-center align-item-center">
                <button type="submit" class="btn btn-lg btn-primary" id="toastr-show" name="updateProduct">
                  Update Product
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</main>

<!-- Validation -->
<script>
  $(function() {
    // addValidationRules();
    // Trigger validation on tagsinput change
    $("input[name=\"validation-bs-tagsinput\"]").on("itemAdded itemRemoved", function() {
      $(this).valid();
    });
    // Initialize validation
    $("#validation-form").validate({
      rules: {
        "validation-product-name": {
          required: true,
          maxlength: 50
        },
        "validation-product-price": {
          required: true
        },
        "validation-category-file": {
          extension: "jpg|jpeg|png",
          maxlength: true
        },
        "validation-product-description": {
          required: true
        }
      },
      messages: {
        "validation-product-name": {
          required: "Do not leave the name product blank.",
          maxlength: "Your name product is long"
        },
        "validation-product-price": {
          required: "Do not leave the price blank."
        },
        "validation-product-description": {
          required: "Do not leave the description blank."
        },
        "validation-category-file": {
          extension: "Please upload file in these format only (jpg, jpeg, png).",
          maxlength: "Your name image is long"
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
      }
    });

  });
</script>

<!-- Show notification -->
<script>
  // Toastr
  function showToast() {
    var title = "Product";
    var message = "Update product success";
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