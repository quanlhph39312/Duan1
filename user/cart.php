<div class="container-fluid pt-5">
  <div class="row px-xl-5">
    <div class="col-lg-8 table-responsive mb-5">
      <table class="table table-bordered text-center mb-0">
        <thead class="bg-secondary text-dark">
          <tr>
            <th>Products</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Remove</th>
          </tr>
        </thead>
        <tbody id="itemCarts" class="align-middle">
        </tbody>
      </table>
    </div>
    <div class="col-lg-4">
      <form class="mb-5" action="">
        <div class="input-group">
          <input type="text" class="form-control p-4" placeholder="Coupon Code" />
          <div class="input-group-append">
            <button class="btn btn-primary">Apply Coupon</button>
          </div>
        </div>
      </form>
      <div class="card border-secondary mb-5">
        <div class="card-header bg-secondary border-0">
          <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
        </div>
        <div class="card-body">
          <div class="d-flex justify-content-between mb-3 pt-1">
            <h6 class="font-weight-medium">Subtotal</h6>
            <h6 class="font-weight-medium" id="subTotal">$150</h6>
          </div>
          <div class="d-flex justify-content-between">
            <h6 class="font-weight-medium">Shipping</h6>
            <h6 class="font-weight-medium">$0</h6>
          </div>
        </div>
        <div class="card-footer border-secondary bg-transparent">
          <div class="d-flex justify-content-between mt-2">
            <h5 class="font-weight-bold">Total</h5>
            <h5 class="font-weight-bold" id="totalSummary">$160</h5>
          </div>
          <a href="?act=checkout" class="btn btn-block btn-primary my-3 py-3">
            Proceed To Checkout
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function showItemProductCart() {
    // Clear session storage
    let product;
    if (sessionStorage.getItem("product") == null) {
      product = [];
    } else {
      product = [];
      sessionStorage.removeItem("product");
    }

    let cartProductList;
    if (localStorage.getItem("cartProductList") == null) {
      cartProductList = [];
    } else {
      cartProductList = JSON.parse(localStorage.getItem("cartProductList"));
    }
    return JSON.stringify(cartProductList);
  }

  let carts = showItemProductCart();
  $.ajax({
    url: "cartDetail.php",
    type: "post",
    data: {
      carts: carts
    },
    success: function(data) {
      $("#itemCarts").empty();
      $("#itemCarts").append(data);
      totalAmount();
    },
    error: function() {
      console.error('Error sending data');
    }
  });


  function minusQuantity(index, price) {
    let quantity = $(`#quantityPro-${index}`).val();
    if (quantity > 1) {
      $(`#quantityPro-${index}`).val(Number(quantity) - 1)
      changePrice(index, price);
      totalAmount();
      updateLocalQuantity(index);
    }
  }

  function plusQuantity(index, price) {
    let quantity = $(`#quantityPro-${index}`).val();
    if (quantity < 5) {
      quantity = $(`#quantityPro-${index}`).val(Number(quantity) + 1);
      changePrice(index, price);
      totalAmount();
      updateLocalQuantity(index);
    }
  }

  function changePrice(index, price) {
    let quantity = $(`#quantityPro-${index}`).val();
    console.log("Price: " + quantity);
    let total = Number(price) * Number(quantity);
    $(`#totalAmount-${index}`).text('$' + Math.round(total * 100) / 100);
  }

  function removeItem(index) {
    var jsonData = localStorage.getItem('cartProductList');
    var dataArray = JSON.parse(jsonData);
    dataArray.splice(index - 1, 1);
    var updatedJsonData = JSON.stringify(dataArray);
    localStorage.setItem('cartProductList', updatedJsonData);
    $(`#item-${index}`).remove();
    showTotalProductCart();
    totalAmount();
  }

  function totalAmount() {
    let rows = document.querySelectorAll('#itemCarts tr');
    let totals = 0;
    for (let i = 0; i < rows.length; i++) {
      let total = $(`#totalAmount-${i+1}`).text();
      totals += Number(total.replace('$', ''));
    }
    totals = Math.round(100 * totals) / 100;
    $("#subTotal").text("$" + totals);
    $("#totalSummary").text("$" + totals);
  }

  function updateLocalQuantity(index) {
    let quantity = $(`#quantityPro-${index}`).val();
    var storedData = localStorage.getItem('cartProductList');
    var dataArray = JSON.parse(storedData);
    dataArray[index - 1].quantityPro = quantity;
    localStorage.setItem('cartProductList', JSON.stringify(dataArray));
  }
</script>