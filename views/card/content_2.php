<?php
require_once '../../tools/warframe.php';
$session->is_auth();
$header = "Пациент";
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>

<body>
	<!-- Main navbar -->
	<?php include layout('navbar') ?>
	<!-- /main navbar -->

	<!-- Page content -->
	<div class="page-content">
		<!-- Main sidebar -->
		<?php include layout('sidebar') ?>
		<!-- /main sidebar -->

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<?php include layout('header') ?>
			<!-- /page header -->

			<!-- Content area -->
			<div class="content">

				<?php include "profile.php"; ?>

				<div class="card border-1 border-info">
				    <div class="card-header text-dark header-elements-inline alpha-info">
				        <h6 class="card-title">Просмотр визита</h6>
				    </div>

				    <div class="card-body">

				        <?php include "content_tabs.php"; ?>

						<legend class="font-weight-semibold text-uppercase font-size-sm">
							<i class="icon-clipboard6 mr-2"></i>Другие визиты
						</legend>

						<div class="alert bg-warning alert-styled-left alert-dismissible">
							<span class="font-weight-semibold">Технические работы</span>
						</div>

						<!-- <div class="card">

							<div class="table-responsive">
				                <table class="table table-hover table-sm">
				                    <thead>
				                        <tr class="bg-info">
				                            <th>№</th>
				                            <th>Специалист</th>
				                            <th>Тип визита</th>
											<th>Дата визита</th>
											<th>Дата завершения</th>
				                            <th>Мед услуга</th>
				                            <th class="text-center">Действия</th>
				                        </tr>
				                    </thead>
				                    <tbody>
										<?php
										$i = 1;
										foreach ($db->query("SELECT vs.id, vs.parent_id, vs.direction, vs.accept_date, vs.completed, vs.status, sc.name FROM visit vs LEFT JOIN service sc ON(vs.service_id=sc.id) WHERE vs.user_id = $patient->id AND vs.route_id != {$_SESSION['session_id']} AND vs.parent_id != {$_SESSION['session_id']} AND vs.completed IS NOT NULL AND vs.laboratory IS NULL AND vs.diagnostic IS NULL ORDER BY id DESC") as $row) {
										?>
											<tr>
												<td><?= $i++ ?></td>
												<td>
													<?= level_name($row['parent_id']) ." ". division_name($row['parent_id']) ?>
													<div class="text-muted"><?= get_full_name($row['parent_id']) ?></div>
												</td>
												<td><?= ($row['direction']) ? "Стационарный" : "Амбулаторный" ?></td>
												<td><?= ($row['accept_date']) ? date('d.m.Y H:i', strtotime($row['accept_date'])) : '<span class="text-muted">Нет данных</span>' ?></td>
												<td><?= ($row['completed']) ? date('d.m.Y H:i', strtotime($row['completed'])) : '<span class="text-muted">Нет данных</span>' ?></td>
												<td><?= $row['name'] ?></td>
												<td class="text-center">
													<button onclick="Check('<?= viv('doctor/report') ?>?pk=<?= $row['id'] ?>')" type="button" class="btn btn-outline-info btn-sm legitRipple"><i class="icon-eye mr-2"></i> Просмотр</button>
												</td>
											</tr>
										<?php
										}
									 	?>
				                    </tbody>
				                </table>
				            </div>

						</div> -->

				    </div>

				    <!-- /content wrapper -->
				</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->
	</div>
	<!-- /page content -->

	<div id="modal_report_show" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg" id="modal_class_show">
			<div class="modal-content border-3 border-info" id="report_show">

			</div>
		</div>
	</div>

	<script type="text/javascript">
		function Check(events) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (data) {
					$('#modal_report_show').modal('show');
					$('#report_show').html(data);
				},
			});
		};
	</script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
