<?php
require_once '../tools/warframe.php';
$session->is_auth();
?>
<!-- Page content -->
<div class="page-content">

	<!-- Main content -->
	<div class="content-wrapper">

		<!-- Content area -->
		<div class="content d-flex justify-content-center align-items-center">

			<!-- Container -->
			<div class="flex-fill">

				<!-- Error title -->
				<div class="text-center mb-3">
					<h1 class="error-title <?= $classes['error_page-code-color'] ?>">423</h1>
					<h3>Доступ на запись запрещён!</h3>
				</div>
				<!-- /error title -->


				<!-- Error content -->
				<div class="row">
					<div class="col-xl-4 offset-xl-4 col-md-8 offset-md-2 text-right">

						<!-- Buttons -->
						<button class="btn btn-light btn-block mt-3 mt-sm-0" data-dismiss="modal" title="Закрыть">Закрыть</button>
						<!-- /buttons -->

					</div>
				</div>
				<!-- /error wrapper -->

			</div>
			<!-- /container -->

		</div>
		<!-- /content area -->

	</div>
	<!-- /main content -->

</div>
<!-- /page content -->
