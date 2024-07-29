<style>
  .cat-img{
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .img-flui{
    max-width: 100%;
    height: 270px;
    object-fit: contain;
  }
</style>
<!-- Categories Start -->
<!-- <div class="container-fluid pt-5">
  <div class="row px-xl-5 pb-3">
    <?php foreach($categories as $all) :?>
      <?php extract($all) ?>
    <div class="col-lg-4 col-md-6 pb-1">
      <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px">
        <p class="text-right"><?=productCountByCategory($id)?> Products</p>
        <a href="?act=shop&idCategory=<?=$id?>" class="cat-img position-relative overflow-hidden mb-3">
          <img class="img-flui" src="../uploads/<?=$image?>" alt="" />
        </a>
        <h5 class="font-weight-semi-bold m-0"><?=$name?></h5>
      </div>
    </div>
    <?php endforeach ?>
  </div>
</div> -->
<!-- Categories End -->
  
<!-- Products Start -->
<div class="container-fluid py-5">
  <div class="text-center mb-4">
    <h2 class="section-title px-5">
      <span class="px-2">Category</span>
    </h2>
  </div>
  <div class="row px-xl-5 ">
    <!-- Realted Products -->
    <div class="col">
      <div class="owl-carousel related-carousel">
      <?php foreach($categories as $all) :?>
      <?php extract($all) ?>
        <div class="card product-item border-1">
          <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
          <p class="text-right mr-3 mt-2"><?=productCountByCategory($id)?> Products</p>
          <a href="?act=shop&idCategory=<?=$id?>" class="cat-img position-relative overflow-hidden mb-3"> 
           <img class="img-flui w-100" src="../uploads/<?=$image?>" alt="" />
          </a>
          </div>
          <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
          <h5 class="font-weight-semi-bold m-0"><?=$name?></h5>
            <div class="d-flex justify-content-center">
            </div>
          </div>
        </div>
        <?php endforeach ?>
      </div>
    </div>
  </div>
</div>
<!-- Products End -->