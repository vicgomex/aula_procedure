<?php
$id = filter_input(INPUT_GET, 'id');

if ($id) {
  include_once '../models/Curso.php';
  $curso = new Curso();
  $curso->setId($id);
  $curso->crud(0);
}
?>
<meta http-equiv="refresh" CONTENT="0.2;URL=?p=curso/consultar">