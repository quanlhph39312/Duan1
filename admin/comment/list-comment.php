<main class="content">
  <div class="container-fluid p-0">

    <h1 class="h3 mb-3">List comment</h1>

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
                  <th>Product name</th>
                  <th>Image</th>
                  <th>Total comment</th>
                  <th>Action</th>
                </tr>
              </thead>

              <tbody>
                <?php foreach ($comments as $key => $comment) : ?>
                  <?php extract($comment) ?>
                  <?php $totalComment = commentCountById($id_pro) ?>
                  <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= $name ?></td>
                    <td><img src="../uploads/<?= $image ?>" width="100px" alt="...image cate"></td>
                    <td><?= $totalComment ?></td>
                    <td>
                      <div class="text-center">
                        <a href="?act=detailComment&idPro=<?= $id_pro ?>" class="btn btn-primary">
                          View Detail
                        </a>
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