<main class="content">
  <div class="container-fluid p-5">

    <h1 class="h3 mb-3">List order</h1>

    <div class="row">
      <div class="col-12">
        <div class="card">
          <!-- Data -->
          <div class="card-body">
            <table id="datatables-basic" class="table table-striped" style="width:100%">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Order ID</th>
                  <th>Phone</th>
                  <th>Address</th>
                  <th>Payment</th>
                  <th>Total amount</th>
                  <th>Date order</th>
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
                    <td><?= $order_id ?></td>
                    <td><?= $phone ?></td>
                    <td><?= $address ?></td>
                    <td><?= $payment_method ?></td>
                    <td>
                      <?php $date = strtotime($added_on);
                      echo date('d-m-Y H:i:s', $date); ?>
                    </td>
                    <td><?= $total_payment ?></td>
                    <td>
                      <?php if ($order_status == 0) : ?>
                        <span class="badge badge-warning rounded text-white">In progress</span>
                      <?php elseif ($order_status == -1) : ?>
                        <span class="badge badge-danger rounded">Cancelled</span>
                      <?php elseif ($order_status == 1) : ?>
                        <span class="badge badge-success rounded">Done</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <div class="d-flex justify-content-center">
                        <a href="?act=detailOrder&idOrder=<?= $order_id ?>" class="btn btn-primary rounded text-white">
                          Detail
                        </a>
                        <?php if ($order_status == 0) : ?>
                          <button type="button" class="btn btn-danger refuseOrder ml-2" data-toggle="modal" data-target="#defaultModalRefuse" data-ds-id="<?= $order_id ?>">
                            Cancel
                          </button>
                          </a>
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