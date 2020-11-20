<?php
require_once '../../../tools/warframe.php';
is_auth(5);
$header = "Пациент";
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../../layout/head.php' ?>

<body>
	<!-- Main navbar -->
	<?php include '../../layout/navbar.php' ?>
	<!-- /main navbar -->

	<!-- Page content -->
	<div class="page-content">
		<!-- Main sidebar -->
		<?php include '../../layout/sidebar.php' ?>
		<!-- /main sidebar -->

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<?php include '../../layout/header.php' ?>
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

						<h4 class="card-title">Осмотр других специалистов</h4>
			            <div class="table-responsive">
			                <table class="table table-hover table-columned">
			                    <thead>
			                        <tr class="bg-blue text-center">
			                            <th>#</th>
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
									foreach ($db->query("SELECT id, parent_id, direction, accept_date, completed FROM visit WHERE user_id = $patient->user_id AND completed IS NOT NULL AND parent_id != {$_SESSION['session_id']} AND route_id != {$_SESSION['session_id']} ORDER BY accept_date DESC") as $row) {
									?>
										<tr class="text-center">
											<td><?= $i++ ?></td>
											<td><?= get_full_name($row['parent_id']) ?></td>
											<td><?= ($row['direction']) ? "Стационарный" : "Амбулаторный" ?></td>
											<td><?= date('d.m.Y  H:i', strtotime($row['accept_date'])) ?></td>
											<td><?= date('d.m.Y  H:i', strtotime($row['completed'])) ?></td>
											<td>
                                                <?php
                                                foreach ($db->query('SELECT sr.name FROM visit_service vsr LEFT JOIN service sr ON (vsr.service_id = sr.id) WHERE visit_id ='. $row['id']) as $serv) {
                                                    echo $serv['name']."<br>";
                                                }
                                                ?>
                                            </td>
											<td class="text-center">
												<button type="button" class="btn btn-outline-primary btn-lg legitRipple dropdown-toggle" data-toggle="dropdown"><i class="icon-eye mr-2"></i> Просмотр</button>
												<div class="dropdown-menu dropdown-menu-right">
													<a onclick="Check('<?= viv('doctor/report') ?>?pk=<?= $row['id'] ?>')" class="dropdown-item"><i class="icon-paste2"></i>Заключения врача</a>
												</div>
											</td>
										</tr>
									<?php
									}
								 	?>
			                    </tbody>
			                </table>
			            </div>
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
		<div class="modal-dialog modal-lg">
			<div class="modal-content border-3 border-info">
				<div class="modal-body" id="report_show">

				</div>
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
    <?php include '../../layout/footer.php' ?>
    <!-- /footer -->
</body>
</html>