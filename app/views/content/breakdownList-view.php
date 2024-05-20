<div class="container is-fluid mb-6">
	<h1 class="title">Averias</h1>
	<h2 class="subtitle">Lista de averias</h2>
</div>
<div class="container pb-6 pt-6">

	<div class="form-rest mb-6 mt-6"></div>

	<?php
		use app\controllers\breakdownController;

		$insAveria = new breakdownController();

		echo $insAveria->listarAveriaControlador($url[1],10,$url[0],"");
	?>
</div>