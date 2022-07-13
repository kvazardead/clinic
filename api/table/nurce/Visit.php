<?php
require '../../../tools/warframe.php';
$session->is_auth();

importModel('Visit');
$tb = new Visit('v');
$tb->Data("v.id, v.patient_id, p.first_name, p.last_name, p.father_name, v.add_date, v.discharge_date, v.grant_id, v.division_id");
$search = $tb->getSearch();
$search_array = array(
	"v.division_id = $session->session_division AND v.direction IS NOT NULL AND v.completed IS NULL AND v.is_active IS NOT NULL",
	"v.division_id = $session->session_division AND v.direction IS NOT NULL AND v.completed IS NULL AND v.is_active IS NOT NULL AND (p.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', p.last_name, p.first_name, p.father_name)) LIKE LOWER('%$search%'))",
);
$tb->JoinLEFT('patients p', 'p.id=v.patient_id')->Where($search_array)->Order("v.add_date DESC")->Limit(20);
?>

<div class="table-responsive">
    <table class="table table-hover table-sm">
        <thead class="<?= $classes['table-thead'] ?>">
            <tr>
                <th>#</th>
                <th>ID</th>
                <th>ФИО</th>
                <th>Дата размещения</th>
                <th>Дата выписки</th>
                <th>Лечущий врач</th>
                <th class="text-center" style="width:210px">Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($tb->list(1) as $row): ?>
                <tr>
                    <td><?= $row->count ?></td>
                    <td><?= addZero($row->patient_id) ?></td>
                    <td>
                        <div class="font-weight-semibold"><?= patient_name($row->patient_id) ?></div>
                        <div class="text-muted">
                            <?php if($stm = $db->query("SELECT building, floor, ward, bed FROM beds WHERE patient_id = $row->patient_id")->fetch()): ?>
                                <?= $stm['building'] ?>  <?= $stm['floor'] ?> этаж <?= $stm['ward'] ?> палата <?= $stm['bed'] ?> койка;
                            <?php endif; ?>
                        </div>
                    </td>
                    <td><?= ($row->add_date) ? date_f($row->add_date, 1) : '<span class="text-muted">Нет данных</span>' ?></td>
                    <td><?= ($row->discharge_date) ? date_f($row->discharge_date, 1) : '<span class="text-muted">Нет данных</span>' ?></td>
                    <td>
                        <?= $db->query("SELECT title FROM divisions WHERE id = $row->division_id")->fetchColumn() ?>
                        <div class="text-muted"><?= get_full_name($row->grant_id) ?></div>
                    </td>
                    <td class="text-right">
                        <button type="button" class="<?= $classes['btn-viewing'] ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-eye mr-2"></i> Просмотр</button>
                        <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(1153px, 186px, 0px);">
                            <a href="<?= viv('card/content-1') ?>?pk=<?= $row->id ?>&activity=1" class="dropdown-item"><i class="icon-repo-forked"></i>Осмотр Врача</a>
                            <a href="<?= viv('card/content-5') ?>?pk=<?= $row->id ?>&activity=1" class="dropdown-item"><i class="icon-add"></i>Назначенные услуги</a>
                            <?php if(module('module_laboratory')): ?>
                                <a href="<?= viv('card/content-7') ?>?pk=<?= $row->id ?>&activity=1" class="dropdown-item"><i class="icon-fire2"></i>Анализы</a>
                            <?php endif; ?>
                            <?php if(module('module_diagnostic')): ?>
                                <a href="<?= viv('card/content-8') ?>?pk=<?= $row->id ?>&activity=1" class="dropdown-item"><i class="icon-pulse2"></i>Диагностика</a>
                            <?php endif; ?>
                            <?php if(module('module_bypass')): ?>
                                <a href="<?= viv('card/content-9') ?>?pk=<?= $row->id ?>&activity=1" class="dropdown-item"><i class="icon-magazine"></i>Лист назначения</a>
                            <?php endif; ?>
                            <a href="<?= viv('card/content-12') ?>?pk=<?= $row->id ?>&activity=1" class="dropdown-item"><i class="icon-clipboard2"></i> Состояние</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $tb->panel() ?>