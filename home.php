<?php session_start(); ?>

<?php if (isset($_SESSION['username']) && $_SESSION['username'] && isset($_SESSION['date_created']) && $_SESSION['date_created']){ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Profile for <?php echo $_SESSION['username'];?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="home/sheet/bootstrap.css">
	<link rel="stylesheet" href="home/sheet/ionicons.min.css">
	<link rel="stylesheet" href="home/sheet/mine.css">
	<link rel="icon" href="home/img/user.png">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,700" rel="stylesheet">
	<script src="home/javascript/myscript.js"></script>
</head>

<body>
	<div class="container" style="margin-top: 116px;">
		<div class="row">
			<div class="col-11 mx-auto profile">
				<div class="py-3 px-2 px-lg-4 py-lg-5">

					<div class="row">
						<div class="avatarBox col-12 col-lg-5">
							<img src="home/img/4.png" class="img-fluid">
						</div>

						<div class="infoBox col-12 col-lg-6 mt-2 mt-lg-0">
							<p class="sayHi">Profile</p>

							<div class="name">
								<p><span>Welcome</span> <?php echo $_SESSION['username'];?></p>
								<p class="s">Active
									<span class="ion-ios-checkmark-outline"></span>
								</p>
							</div>
							<hr>
							<div class="detailInfo">
								<div class="row my-2">
									<div class="col-lg-4 col-12 boldd">Username :</div>
									<div class="col-lg-8 col-12 b"><?php echo $_SESSION['username'];?></div>
								</div>
								<div class="row my-2">
									<div class="col-lg-4 col-12 boldd">Email :</div>
									<div class="col-lg-8 col-12 b"><?php echo $_SESSION['email'];?></div>
								</div>
								<div class="row my-2">
									<div class="col-lg-4 col-12 boldd">Password time :</div>
									<div class="col-lg-8 col-12 b"><?php echo $_SESSION['passTime'];?> days</div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-12 boldd">Password :</div>
									<div class="col-lg-8 col-12 b"><a href="./changePass.php" style="color:red">Change Password</a></div>
								</div>

							</div>
						</div>
					</div>

				</div>
			</div>
			<div class="col-11 mx-auto bg-danger contact text-center" style="background: linear-gradient(to right, rgb(232 120 67), rgb(232 131 131));">
				<div class="social col-12">
					<a href="./logout.php">
						<span class="ml-lg-3">Logout</span>
					</a>
				</div>
			</div>
		</div>
	</div>
</body>
<?php } else{ 
	$actual_link = "http://$_SERVER[HTTP_HOST]/ATW_Login";
	header('Location: '.$actual_link.'/loginForm.php'); }?>
<footer>
</footer>

</html>