<main class="content">
  <div class="container-fluid p-0">

    <h1 class="h3 mb-3">Detail comment</h1>

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
              <a href="?act=comment" class="btn btn-primary">List Comment</a>
            </div>
          </div>

          <!-- Data -->
          <div class="card-body">
            <table id="datatables-basic" class="table table-striped" style="width:100%">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>full name</th>
                  <th>Content</th>
                  <th>Date comment</th>
                  <th>Action</th>
                </tr>
              </thead>

              <tbody>
                <input type="hidden" id="idPro" value="<?= $_GET['idPro'] ?>">
                <?php foreach ($comments as $key => $comment) : ?>
                  <?php extract($comment) ?>
                  <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= $fullname ?></td>
                    <td><?= $content ?></td>
                    <td>
                      <?php $date = strtotime($added_on);
                      echo date('d/m/Y H:i:s', $date); ?>
                    </td>
                    <td>
                      <div class="text-center">
                        <button type="button" class="btn btn-danger deleteComment" data-toggle="modal" data-target="#defaultModalDanger" data-ds-id="<?= $id ?>">
                          Delete
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
        <h5 class="modal-title">Comment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body m-3">
        <p class="mb-0">
          Do you want to delete comment ?
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
  var idPro = $("#idPro").val();
  $('.deleteComment').on('click', function() {
    var id = $(this).data('ds-id');
    console.log(id);
    var link = `?act=deleteComment&idComment=${id}&idPro=${idPro}`
    document.getElementById("btn-delete").setAttribute("href", link)
  });
</script>


<!-- Show notification -->
<script>
  function showToast(success) {
    var title = "Comment";
    var message = `${success} comment success`;
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