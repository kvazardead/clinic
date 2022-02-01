<?php
require_once '../../tools/warframe.php';
$session->is_auth(5);
$header = "Пациенты";
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

				<div class="<?= $classes['card'] ?>">

					<div class="<?= $classes['card-header'] ?>">
						<h6 class="card-title">Стационарные пациенты</h6>
						<div class="header-elements">
                            <div class="form-group-feedback form-group-feedback-right mr-2 wmin-200">
                                <select data-placeholder="Выберите отдел" id="division_input" name="division" class="<?= $classes['form-select'] ?>">
                                    <option></option>
                                    <?php foreach($db->query("SELECT * from divisions WHERE level = 5") as $row): ?>
                                        <option value="<?= $row['id'] ?>" <?= ( isset($_POST['division_id']) and $_POST['division_id'] == $row['id']) ? "selected" : "" ?>><?= $row['title'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
							<!-- <div class="form-group-feedback form-group-feedback-right mr-2">
								<input type="text" class="<?= $classes['input-search'] ?>" value="" id="search_input" placeholder="Поиск..." title="Введите ID, имя пациента или название услуги">
								<div class="form-control-feedback">
									<i class="icon-search4 font-size-base text-muted"></i>
								</div>
							</div> -->
						</div>
					</div>

					<div class="card-body" id="search_display"></div>

				</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

	<script type="text/javascript">

		$("#division_input").change(function() {
			$.ajax({
				type: "GET",
				url: "<?= viv('sentry/search') ?>",
				data: {
					table_division: this.value,
				},
				success: function (result) {
					$('#search_display').html(result);
				},
			});
		});

        $("#search_input").keyup(function() {
			$.ajax({
				type: "GET",
				url: "<?= ajax('search/doctor-index') ?>",
				data: {
					table_division: $("#division_input").val(),
					table_search: this.value,
				},
				success: function (result) {
					$('#search_display').html(result);
				},
			});
		});

	</script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>