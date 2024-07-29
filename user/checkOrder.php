<!-- Checkout Start -->
<div class="container-fluid pt-5">
  <form id="validation-form" action="?act=orderDetail" method="post">
    <div class="container mt-4">
      <h2 class="text-center">Order detail</h2>
      <div class=" row d-flex mt-5">
        <div class="col-9">
          <input class="form-control" name="idOrder" type="text" placeholder="Enter order id" />
        </div>
        <div class="col-3">
          <button type="submit" name="searchOrder" class="btn btn-primary">
            Search Order
          </button>
        </div>
      </div>
    </div>
  </form>

  <!-- Order -->
  <div class="container-fluid pt-5 d-flex justify-content-center">
    <div>
      <?php if (!empty($order)) : ?>
        <!-- Info -->
        <?php
        extract($order);
        if ($order_status == 0) {
          $orderStatus = 'In progress';
        } elseif ($order_status == 1) {
          $orderStatus = 'Cancelled';
        } elseif ($order_status == 2) {
          $orderStatus = ' Done';
        }
        ?>
        <div class="row">
          <div class="col-md-6 form-group">
            <label>Fullname</label>
            <input class="form-control" type="text" value="<?= $fullname ?>" name="email" disabled />
          </div>

          <div class="col-md-6 form-group">
            <label>Address</label>
            <input class="form-control" type="text" value="<?= $address ?>" name="email" disabled />
          </div>

          <div class="col-md-6 form-group">
            <label>Phone number</label>
            <input class="form-control" type="text" value="<?= $phone ?>" name="email" disabled />
          </div>

          <div class="col-md-6 form-group">
            <label>Order date</label>
            <input class="form-control" name="email" disabled type="text" value="<?php $date = strtotime($added_on);
                                                                                  echo date('d-m-Y H:i:s', $date); ?>" />
          </div>

          <div class="col-md-6 form-group">
            <label>Total payment</label>
            <input class="form-control" type="text" value="<?= $total_payment ?>" name="email" disabled />
          </div>

          <div class="col-md-6 form-group">
            <label>Order status</label>
            <input class="form-control" type="text" value="<?= $orderStatus ?>" name="email" disabled />
          </div>
        </div>

        <!-- Detail -->
        <p class="mt-3">Order Detail</p>
        <table class="table table-bordered text-center mb-0 mt-1">
          <thead class="bg-secondary text-dark">
            <tr>
              <th>Product Name</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody id="itemCarts" class="align-middle">
            <?php foreach ($showOrder as $show) : ?>
              <?php extract($show) ?>
              <tr>
                <td><?= $name ?> - (Size : <?= $size ?> - Color : <?= $color ?>)</td>
                <td><?= $price ?></td>
                <td><?= $quantity ?></td>
                <td><?= ($price * $quantity) ?></td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      <?php endif ?>
    </div>
  </div>

</div>
<!-- Checkout End -->