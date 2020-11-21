<?php
require_once '../../tools/warframe.php';
is_auth(6);
$header = "Пациент ".addZero($_GET['id']);
$patient = $db->query("SELECT * FROM users WHERE id = {$_GET['id']}")->fetch(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../layout/head.php' ?>

<body>

	<!-- Main navbar -->
	<?php include '../layout/navbar.php' ?>
	<!-- /main navbar -->


	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		<?php include '../layout/sidebar.php' ?>
		<!-- /main sidebar -->

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<?php include '../layout/header.php' ?>
			<!-- /page header -->

			<!-- Content area -->
			<div class="content">

                <div class="card border-1 border-info">

                    <div class="card-header text-dark header-elements-inline alpha-info">
                        <h6 class="card-title" ><b>Информация о пациенте</b></h6>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item" data-action="collapse"></a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-3">
                                <div class="card-img-actions">
                                    <img class="card-img-top img-fluid" src="<?= stack("vendors/image/user3.jpg")?>" alt="">
                                </div>
                            </div>

							<div class="col-md-9" style="font-size: 0.9rem">

				                <fieldset class="mb-3 row">

				                    <div class="col-md-6">

				                        <div class="form-group row">


				                            <label class="col-md-4"><b>Дата рождение:</b></label>
				    						<div class="col-md-8 text-right">
				    							<?= date('d.m.Y', strtotime($patient->dateBith)) ?>
				    						</div>

				                            <label class="col-md-4"><b>Адрес проживание:</b></label>
				    						<div class="col-md-8 text-right">
				    							г. <?= $patient->region ?> <?= $patient->residenceAddress ?>
				    						</div>

				                            <label class="col-md-4"><b>Адрес прописки:</b></label>
				    						<div class="col-md-8 text-right">
				    							г. <?= $patient->region ?> <?= $patient->registrationAddress ?>
				    						</div>

				                            <label class="col-md-4"><b>Дата визита:</b></label>
				    						<div class="col-md-8 text-right">
				    							<?= date('d.m.Y  H:i', strtotime($patient->accept_date)) ?>
				    						</div>

				                        </div>

				                    </div>

				                    <div class="col-md-6">

				                        <div class="form-group row">

				    						<label class="col-md-3"><b>ID:</b></label>
				    						<div class="col-md-9 text-right">
				    							<?= addZero($patient->id) ?>
				    						</div>

				                            <label class="col-md-3"><b>Телефон:</b></label>
				    						<div class="col-md-9 text-right">
				    							<?= $patient->numberPhone ?>
				    						</div>

				                            <label class="col-md-3"><b>Пол:</b></label>
				    						<div class="col-md-9 text-right">
				    							<?= ($patient->gender) ? "Мужской": "Женский" ?>
				    						</div>

				                            <label class="col-md-3"><b>Аллергия:</b></label>
				                            <div class="col-md-9 text-right">
				                                <?= $patient->allergy ?>
				                            </div>

				    					</div>

				                    </div>

				                </fieldset>

				            </div>

                        </div>

                    </div>

                </div>

				<div class="card border-1 border-info">

					<div class="card-header text-dark header-elements-inline alpha-info">
						<h6 class="card-title">Визиты</h6>
						<div class="header-elements">
							<div class="list-icons">
								<a class="list-icons-item" data-action="collapse"></a>
							</div>
						</div>
					</div>

					<div class="card-body">

						<div class="table-responsive">
                            <table class="table table-hover table-sm table-bordered">
                                <thead>
                                    <tr class="bg-info">
                                        <th>#</th>
			                            <th>Напрвитель</th>
			                            <th>Тип визита</th>
										<th>Дата визита</th>
										<th>Дата завершения</th>
			                            <th>Мед услуга</th>
                                        <th class="text-center" style="width:210px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach($db->query("SELECT * FROM visit WHERE user_id = {$_GET['id']} AND parent_id = {$_SESSION['session_id']} AND completed IS NOT NULL ORDER BY add_date DESC") as $row) {
                                        ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
											<td><?= get_full_name($row['route_id']) ?></td>
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
												<button type="button" class="btn btn-outline-info btn-lg legitRipple dropdown-toggle" data-toggle="dropdown"><i class="icon-eye mr-2"></i> Просмотр</button>
												<div class="dropdown-menu dropdown-menu-right">
													<a onclick="Check('<?= viv('laboratory/report') ?>?pk=<?= $row['id'] ?>')" class="dropdown-item"><i class="icon-paste2"></i>Анализы</a>
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

				</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

    <div id="modal_report_show" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-full">
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
    <?php include '../layout/footer.php' ?>
    <!-- /footer -->
</body>
</html>