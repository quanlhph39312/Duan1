<main class="content">
  <div class="container-fluid p-0">

    <h1 class="h3 mb-3">List Product</h1>

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
              <a href="?act=addProduct" class="btn btn-primary">Add product</a>
            </div>
          </div>

          <!-- Data -->
          <div class="card-body">
            <table id="datatables-basic" class="table table-striped" style="width:100%">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Product name</th>
                  <th>Category name</th>
                  <th>Image</th>
                  <th>Price</th>
                  <th>Description</th>
                  <th>Create Date</th>
                  <th>Status</th>
                  <th>
                    <div class="text-center">Action</div>
                  </th>
                </tr>
              </thead>

              <tbody>
                <?php foreach ($products as $key => $product) : ?>
                  <?php extract($product) ?>
                  <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= $pro_name ?></td>
                    <td><?= $cate_name ?></td>
                    <td>
                      <img src="../uploads/<?= $image ?>" alt="...image cate" height="100px" width="100px">
                    </td>
                    <td><?= $price ?></td>
                    <td>
                      <textarea class="form-control border-none" id="exampleFormControlTextarea1" disabled cols="30" rows="3"><?= $description ?></textarea>
                    </td>
                    <td>
                      <?php
                      $date = strtotime($added_on);
                      echo date('d/m/Y', $date);
                      ?>
                    </td>
                    <td><?= $status == 0 ? 'Show' : 'Hidden' ?></td>
                    <td>
                      <div class="text-center d-flex flex-row">
                        <a href="?act=attributeProduct&idProduct=<?= $pro_id ?>" class="btn btn-secondary ml-2">
                          Attributes
                        </a>
                        <a href="?act=updateProduct&idProduct=<?= $pro_id ?>" class="btn btn-warning ml-2">
                          Update
                        </a>
                        <button type="button" class="btn btn-danger deleteProduct ml-2" data-toggle="modal" data-target="#defaultModalDanger" data-ds-id="<?= $pro_id ?>" data-ds-name="<?= $pro_name ?>" data-ds-status="<?= $status ?>">
                          <?= ($status == 0) ? "Delete" : "Restore" ?>
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

<!-- Datatable -->
<script>
  $(function() {
    // Datatables basic
    $("#datatables-basic").DataTable({
      responsive: true,
      lengthMenu: [10, 15, 20],
    });
  });
</script>

<!-- Confirm delete -->
<div class="modal fade" id="defaultModalDanger" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Product</h5>
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
  $('.deleteProduct').on('click', function() {
    var id = $(this).data('ds-id');
    console.log(id);
    var name = $(this).data('ds-name');
    var status = $(this).data('ds-status');
    var action = (status == 0) ? "delete" : "restore";
    var link = `?act=${action}Product&idProduct=${id}`
    var confirmationMessage = `Do you want to ${action} product with name ${name}?`;

    // Set confirmation message and link
    $('#confirmation-message').text(confirmationMessage);
    document.getElementById("btn-delete").setAttribute("href", link)
  });
</script>


<!-- Show notification -->
<script>
  function showToast(success) {
    var title = "Product";
    var message = `${success} product success`;
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