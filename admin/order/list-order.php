<main class="content">
  <div class="container-fluid p-0">

    <h1 class="h3 mb-3">List order</h1>

    <div class="row">
      <div class="col-12">
        <div class="card">

          <!-- Header -->
          <div class="card-header">
            <h5 class="card-title">Responsive Table</h5>
            <h6 class="card-subtitle text-muted">
              Highly flexible tool that many advanced features to any HTML table.
            </h6>
          </div>

          <!-- Data -->
          <div class="card-body">
            <table id="datatables-basic" class="table table-striped" style="width:100%">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Full name</th>
                  <th>Address</th>
                  <th>Phone</th>
                  <th>Email</th>
                  <th>Payment</th>
                  <th>Date order</th>
                  <th>Total amount</th>
                  <th>Order status</th>
                  <th>
                    <div class="text-center">
                      Action
                    </div>
                  </th>
                </tr>
              </thead>

              <tbody>
                <?php foreach ($orders as $key => $order) : ?>
                  <?php extract($order) ?>
                  <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= $fullname ?></td>
                    <td><?= $address ?></td>
                    <td><?= $phone ?></td>
                    <td><?= $email ?></td>
                    <td><?= $method ?></td>
                    <td><?= $added_on ?></td>
                    <td><?= $total_payment ?></td>
                    <td>
                      <?php if ($order_status == 0) : ?>
                        <span class="badge badge-warning">In progress</span>
                      <?php elseif ($order_status == -1) : ?>
                        <span class="badge badge-danger">Cancelled</span>
                      <?php elseif ($order_status == 1) : ?>
                        <span class="badge badge-success">Done</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <div class="d-flex justify-content-center">
                        <a href="?act=detailOrder&idOrder=<?= $id ?>" class="btn btn-primary">
                          Detail
                        </a>
                        <?php if ($order_status == 0) : ?>
                          <button type="button" class="btn btn-success confirmOrder ml-2" data-toggle="modal" data-target="#defaultModalConfirm" data-ds-id="<?= $id ?>">
                            Confirm
                          </button>

                          <button type="button" class="btn btn-danger refuseOrder ml-2" data-toggle="modal" data-target="#defaultModalRefuse" data-ds-id="<?= $id ?>">
                            Refuse
                          </button>
                        <?php endif; ?>
                      </div>
                    </td>
                  </tr>
                <?php endforeach;  ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>
</main>


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


<!-- Show notification -->
<script>
  function showToast(success) {
    var title = "Order";
    var message = `${success} order success`;
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

  function clearToast() {
    toastr.clear();
  }
</script>