<main class="content">
  <div class="container-fluid p-0">

    <h1 class="h3 mb-3">List category</h1>

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
              <a href="?act=addCategory" class="btn btn-primary">Add category</a>
            </div>
          </div>

          <!-- Data -->
          <div class="card-body">
            <table id="datatables-basic" class="table table-striped" style="width:100%">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Category name</th>
                  <th>Image</th>
                  <th>Status</th>
                  <th>
                    <div class="text-center">Action</div>
                  </th>
                </tr>
              </thead>

              <tbody>
                <?php foreach ($categories as $key => $category) : ?>
                  <?php extract($category) ?>
                  <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= $name ?></td>
                    <td>
                      <img src="../uploads/<?= $image ?>" alt="...image cate" width="100px" height="100px">
                    </td>
                    <td><?= $status == 0 ? 'Show' : 'Hidden' ?></td>
                    <td>
                      <div class="d-flex flex-row justify-content-center">
                        <a href="?act=updateCategory&idCategory=<?= $id ?>" class="btn btn-warning ">
                          Update
                        </a>

                        <button type="button" class="btn btn-danger deleteCategory ml-2" data-toggle="modal" data-target="#defaultModalDanger" data-ds-status="<?= $status ?>" data-ds-name="<?= $name ?>" data-ds-id="<?= $id ?>">
                          <?= ($status == 0) ? "Delete" : "Restore" ?>
                        </button>
                      </div>
                    </td>
                  </tr>
                <?php endforeach ?>
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
      lengthMenu: [5, 10, 20]
    });
  });
</script>


<!-- Confirm delete -->
<div class="modal fade" id="defaultModalDanger" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Category</h5>
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
  $('.deleteCategory').on('click', function() {
    var id = $(this).data('ds-id');
    console.log(id);
    var name = $(this).data('ds-name')
    var status = $(this).data('ds-status');
    var action = (status == 0) ? "delete" : "restore";
    var link = `?act=${action}Category&idCategory=${id}`;
    var confirmationMessage = `<strong>Do you want to ${action} category with name ${name}?</strong>`;

    // Set confirmation message and link
    $('#confirmation-message').html(confirmationMessage);
    document.getElementById("btn-delete").setAttribute("href", link)

  });
</script>

<!-- Show notification -->
<script>
  function showToast(success) {
    var title = "Category";
    var message = `${success} category success`;
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