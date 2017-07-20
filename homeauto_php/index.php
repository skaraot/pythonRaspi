<?php
session_start();
require 'blowfish.php';
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>The Home System</title>
	<meta name="description" content="Home Automation">
	<meta name="author" content="Serkan KARAOT">
	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
	<link rel="stylesheet" href="cssjs/css/bootstrap.min.css">
	<link rel="stylesheet" href="cssjs/css/styles.css?v=1.0">
	<link rel="stylesheet" href="bower_components/chartist/dist/chartist.min.css">
	<link rel="stylesheet" href="bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css">
</head>

<body>
	<?php
	$blowFish = new Encryption();

	if ($_POST){
	$postValue=[];
	define("user", "xxxx");
	define("pass", "xxxx");
	foreach($_POST as $key => $value){
		$postValue[$key]=$value;
	}
		$sifreliData = $blowFish->decrypt($postValue['_token']);
		$veriDegerle = explode('|', $sifreliData);
		$kontrol = "HomeSystem".date('Ymd');
		if ($postValue['kul']==user && $postValue['pass']==pass  && $veriDegerle[0]==$kontrol){
			$_SESSION['kulx'] = $veriDegerle[1];
			header('Location:controlPanel.php');
		}else{
		header('Location:index.php');
		}
	}else{
	$token = $blowFish->encrypt("HomeSystem".date('Ymd').'|'.uniqid(rand(), true));
	?>
	<div class='container margin40'>
	<div class='col-md-6 col-md-offset-3'>
		<div class='row'>
		<h3>Yönetim Girişi</h3>
		<hr />
		<form method="POST" action="" accept-charset="UTF-8">
		<input name="_token" type="hidden" value="<?php echo $token; ?>">
			<div class="form-group">
			<label for="">Kullanıcı Adı</label>
			<input placeholder="Kulanıcı Adınızı Yazın" class="form-control" name="kul" type="text">
			</div>
			<div class="form-group">
			<label for="">Parolanız</label>
			<input placeholder="Parolanızı Yazın" class="form-control" type="password" name="pass" value="">
			</div>
		<input class="btn btn-primary pull-right" type="submit" value="Giriş">
		</form>
		</div>
	</div>
	</div>
	<?php
	}
	?>
  	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="cssjs/js/bootstrap.min.js"></script>
	<script src="bower_components/chartist/dist/chartist.min.js"></script>
	<script src="bower_components/chartist-plugin-pointlabels/dist/chartist-plugin-pointlabels.min.js"></script>
	<script src="bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
	<script src="bower_components/notifyjs/notify.js"></script>
</body>
</html>
