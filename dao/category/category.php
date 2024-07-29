<?php
require_once '../dao/pdo.php';

// Select
function categoryGetAll()
{
  $sql = "SELECT * FROM `category` ORDER BY id DESC";
  return pdo_query($sql);
}
function categoryGetAllStatus()
{
  $sql = "SELECT * FROM `category` WHERE `status` = '0' ORDER BY id DESC";
  return pdo_query($sql);
}


function categoryGetOne($id)
{
  $sql = "SELECT * FROM `category` WHERE `id`=$id";
  return pdo_query_one($sql);
}

function categoryInsert($name, $image)
{
  $sql = "INSERT INTO `category`(`name`,`image`)
          VALUES('$name','$image')";
  pdo_execute($sql);
}

function categoryUpdate($name, $image, $id)
{
  $sql = "UPDATE `category` 
          SET `name`='$name',`image`='$image'
          WHERE `id`=$id";
  pdo_execute($sql);
}


function categoryDelete($id, $status)
{
  $sql = "UPDATE `category` 
          SET `status`='$status'
          WHERE `id`=$id";
  pdo_execute($sql);
}
function categoryCheck($name)
{
  $sql = "SELECT `name`,`status`,`id` FROM `category` WHERE name = '" . $name . "'";
  return pdo_query_one($sql);
}
function categoryReUpdate($image, $id)
{
  $sql = "UPDATE `category` 
  SET `image` = '$image',`status`= '0'
   WHERE `id` =$id";
  pdo_execute($sql);
}
function categoryCheckUpdate($newname,$name)
{
  $sql = "SELECT `name` FROM `category` WHERE name = '" . $newname . "' AND `name` <> '".$name."' ";
  return pdo_query_one($sql);
}