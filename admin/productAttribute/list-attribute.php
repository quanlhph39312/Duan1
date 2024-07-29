<main class="content">
  <div class="container-fluid p-0">

    <h1 class="h3 mb-3">Product Attributes</h1>

    <div class="row">
      <div class="col-12">
        <div class="card">

          <!-- Header -->
          <div class="card-header d-flex ">
            <div>
              <h5 class="card-title">Responsive Table</h5>
              <h6 class="card-subtitle text-muted">
                Highly flexible tool that many advanced features to any HTML table.
              </h6>
            </div>
            <div class="ml-auto">
              <a href="?act=listProduct" class="btn btn-secondary">
                List Product
              </a>
              <a href="?act=addProductAttribute&idProduct=<?= $_GET['idProduct'] ?>" class="btn btn-primary ml-2">
                Add Attribute
              </a>
            </div>
          </div>

          <!-- Data -->
          <div class="card-body">
            <table id="datatables-basic" class="table table-striped" style="width:100%">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Size</th>
                  <th>Color</th>
                  <th>Image</th>
                  <th>Sold</th>
                  <th>Quantity</th>
                  <th>Price</th>
                  <th>Status</th>
                  <th>
                    <div class="text-center">Action</div>
                  </th>
                </tr>
              </thead>

              <tbody>
                <input type="hidden" id="idProduct" value="<?= $_GET['idProduct'] ?>">
                <?php foreach ($productAttributes as  $key => $productAttribute) : ?>
                  <?php extract($productAttribute) ?>
                  <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= $size ?></td>
                    <td><?= $color ?></td>
                    <td>
                      <img src="../uploads/<?= $image ?>" alt="..image" width="100px" height="100px">
                    </td>
                    <td><?= $sold ?></td>
                    <td><?= $quantity ?></td>
                    <td><?= $price ?></td>
                    <td><?= $status == 0 ? 'Show' : 'Hidden' ?></td>
                    <td>
                      <div class="d-flex flex-row align-item-center justify-content-center">
                        <a href="?act=updateProductAttribute&idProductAttribute=<?= $id ?>&idProduct=<?= $_GET['idProduct'] ?>" class="btn btn-warning ">
                          Update
                        </a>
                        <button type="button" class="btn btn-danger deleteProduct ml-2" data-toggle="modal" data-target="#defaultModalDanger" data-ds-id="<?= $id ?>" data-ds-status="<?= $status ?>">
                          <?= $status == 0 ? "Delete" : "Restore" ?>
                        </button>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
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
      responsive: true,
      lengthMenu: [5, 10, 20],
    });
  });
</script>

<!-- Confirm delete -->
<div class="modal fade" id="defaultModalDanger" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Product Attribute</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body m-3">
        <p class="mb-0" id="confirmation-message"></p>
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
  var idPro = $("#idProduct").val();
  $('.deleteProduct').on('click', function() {
    var id = $(this).data('ds-id');
    var status = $(this).data('ds-status');
    var action = (status == 0) ? "delete" : "restore";
    var confirmationMessage = `Do you want to ${action} product attribute?`;
    var link = `?act=deleteProductAttribute&idProductAttribute=${id}&idProduct=${idPro}`

    $('#confirmation-message').text(confirmationMessage);
    document.getElementById("btn-delete").setAttribute("href", link)
  });
</script>


<!-- Show notification -->
<script>
  function showToast(success) {
    var title = "Product Attribute";
    var message = `${success} product attribute success`;
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