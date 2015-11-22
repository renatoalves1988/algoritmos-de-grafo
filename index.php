<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Trabalho Fernando</title>
	<style>
		body {color: #333}
		#box {text-align: center}
		#error h3 {color: red}
	</style>
</head>
<body>
	<div id="box">
	
		<h1>Trabalho Fernando</h1>
		<form action="Main.php" method="post" enctype="multipart/form-data">
			<input type="file" name="arquivo">
			<input type="submit" value="Enviar">
		</form>
		
		<br><hr>

		<!-- MENSAGEM DE ERRO -->
		<?php if (isset($error)): ?>
			<div id="error">
				<h3><?php echo $error ?></h3>
			</div>
		<?php endif ?>

		<!-- DISTANCIA -->
		<?php if (isset($distancia)): ?>
			<?php foreach ($distancia as $value): ?>
				<div class="algoritmos">
					<h3>DISTANCIA <?php echo implode($value[0], ' ') . '<br>' . $value[1] ?></h3>
				</div>
			<?php endforeach ?>
		<?php endif ?>

		<!-- PROFUNDIDADE -->
		<?php if (isset($profundidade)): ?>
			<?php foreach ($profundidade as $value): ?>
				<?php //var_dump($value) ?>
				<div class="algoritmos">
					<h3>PROFUNDIDADE <?php echo implode($value[0], ' '); ?> 
						<br>
						<?php foreach ($value[1] as $k => $v) {
							if ($k != 0)
							{
								echo implode($v[0], ' ') . '<br>';
							}
							else
							{
								echo $v[0] . '<br>';
							}

						} ?>
					</h3>
				</div>
			<?php endforeach ?>
		<?php endif ?>

		<!-- LARGURA -->
		<?php if (isset($largura)): ?>
			<?php foreach ($largura as $value): ?>
				<?php //var_dump($value) ?>
				<div class="algoritmos">
					<h3>LARGURA <?php echo implode($value[0], ' '); ?> 
						<br>
						<?php foreach ($value[1] as $k => $v) {
							if ($k != 0)
							{
								echo implode($v[0], ' ') . '<br>';
							}
							else
							{
								echo $v[0] . '<br>';
							}

						} ?>
					</h3>
				</div>
			<?php endforeach ?>
		<?php endif ?>

		<!-- MENOR CAMINHO -->
		<?php if (isset($menorcaminho)): ?>
			<?php foreach ($menorcaminho as $value): ?>
				<?php //var_dump($value) ?>
				<div class="algoritmos">
					<h3>MENORCAMINHO <?php echo implode($value[0], ' '); ?> 
						<br>
						<?php echo implode($value[1]['caminho'], ' '); ?>
						<br>
						<?php echo $value[1]['distancia']; ?>
					</h3>
				</div>
			<?php endforeach ?>
		<?php endif ?>
	</div>
</body>
</html>
