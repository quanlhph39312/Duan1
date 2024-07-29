<?php
require_once '../dao/pdo.php';

function userGetAll()
{
  $sql = "SELECT * FROM `user` ORDER BY id DESC";
  return pdo_query($sql);
}
function userGetOne($id)
{
  $sql = "SELECT * FROM `user` WHERE `id`=$id";
  return pdo_query_one($sql);
}

function userDelete($id, $status)
{
  $sql = "UPDATE `user`
          SET `status`='$status'
          WHERE `id`=$id";
  pdo_execute($sql);
}
