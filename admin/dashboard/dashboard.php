<main class="content">
  <div class="container-fluid p-0">
    <!-- Static -->
    <div class="row">
      <div class="col-12 col-sm-6 col-xl d-flex">
        <div class="card flex-fill">
          <div class="card-body py-4">
            <div class="media">
              <div class="d-inline-block mt-2 mr-3">
                <i class="feather-lg text-primary" data-feather="shopping-cart"></i>
              </div>
              <div class="media-body">
                <h3 class="mb-2"><?= $totalSales ?></h3>
                <div class="mb-0">Total Product Solded</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-xl d-flex">
        <div class="card flex-fill">
          <div class="card-body py-4">
            <div class="media">
              <div class="d-inline-block mt-2 mr-3">
                <i class="feather-lg text-warning" data-feather="folder"></i>
              </div>
              <div class="media-body">
                <h3 class="mb-2"><?= $totalProducts ?></h3>
                <div class="mb-0">Products</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-sm-6 col-xl d-flex">
        <div class="card flex-fill">
          <div class="card-body py-4">
            <div class="media">
              <div class="d-inline-block mt-2 mr-3">
                <i class="feather-lg text-danger" data-feather="shopping-bag"></i>
              </div>
              <div class="media-body">
                <h3 class="mb-2"><?= $totalPendingOrder ?></h3>
                <div class="mb-0">Pending Orders</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-xl d-none d-xxl-flex">
        <div class="card flex-fill">
          <div class="card-body py-4">
            <div class="media">
              <div class="d-inline-block mt-2 mr-3">
                <i class="feather-lg text-info" data-feather="shopping-bag"></i>
              </div>
              <div class="media-body">
                <h3 class="mb-2"><?= $totalOrder ?></h3>
                <div class="mb-0">Total Orders</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-xl d-flex">
        <div class="card flex-fill">
          <div class="card-body py-4">
            <div class="media">
              <div class="d-inline-block mt-2 mr-3">
                <i class="feather-lg text-success" data-feather="dollar-sign"></i>
              </div>
              <div class="media-body">
                <h3 class="mb-2"><?= round((float)$totalEarning, 3) ?></h3>
                <div class="mb-0">Total Earnings</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12 d-flex">
        <div class="card flex-fill w-100">
          <div class="card-header ">
            <div class="row">
              <h5 class="card-title mb-0 col-11">Total Revenue</h5>
              <?php if (isset($_GET['year'])) : ?>
                <div class="col">
                  <select class="custom-select mb-3 ml-auto" onchange="redirectToYear(this)">
                    <option value="2023" <?= $_GET['year'] == 2023 ? "selected" : "" ?>>2023</option>
                    <option value="2022" <?= $_GET['year'] == 2022 ? "selected" : "" ?>>2022</option>
                    <option value="2021" <?= $_GET['year'] == 2021 ? "selected" : "" ?>>2021</option>
                    <option value="2020" <?= $_GET['year'] == 2020 ? "selected" : "" ?>>2020</option>
                  </select>
                </div>
              <?php else : ?>
                <div class="col">
                  <select class="custom-select mb-3 ml-auto" onchange="redirectToYear(this)">
                    <option value="2023">2023</option>
                    <option value="2022">2022</option>
                    <option value="2021">2021</option>
                    <option value="2020">2020</option>
                  </select>
                </div>
              <?php endif ?>
            </div>
          </div>
          <div class="card-body">
            <div class="chart ">
              <canvas id="chartjs-dashboard-line"></canvas>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 d-flex">
        <div class="card flex-fill">
          <div class="card-header">
            <h5 class="card-title mb-0">Total category solds</h5>
          </div>
          <table id="datatables-dashboard-projects" class="table table-striped my-0">
            <thead>
              <tr>
                <th>Category ID</th>
                <th>Name Category</th>
                <th class="d-none d-xl-table-cell">Sold Product</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($categorySolds as $category) : ?>
                <?php extract($category) ?>
                <tr>
                  <td><?= $category_id ?></td>
                  <td class="d-none d-xl-table-cell"><?= $category_name ?></td>
                  <td class="d-none d-xl-table-cell"><?php
                                                      if (isset($sold_count)) echo $sold_count;
                                                      else {
                                                        echo 0;
                                                      } ?>
                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</main>


<script>
  function redirectToYear(selectElement) {
    var selectedYear = selectElement.value;
    var currentURL = window.location.href
    var parts = currentURL.split('&year=');

    // Lấy phần trước "&year=", nếu có
    var baseURL = parts[0];

    window.location.href = baseURL + "&year=" + selectedYear;
  }
</script>

<!-- Line chart -->
<script>
  $(function() {
    // Line chart
    new Chart(document.getElementById('chartjs-dashboard-line'), {
      type: 'line',
      data: {
        labels: [
          'Jan',
          'Feb',
          'Mar',
          'Apr',
          'May',
          'Jun',
          'Jul',
          'Aug',
          'Sep',
          'Oct',
          'Nov',
          'Dec',
        ],
        datasets: [{
            label: 'Sales ($)',
            fill: true,
            backgroundColor: 'transparent',
            borderColor: window.theme.primary,
            data: chartData.map(item => item.revenue)
          },
          {
            label: 'Orders',
            fill: true,
            backgroundColor: 'transparent',
            borderColor: window.theme.tertiary,
            borderDash: [4, 4],
            data: chartData.map(item => item.quantity),
          },
        ],
      },
      options: {
        maintainAspectRatio: false,
        legend: {
          display: false,
        },
        tooltips: {
          intersect: false,
        },
        hover: {
          intersect: true,
        },
        plugins: {
          filler: {
            propagate: false,
          },
        },
        scales: {
          xAxes: [{
            reverse: true,
            gridLines: {
              color: 'rgba(0,0,0,0.05)',
            },
          }, ],
          yAxes: [{
            ticks: {
              stepSize: 500,
            },
            display: true,
            borderDash: [5, 5],
            gridLines: {
              color: 'rgba(0,0,0,0)',
              fontColor: '#fff',
            },
          }, ],
        },
      },
    });
  });
</script>

<!-- Data table -->
<script>
  $(function() {
    $('#datatables-dashboard-projects').DataTable({
      pageLength: 6,
      lengthChange: false,
      bFilter: false,
      autoWidth: false,
    });
  });
</script>