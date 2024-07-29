<main class="content">
  <div class="container-fluid p-0">

    <h1 class="h3 mb-3">List User</h1>

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
                  <th>Email</th>
                  <th>Full name</th>
                  <th>Phone</th>
                  <th>Image</th>
                  <th>Address</th>
                  <th>Role</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>

              <tbody>
                <?php foreach ($users as $key => $user) : ?>
                  <?php extract($user) ?>
                  <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= $email ?></td>
                    <td><?= $fullname ?></td>
                    <td><?= $phone ?></td>
                    <td><img src="../uploads/<?= $image ?>" width="100px" alt="...image cate"></td>
                    <td><?= $address ?></td>
                    <td><?= $role == 0 ? 'User' : 'Admin' ?></td>
                    <td><?= $status == 0 ? 'Action' : 'Block' ?></td>
                    <td>
                      <div class="text-center">
                        <a href="?act=updateUser&idUser=<?= $id ?>" class="btn btn-warning ">
                          Update
                        </a>
                        <button type="button" class="btn btn-danger deleteUser" data-toggle="modal" data-target="#defaultModalDanger" data-ds-id="<?= $id ?>" data-ds-email="<?= $email ?>" data-ds-status="<?= $status ?>" >
                          <?= ($status == 0)?"Block" : "Activated"?>
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
      responsive: true
    });
  });
</script>

<!-- Confirm delete -->
<div class="modal fade" id="defaultModalDanger" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">User</h5>
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
  $('.deleteUser').on('click', function() {
    var id = $(this).data('ds-id');
    console.log(id);
    var email = $(this).data('ds-email');
    var status = $(this).data('ds-status');
    var action = (status == 0) ? "delete" : "Activated";
    var link = `?act=${action}User&idUser=${id}`
    var confirmationMessage = `Do you want to ${action} user with email ${email}?`;
      // Set confirmation message and link
    $('#confirmation-message').text(confirmationMessage);
    document.getElementById("btn-delete").setAttribute("href", link)
  });
</script>


<!-- Show notification -->
<script>
  function showToast(success) {
    var title = "User";
    var message = `${success} user success`;
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