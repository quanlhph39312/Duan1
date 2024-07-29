<div class="container-fluid p-5">

  <h1 class="h3 mb-3">Detail order</h1>

  <div class="row">
    <div class="col-12">
      <div class="card">

        <!-- Header -->
        <div class="card-header d-flex ">
          <div>
            <h5 class="card-title">Detail order</h5>
          </div>
          <div class="ml-auto">
            <a href="?act=orderDetail" class="btn btn-primary rounded">List order</a>
          </div>
        </div>

        <!-- Data -->
        <div class="card-body">
          <table id="datatables-basic" class="table table-striped" style="width:100%">
            <thead>
              <tr>
                <th>ID</th>
                <th>Product name</th>
                <th>Size</th>
                <th>Color</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
              </tr>
            </thead>

            <tbody>
              <?php foreach ($orderDetails as $key => $orderDetail) : ?>
                <?php extract($orderDetail) ?>
                <tr>
                  <td><?= $key + 1 ?></td>
                  <td><?= $name ?></td>
                  <td><?= $size ?></td>
                  <td><?= $color ?></td>
                  <td><?= $price ?></td>
                  <td><?= $quantity ?></td>
                  <td><?= $price * $quantity ?></td>
                </tr>
            <?php endforeach; ?>

            </tbody>
          </table>

          <!-- Confirm or refuse -->
          <?php if ($order_status == 0) : ?>
            <div class="d-flex justify-content-center mt-5">
              <button type="button" class="btn btn-danger refuseOrder ml-2 rounded" data-toggle="modal" data-target="#defaultModalRefuse" data-ds-id="<?= $_GET['idOrder'] ?>">
                Refuse
              </button>
            </div>
          <?php endif; ?>
        </div>


      </div>
    </div>
  </div>

</div>



<script>
  $(function() {
    // Datatables basic
    $("#datatables-basic").DataTable({
      responsive: true
    });
  });
</script>


<!-- Confirm order -->
<div class="modal fade" id="defaultModalConfirm" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Order</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body m-3">
        <p class="mb-0">
          Do you want to confirm order ?
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          Close
        </button>
        <a href="" class="btn btn-danger" id="btn-success">
          Confirm
        </a>
      </div>
    </div>
  </div>
</div>
<script>
  $('.confirmOrder').on('click', function() {
    var id = $(this).data('ds-id');
    console.log(id);
    var link = `?act=confirmOrder&idOrder=${id}`
    document.getElementById("btn-success").setAttribute("href", link)
  });
</script>

<!-- Refuse order -->
<div class="modal fade" id="defaultModalRefuse" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Order</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body m-3">
        <p class="mb-0">
          Do you want to refuse order ?
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          Close
        </button>
        <a href="" class="btn btn-danger" id="btn-delete">
          Confirm
        </a>
      </div>
    </div>
  </div>
</div>
<script>
  $('.refuseOrder').on('click', function() {
    var id = $(this).data('ds-id');
    console.log(id);
    var link = `?act=refuseOrder&idOrder=${id}`
    document.getElementById("btn-delete").setAttribute("href", link)
  });
</script>