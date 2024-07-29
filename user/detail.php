<!-- Shop Detail Start -->
<div class="container-fluid py-5">
  <div class="row px-xl-5 px-5">
    <div class="col-lg-4 pb-5">
      <!-- List img -->
      <div id="product-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner border">
          <?php foreach ($imageProducts as $key => $imageProduct) : ?>
            <?php extract($imageProduct) ?>
            <?php if ($key == 0) : ?>
              <div id="imageActive" class="carousel-item active">
                <img class="w-100 h-100" src="../uploads/<?= $image ?>" alt="Image" id="imageColor" />
              </div>
            <?php else : ?>
              <div class="carousel-item">
                <img class="w-100 h-100" src="../uploads/<?= $image ?>" alt="Image" />
              </div>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
        <a id="carousel-prev" class="carousel-control-prev" href="#product-carousel" data-slide="prev">
          <i class="fa fa-2x fa-angle-left text-dark"></i>
        </a>
        <a id="carousel-next" class="carousel-control-next" href="#product-carousel" data-slide="next">
          <i class="fa fa-2x fa-angle-right text-dark"></i>
        </a>
      </div>
    </div>

    <!-- Product information -->
    <?php extract($product) ?>
    <div class="col-lg-8 pb-5">
      <?php if (isset($_GET['idProduct'])) : ?>
        <input id="idProduct" name="idProduct" type="hidden" value="<?= $_GET['idProduct'] ?>">
      <?php endif ?>
      <h3 class="font-weight-semi-bold"><?= $name ?></h3>
      <div class="d-flex mb-3">
        <div class="text-primary mr-2">
          <small class="fas fa-star"></small>
          <small class="fas fa-star"></small>
          <small class="fas fa-star"></small>
          <small class="fas fa-star-half-alt"></small>
          <small class="far fa-star"></small>
        </div>
        <small class="pt-1">(<?= commentGetCountForProduct($id) ?> Reviews)</small>
      </div>
      <h3 id="priceSize" class="font-weight-semi-bold mb-4">$<?= $price ?></h3>

      <!-- Size -->
      <div class="d-flex mb-3 form-group">
        <p class="text-dark font-weight-medium mb-0 mr-3">Sizes:</p>
        <?php foreach ($sizes as $key => $size) : ?>
          <?php extract($size) ?>
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" class="custom-control-input" id="size-<?= $key + 1 ?>" name="idProductSize" onclick="changeColor()" value="<?= $id_size ?>" required />
            <label class="custom-control-label" for="size-<?= $key + 1 ?>"><?= $name_size ?></label>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Color -->
      <div class="d-flex mb-4">
        <p class="text-dark font-weight-medium mb-0 mr-3">Colors:</p>
        <div id="itemColors">
          <?php foreach ($colors as $key => $color) : ?>
            <?php extract($color) ?>
            <div class="custom-control custom-radio custom-control-inline">
              <input onclick="changeImage('<?= productAttGetImage($id_pro, $id_color)['image'] ?>')" type="radio" class="custom-control-input" id="color-<?= $key + 1 ?>" name="idProductColor" value="<?= $id_color ?>" <?= $key == 0 ? 'checked' : '' ?>required />
              <label class="custom-control-label" for="color-<?= $key + 1 ?>"><?= $name_color ?></label>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div id="validation-size-color">
      </div>
      <div id="quantityProAtt"></div>

      <!-- Add to cart -->
      <div class="d-flex align-items-center mb-4 pt-2">
        <!-- Quantity -->
        <div class="input-group quantity mr-3" style="width: 130px">
          <div class="input-group-btn">
            <button type="button" class="btn btn-primary btn-minus">
              <i class="fa fa-minus"></i>
            </button>
          </div>
          <input type="text" id="quantityPro" class="form-control bg-secondary text-center" value="1" />
          <div class="input-group-btn">
            <button type="button" class="btn btn-primary btn-plus">
              <i class="fa fa-plus"></i>
            </button>
          </div>
        </div>

        <!-- Buy -->
        <div class="mr-3">
          <a name="buyNow" class="btn btn-primary px-3" onclick="buyNow()">
            <i class="fa fa-shopping-bag mr-1"></i> Buy now
          </a>
        </div>

        <!-- Add -->
        <div>
          <a id="addToCart" class="btn btn-primary px-3" onclick="addToCart()">
            <i class="fa fa-shopping-cart mr-1"></i>Add to cart
          </a>
        </div>
      </div>


      <!-- Share -->
      <div class="d-flex pt-2">
        <p class="text-dark font-weight-medium mb-0 mr-2">Share on:</p>
        <div class="d-inline-flex">
          <a class="text-dark px-2" href="">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a class="text-dark px-2" href="">
            <i class="fab fa-twitter"></i>
          </a>
          <a class="text-dark px-2" href="">
            <i class="fab fa-linkedin-in"></i>
          </a>
          <a class="text-dark px-2" href="">
            <i class="fab fa-pinterest"></i>
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Description & Review -->
  <div class="row px-xl-5">
    <div class="col">
      <div class="nav nav-tabs justify-content-center border-secondary mb-4">
        <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Description</a>
        <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Reviews (<?= commentGetCountForProduct($id) ?>)</a>
      </div>
      <div class="tab-content">

        <!-- Description -->
        <div class="tab-pane fade show active" id="tab-pane-1">
          <h4 class="mb-3">Product Description</h4>
          <p>
            <?= $description ?>
          </p>
        </div>

        <!-- Review -->
        <div class="tab-pane fade" id="tab-pane-3">
          <div class="row">
            <!-- List comment -->
            <div class="col-md-6">
              <h4 class="mb-4"><?= commentGetCountForProduct($id) ?> review for "<?= $name ?>"</h4>
              <?php foreach ($comments as $comment) : ?>
                <?php extract($comment) ?>
                <div class="media mb-4">
                  <img src="../uploads/<?= $image ?>" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px" />
                  <div class="media-body">
                    <h6>
                      <?= $fullname ?><small> - <i><?php $date = strtotime($added_on);
                                                    echo date('d-m-Y H:i:s', $date); ?></i></small>
                    </h6>
                    <p>
                      <?= $content ?>
                    </p>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>

            <!-- Comment -->
            <?php if (isset($_SESSION['user'])) : ?>
              <div class="col-md-6">
                <h4 class="mb-4">Leave a review</h4>
                <small>Your email address will not be published. Required fields are
                  marked *</small>
                <!-- <div class="d-flex my-3">
                <p class="mb-0 mr-2">Your Rating * :</p>
                <div class="text-primary">
                  <i class="far fa-star"></i>
                  <i class="far fa-star"></i>
                  <i class="far fa-star"></i>
                  <i class="far fa-star"></i>
                  <i class="far fa-star"></i>
                </div>
              </div> -->
                <form method="post">
                  <div class="form-group">
                    <label for="message">Your Review *</label>
                    <textarea id="message" cols="30" rows="5" name="content" class="form-control"></textarea>
                  </div>
                  <div class="form-group mb-0">
                    <input type="submit" name="submit" value="Leave Your Review" class="btn btn-primary px-3" />
                  </div>
                </form>
              </div>
            <?php else : ?>
              <div class="col-md-6">
                <h4 class="mb-4">Leave a review</h4>
                <small style="color: red;">Please log in to be able to comment </small>
              </div>
            <?php endif ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Shop Detail End -->

<!-- Products Start -->
<div class="container-fluid py-5">
  <div class="text-center mb-4">
    <h2 class="section-title px-5">
      <span class="px-2">You May Also Like</span>
    </h2>
  </div>
  <div class="row px-xl-5">
    <!-- Realted Products -->
    <div class="col">
      <div class="owl-carousel related-carousel">
        <?php foreach ($products as $all) : ?>
          <?php extract($all) ?>
          <div class="card product-item border-0">
            <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
              <img class="img-fluid w-100" src="../uploads/<?= $image ?>" alt="" />
            </div>
            <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
              <h6 class="text-truncate mb-3"><?= $name ?></h6>
              <div class="d-flex justify-content-center">
                <h6><?= $price ?></h6>
              </div>
            </div>
            <div class="card-footer d-flex justify-content-center bg-light border">
              <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
              <!-- <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To
              Cart</a> -->
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>
<!-- Products End -->


<script>
  // Slide show img
  $(document).ready(function() {
    $("#carousel-prev").on('click', function() {
      $('#product-carousel').carousel('cycle');
    });

    $("#carousel-next").on('click', function() {
      $('#product-carousel').carousel('cycle');
    });
  })

  function changeColor() {
    let idPro = $("#idProduct").val();
    let idSize = $('input[name="idProductSize"]:checked').val();
    let idColor = $('input[name="idProductColor"]:checked').val();
    $("#validation-size-color").empty();
    // Check color exits
    $.ajax({
      type: "post",
      url: "detailCall.php",
      dataType: 'json',
      data: {
        functionname: 'getAllColorBySize',
        arguments: [idPro, idSize]
      },
      success: function(obj, textStatus) {
        if (!('error' in obj)) {
          let colors = obj.result;
          $("#itemColors").empty();
          for (let i = 0; i < colors['color'].length; i++) {
            let html = `<div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" id="color-${i}" name="idProductColor" value="${colors['id'][i]}" onclick="changePriceAndImage()" />
                          <label class="custom-control-label" for="color-${i}">${colors['color'][i]}</label>
                        </div>`
            $("#itemColors").append(html);
          }
        } else {
          console.log(obj.errol);
        }
      },
      error: function(error) {
        console.error(error);
        console.error('Error sending data');
      }
    });
  }

  function changePriceAndImage() {
    let idPro = $("#idProduct").val();
    let idSize = $('input[name="idProductSize"]:checked').val();
    let idColor = $('input[name="idProductColor"]:checked').val();
    $("#validation-size-color").empty();
    if (idSize, idColor) {
      $.ajax({
        type: "post",
        url: "detailCall.php",
        dataType: 'json',
        data: {
          functionname: 'getAllPriceAndImageByIdPro',
          arguments: [idPro, idSize, idColor]
        },
        success: function(obj, textStatus) {
          if (!('error' in obj)) {
            let price = obj['result']['price'];
            let image = obj['result']['image'];
            let quantity = obj['result']['quantity'];
            changePrice(price);
            changeImage(image);
            $("#quantityProAtt").text("Have : " + quantity + " products");
          } else {
            console.log("Arrays is undefined :  " + obj.errol);
          }
        },
        error: function(error) {
          console.error('Error sending data');
        }
      });
    }
  }

  function changePrice(price) {
    $("#priceSize").text(`$${price}`);
  }

  function changeImage(image) {
    $('#product-carousel').carousel('pause');
    $('#product-carousel').find('.carousel-item.active img').attr('src', `../uploads/${image}`);
  }

  function addToCart() {
    let idPro = $("#idProduct").val();
    let idSize = $('input[name="idProductSize"]:checked').val();
    let idColor = $('input[name="idProductColor"]:checked').val();
    let quantityPro = $("#quantityPro").val();

    // Check size, color
    let isExits = validationSizeColor(idSize, idColor);
    if (isExits === 1) {
      return;
    }

    // Get in local storage
    let cartList;
    if (localStorage.getItem("cartProductList") == null) {
      cartList = [];
    } else {
      cartList = JSON.parse(localStorage.getItem("cartProductList"));
    }

    // Check if the item already exists in the cart
    let existingItem = cartList.find(item => item.idPro === idPro && item.idSize === idSize && item.idColor === idColor);

    if (existingItem) {
      let newQuantity = parseInt(existingItem.quantityPro) + parseInt(quantityPro);

      // Check if quantity pro > 5
      if (newQuantity > 5) {
        alert("Quantity cannot exceed 5!");
        return;
      }
      // Update quantity
      existingItem.quantityPro = newQuantity;
    } else {
      // Add to array
      cartList.push({
        idPro: idPro,
        idSize: idSize,
        idColor: idColor,
        quantityPro: quantityPro
      });
    }

    // Add to local storage
    localStorage.setItem("cartProductList", JSON.stringify(cartList));
    showTotalProductCart();
  }

  function buyNow() {
    let idPro = $("#idProduct").val();
    let idSize = $('input[name="idProductSize"]:checked').val();
    let idColor = $('input[name="idProductColor"]:checked').val();
    let quantityPro = $("#quantityPro").val();
    // Check size, color
    let isExits = validationSizeColor(idSize, idColor);
    if (isExits === 1) {
      return;
    }
    // Get in session storage
    let product;
    if (sessionStorage.getItem("product") == null) {
      product = [];
    } else {
      product = [];
      sessionStorage.removeItem("product");
    }

    // Add to array
    product.push({
      idPro: idPro,
      idSize: idSize,
      idColor: idColor,
      quantityPro: quantityPro
    });
    // Add to session storage
    sessionStorage.setItem("product", JSON.stringify(product));
    window.location.href = "http://localhost/DuAn1-2023/user/?act=checkout&buynow";
  }

  function validationSizeColor(idSize, idColor) {
    if (!idSize || !idColor) {
      $("#validation-size-color").empty();
      let html = `<p class="text-danger">Please choose size or color</p>`;
      $("#validation-size-color").append(html);
      return 1;
    }
    return 0;
  }
</script>