<div class="container-fluid shadow-sm sticky-top bg-light mb-2">
  <div class="row align-items-center py-3 px-xl-5">
    <!-- Logo -->
    <div class="col-lg-4 d-none d-lg-block">
      <a href="?act=home" class="text-decoration-none">
        <h1 class="m-0 display-5 font-weight-semi-bold">
          <span class="text-primary font-weight-bold border px-3 mr-1">TwentyFive</span> Fashion
        </h1>
      </a>
    </div>

    <!-- Nav -->
    <div class="col-lg-4 col-6 d-flex justify-content-center">
      <nav class="navbar navbar-expand-lg navbar-light py-3 0">
        <div class="navbar-nav text-center">
          <a href="?act=shop" class="nav-item nav-link">Shop</a>
          <a href="?act=contact" class="nav-item nav-link">Contact</a>
        </div>
      </nav>
    </div>

    <!-- Cart -->
    <div class="col-lg-4 col-6 d-flex flex-row justify-content-end">
      <!-- Total product -->
      <a href="?act=cart" class="btn border mr-1">
        <i class="fas fa-shopping-cart text-primary"></i>
        <span class="badge" id="totalProduct"></span>
      </a>
      <!-- Login -->
      <?php if (isset($_SESSION['user'])) : ?>
        <?php extract($_SESSION['user']) ?>
        <div class="dropdown show">
          <a class="btn border dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img height="30px" max-width="100%" class="rounded-circle mr-1" src="../uploads/<?= $image ?>" alt="">
            <?= $fullname ?>
          </a>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <a class="dropdown-item" href="?act=profile">
              Profile
            </a>
            <?php if ($role == 1) : ?>
              <a class="dropdown-item" href="../admin/?act=home">
                Admin
              </a>
            <?php endif; ?>
            <a class="dropdown-item" href="?act=signOut">Sign out</a>
          </div>
        </div>
      <?php else : ?>
        <a href="../login/signIn.php" class="btn border">
          <i class="far fa-user text-primary">
          </i>
        </a>
      <?php endif; ?>
      <!-- Check order -->
      <a href="?act=orderDetail" class="btn border ml-1">
        <i class="fas fa-calendar-week text-primary"></i>
      </a>

    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    showTotalProductCart();
  })

  function showTotalProductCart() {
    let total = localStorage.getItem("cartProductList");
    let totalCart = 0;
    if (total) {
      // Parse the cartList from JSON to an array
      total = JSON.parse(total);
      // Return the length of the cartList array
      totalCart = total.length;
    }
    $("#totalProduct").text(totalCart);
  }
</script>