<?php
require_once '../../tools/warframe.php';
is_auth();
?>
<div class="modal-header bg-info">
    <h5 class="modal-title">Анализы: <?= get_full_name($_GET['user_id']) ?> </h5>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

<div id="modal_result_show_content">

    <?php LaboratoryAnalyzeTableModel::form(); ?>

</div>