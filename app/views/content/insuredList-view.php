<div class="container is-fluid mb-6">
	<h1 class="title">Asegurados</h1>
	<h2 class="subtitle">Lista de asegurados</h2>
</div>
<div class="container pb-6 pt-6">

	<div class="form-rest mb-6 mt-6"></div>

	<?php
		use app\controllers\insuredController;

		$insInsured = new insuredController();

		echo $insInsured->listarAseguradoControlador($url[1],10,$url[0],"");
	?>
</div>