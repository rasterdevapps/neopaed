<?php
    $site_url = url('/').'/public';
?>
<html>
	<head>
		<link href='http://fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>

		<style>
			body {
				margin: 0;
				padding: 0;
				width: 100%;
				height: 100%;
				color: #B0BEC5;
				display: table;
				font-weight: 100;
				font-family: 'Lato';
			}

			.container {
				text-align: center;
				display: table-cell;
				vertical-align: middle;
				font-weight: bold;
			}

			.content {
				text-align: center;
				display: inline-block;
			}

			.title {
				font-size: 72px;
				margin-bottom: 40px;
			}

			.repair-img {
			    background-size: contain;
			    background-repeat: no-repeat;
				margin-bottom: 40px;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="content">
				<div class="title">Internal Server Problem.</div>
				<img src="<?php echo e($site_url, false); ?>/img/repair.png" class="repair-img" />
				<div>Please Contact Admin</div>
				<div>or</div>
				<div><a href="<?php echo e(url('/home'), false); ?>"> Goto Home </a> </div>
			</div>
		</div>
	</body>
</html>
