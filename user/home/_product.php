<!-- Products Start -->
<div class="container-fluid pt-5">
  <!-- Title -->
  <div class="text-center mb-4">
    <h2 class="section-title px-5">
      <span class="px-2">Best Selling Product</span>
    </h2>
  </div>

  <div class="row px-xl-5 pb-3">
    <!-- Product -->
    <?php foreach ($products as $all) : ?>
      <?php extract($all) ?>
      <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
        <div class="card product-item border-0 mb-4">
          <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
            <p class="text-right mr-3 mt-3">Sold <?= $total_sold ?></p>
            <img class="img-flui w-100" src="../uploads/<?= $image ?>" alt="" />
          </div>
          <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
            <h6 class="text-truncate mb-3"><?= $name ?></h6>
            <div class="d-flex justify-content-center">
              <h6><?= $price ?></h6>
            </div>
          </div>
          <div class="card-footer d-flex justify-content-center bg-light border">
            <a href="?act=detail&idProduct=<?= $id ?>" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
            <!-- <a href="?act=addToCart" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To
            Cart</a> -->
          </div>
        </div>
      </div>
    <?php endforeach ?>

  </div>

  <!-- Title -->
  <div class="text-center mb-4">
    <h2 class="section-title px-5">
      <span class="px-2">New Products</span>
    </h2>
  </div>

  <div class="row px-xl-5 pb-3">
    <!-- Product -->
    <?php foreach ($productsNew as $all) : ?>
      <?php extract($all) ?>
      <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
        <div class="card product-item border-0 mb-4">
          <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
            <img class="img-flui w-100" src="../uploads/<?= $image ?>" alt="" />
          </div>
          <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
            <h6 class="text-truncate mb-3"><?= $name ?></h6>
            <div class="d-flex justify-content-center">
              <h6><?= $price ?></h6>
            </div>
          </div>
          <div class="card-footer d-flex justify-content-center bg-light border">
            <a href="?act=detail&idProduct=<?= $id ?>" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
          </div>
        </div>
      </div>
    <?php endforeach ?>

  </div>




</div>
<!-- Products End -->