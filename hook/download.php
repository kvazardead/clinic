<?php
require_once '../tools/warframe.php';
is_auth();

$form = new $_GET['model'];
write_excel($form->table, $_GET['file'], $form->table_label);
?>