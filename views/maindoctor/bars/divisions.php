<!-- Информация об отделах -->
<div class="mb-3">
	<div class="header-elements-sm-inline">
		<span class="mb-0 text-muted d-block">Отделы</span>
		<h4 class="font-weight-semibold d-block">Информация о отделах</h4>
		<span class="mb-0 text-muted d-block">Сегодня</span>
	</div>
</div>

<div class="row">

	<?php foreach ($db->query("SELECT id, title FROM divisions WHERE level IN(5, 6, 12) OR level = 10 AND (assist IS NULL OR assist = 1) ORDER BY level") as $row): ?>
		<div class="col-sm-4 col-xl-3">
			<div class="card card-body">
				<div class="media">
					<div class="media-body">
						<h3 class="font-weight-semibold mb-0">
							<?= $db->query("SELECT id FROM visit_services WHERE division_id = {$row['id']} AND accept_date IS NOT NULL AND DATE_FORMAT(add_date, '%Y-%m-%d') = CURRENT_DATE()")->rowCount() ?>
						</h3>
						<span class="text-uppercase font-size-sm text-muted"><?= $row['title'] ?></span>
					</div>

					<div class="ml-3 align-self-center">
						<i class="icon-cube4 icon-3x text-blue-400"></i>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach; ?>

</div>
<!-- /Информация об отделах -->