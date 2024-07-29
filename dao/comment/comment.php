<?php
require_once '../dao/pdo.php';


function commentCountById($id)
{
  $sql = "SELECT COUNT(id_pro) FROM comment WHERE id_pro=$id";
  return pdo_query_value($sql);
}

function commentGetAll()
{
  $sql = "SELECT p.name, p.image, c.id_pro, MAX(c.id) AS max_id
  FROM comment c
  LEFT JOIN product p ON c.id_pro = p.id
  GROUP BY c.id_pro
  ORDER BY max_id DESC;";
  return pdo_query($sql);
}


function commentGetDetail($id)
{
  $sql = "SELECT u.fullname,c.content,c.added_on,c.id FROM comment c
    LEFT JOIN user u  ON c.id_user = u.id
    where id_pro=?";
  return pdo_query($sql, $id);
}

function commentDelete($id)
{
  $sql = "DELETE FROM `comment` WHERE `id`=$id";
  pdo_execute($sql);
}


function commentGetCountForProduct($id)
{
  $sql = "SELECT COUNT(`id`) FROM `comment` WHERE `id_pro`=$id";
  return pdo_query_value($sql);
}

function commentGetAllForProduct($id)
{
  $sql = "SELECT `comment`.id, `comment`.content, `comment`.id_pro, `comment`.added_on,
  `user`.fullname, `user`.`image` 
  FROM `comment`
  LEFT JOIN `user` 
    ON `user`.id =`comment`.id_user 
  WHERE `id_pro`=$id 
  ORDER BY `comment`.id DESC";
  return pdo_query($sql);
}
function commentInsert($content,$id,$idUser){
  $sql = "INSERT INTO `comment`(`content`, `id_pro`, `id_user`) VALUES ('$content','$id','$idUser')";
  pdo_execute($sql);
}