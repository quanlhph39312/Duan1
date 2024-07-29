<?php
if (isset($_SESSION['user'])) {
  extract($_SESSION['user']);
}
?>
<nav id="sidebar" class="sidebar">
  <div class="sidebar-content">
    <a class="sidebar-brand" href="?act=home">
      <i class="align-middle" data-feather="box"></i>
      <span class="align-middle">TwentyFive</span>
    </a>

    <ul class="sidebar-nav">
      <li class="sidebar-header">Static</li>
      <!-- Dashboard -->
      <li class="sidebar-item">
        <a href="?act=dashboard" class="sidebar-link">
          <i class="align-middle" data-feather="sliders"></i>
          <span class="align-middle">Dashboard</span>
        </a>
      </li>


      <li class="sidebar-header">Manager</li>
      <!-- Category -->
      <li class="sidebar-item">
        <a href="#categories" data-toggle="collapse" class="sidebar-link collapsed">
          <i class="align-middle" data-feather="layout"></i>
          <span class="align-middle">Category</span>
        </a>
        <ul id="categories" class="sidebar-dropdown list-unstyled collapse" data-parent="#sidebar">
          <li class="sidebar-item">
            <a class="sidebar-link" href="?act=addCategory">Add category</a>
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link" href="?act=listCategory">List category</a>
          </li>
        </ul>
      </li>

      <!-- Product -->
      <li class="sidebar-item">
        <a href="#products" data-toggle="collapse" class="sidebar-link collapsed">
          <i class="align-middle" data-feather="briefcase"></i>
          <span class="align-middle">Product</span>
        </a>
        <ul id="products" class="sidebar-dropdown list-unstyled collapse" data-parent="#sidebar">
          <li class="sidebar-item">
            <a class="sidebar-link" href="?act=addProduct">Add product</a>
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link" href="?act=listProduct">List product</a>
          </li>
        </ul>
      </li>

      <!-- User -->
      <li class="sidebar-item">
        <a href="#users" data-toggle="collapse" class="sidebar-link collapsed">
          <i class="align-middle" data-feather="users"></i>
          <span class="align-middle">User</span>
        </a>
        <ul id="users" class="sidebar-dropdown list-unstyled collapse" data-parent="#sidebar">
          <li class="sidebar-item">
            <a class="sidebar-link" href="?act=addUser">Add user</a>
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link" href="?act=listUser">List user</a>
          </li>
        </ul>
      </li>

      <!-- Comment -->
      <li class="sidebar-item">
        <a href="?act=comment" class="sidebar-link">
          <i class="align-middle" data-feather="message-square"></i>
          <span class="align-middle">Comment</span>
        </a>
      </li>

      <!-- Order -->
      <li class="sidebar-item">
        <a href="?act=order" class="sidebar-link">
          <i class="align-middle" data-feather="shopping-bag"></i>
          <span class="align-middle">Order</span>
        </a>
      </li>
    </ul>

    <!-- Account -->
    <div class="sidebar-bottom d-none d-lg-block">
      <div class="media">
        <?php if ($image != '') { ?>
          <img class="rounded-circle mr-3" src="../uploads/<?= $image ?>" width="40" height="40" alt="Chris Wood" />
        <?php } else { ?>
          <img class="rounded-circle mr-3" src="./img\avatars\avatar.jpg" alt="Chris Wood" width="40" height="40" />
        <?php } ?>

        <div class="media-body">
          <h5 class="mb-1"><?= $fullname ?></h5>
          <div><i class="fas fa-circle text-success"></i> Online</div>
        </div>
      </div>
    </div>

  </div>
</nav>