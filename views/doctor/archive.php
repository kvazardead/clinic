<?php
require_once '../../tools/warframe.php';
is_auth(5);
$header = "Архив";
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
						<h6 class="card-title">Архив</h6>
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
                                        <th>ID</th>
                                        <th>ФИО</th>
                                        <th>Дата рождения</th>
                                        <th>Номер телефона</th>
                                        <th>Дата регистрации </th>
                                        <th class="text-center" style="width:210px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    prit($db->query('SELECT * FROM users WHERE user_level = 15 ORDER BY add_date DESC')->fetch());
                                    foreach($db->query('SELECT * FROM users WHERE user_level = 15 ORDER BY add_date DESC') as $row) {
                                        ?>
                                        <tr>
                                            <td><?= addZero($row['id']) ?></td>
                                            <td><?= get_full_name($row['id']) ?></td>
                                            <td><?= $row['dateBith'] ?></td>
                                            <td><?= $row['numberPhone'] ?></td>
                                            <td><?= $row['add_date'] ?></td>
                                            <td class="text-center">
												<button type="button" class="btn bg-indigo btn-sm legitRipple">Визиты</button>
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

	<!-- Footer -->
	<?php include '../layout/footer.php' ?>
	<!-- /footer -->
</body>
</html>