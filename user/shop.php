<style>
  .product-img img {
    max-width: 100%;
    height: 300px;
    object-fit: contain;
  }
</style>
<!-- Shop Start -->
<div class="container-fluid pt-5">
  <div class="row px-xl-5">
    <!-- Shop Sidebar Start -->
    <div class="col-lg-3 col-md-12">
      <!-- Filter by category Start -->
      <div class="border-bottom mb-4">
        <h5 class="font-weight-semi-bold mb-4">Filter by category</h5>
        <?php foreach ($categories as $category) : ?>
          <?php extract($category) ?>
          <div class="d-flex align-items-center justify-content-between mb-3">
            <a href="?act=shop&idCategory=<?= $id ?>" class="btn p-0"><?= $name ?></a>
            <span class="badge border font-weight-normal">
              <?= productCountByCategory($id) ?>
            </span>
          </div>
        <?php endforeach; ?>
      </div>
      <!-- Filter by category End -->

    </div>
    <!-- Shop Sidebar End -->

    <!-- Shop Product Start -->
    <div class="col-lg-9 col-md-12">
      <div class="row pb-3">
        <!-- Search & sort -->
        <div class="col-12 pb-1">
          <div class="d-flex align-items-center justify-content-between mb-4">
            <!-- Search -->
            <form action="?act=shop" method="post">
              <div class="input-group">
                <input type="text" name="searchProduct" class="form-control" placeholder="Search by name" />
                <div class="input-group-append">
                  <button name="searchByName" class="input-group-text bg-transparent text-primary">
                    <i class="fa fa-search"></i>
                  </button>
                </div>
              </div>
            </form>
            <!-- Sort -->
            <div class="dropdown ml-4">
              <button class="btn border dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Sort by
              </button>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                <a class="dropdown-item" href="?act=shop&sortPrice=Asc">Ascending</a>
                <a class="dropdown-item" href="?act=shop&sortPrice=Desc">Descending</a>

              </div>
            </div>
          </div>
        </div>

        <!-- Product -->
        <?php foreach ($products as $product) : ?>
          <?php extract($product) ?>
          <div class="col-lg-4 col-md-6 col-sm-12 pb-1">
            <div class="card product-item border-0 mb-4">
              <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                <img class="img-fluid w-100" src="../uploads/<?= $image ?>" alt="" />
              </div>
              <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                <h6 class="text-truncate mb-3"><?= $name ?></h6>
                <h6>$<?= $price ?></h6>
              </div>
              <div class="card-footer d-flex justify-content-center bg-light border">
                <a href="?act=detail&idProduct=<?= $id ?>" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                <!-- <a href="?act=addToCart" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To
                  Cart</a> -->
              </div>
            </div>
          </div>
        <?php endforeach; ?>

        <?php if (isset($_GET['idCategory'])) : ?>
          <!-- Padding -->
          <div class="col-12 pb-1">
            <nav aria-label="Page navigation">
              <ul class="pagination justify-content-center mb-3">
                <?php if ($currentPage < $totalPage + 1) : ?>
                  <li class="page-item">
                    <a class="page-link" href="?act=shop&idCategory=<?= $_GET['idCategory'] ?>&perPage=<?= $itemPerPage ?>&Page=<?= $currentPage - 1 ?>" aria-label="Previous">
                      <span aria-hidden="true">&laquo;</span>
                      <!-- <span class="sr-only">Previous</span> -->
                    </a>
                  </li>
                <?php endif ?>
                <?php for ($num = 1; $num <= $totalPage; $num++) : ?>
                  <?php if ($num == $currentPage) { ?>
                    <li class="page-item active">
                      <a class="page-link" href="?act=shop&idCategory=<?= $_GET['idCategory'] ?>&perPage=<?= $itemPerPage ?>&Page=<?= $num ?>"><?= $num ?></a>
                    </li>
                  <?php } else { ?>
                    <?php if ($num > $currentPage - 3 && $num < $currentPage + 3) : ?>
                      <li class="page-item"><a class="page-link" href="?act=shop&idCategory=<?= $_GET['idCategory'] ?>&perPage=<?= $itemPerPage ?>&Page=<?= $num ?>"><?= $num ?></a></li>
                    <?php endif ?>
                  <?php } ?>
                <?php endfor ?>

                <?php if ($totalPage > $currentPage) : ?>
                  <li class="page-item">
                    <a class="page-link" href="?act=shop&idCategory=<?= $_GET['idCategory'] ?>&perPage=<?= $itemPerPage ?>&Page=<?= $currentPage + 1 ?>" aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                      <span class="sr-only">Next</span>
                    </a>
                  </li>
                <?php endif ?>
              </ul>
            </nav>
          </div>

        <?php else : ?>

          <div class="col-12 pb-1">
            <nav aria-label="Page navigation">
              <ul class="pagination justify-content-center mb-3">
                <?php if ($currentPage < $totalPage + 1) : ?>
                  <li class="page-item">
                    <a class="page-link" href="?act=shop&perPage=<?= $itemPerPage ?>&Page=<?= $currentPage - 1 ?>" aria-label="Previous">
                      <span aria-hidden="true">&laquo;</span>
                      <!-- <span class="sr-only">Previous</span> -->
                    </a>
                  </li>
                <?php endif ?>

                <?php for ($num = 1; $num <= $totalPage; $num++) : ?>
                  <?php if ($num == $currentPage) { ?>
                    <li class="page-item active">
                      <a class="page-link" href="?act=shop&perPage=<?= $itemPerPage ?>&Page=<?= $num ?>"><?= $num ?></a>
                    </li>
                  <?php } else { ?>
                    <?php if ($num > $currentPage - 3 && $num < $currentPage + 3) : ?>
                      <li class="page-item"><a class="page-link" href="?act=shop&perPage=<?= $itemPerPage ?>&Page=<?= $num ?>"><?= $num ?></a></li>
                    <?php endif ?>
                  <?php } ?>
                <?php endfor ?>

                <?php if ($totalPage > $currentPage) : ?>
                  <li class="page-item">
                    <a class="page-link" href="?act=shop&perPage=<?= $itemPerPage ?>&Page=<?= $currentPage + 1 ?>" aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                      <span class="sr-only">Next</span>
                    </a>
                  </li>
                <?php endif ?>
              </ul>
            </nav>
          </div>
        <?php endif ?>

      </div>
    </div>
    <!-- Shop Product End -->
  </div>
</div>
<!-- Shop End -->