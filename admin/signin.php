<?php include 'connect.php' ?>
<?php
session_start();
if(isset($_SESSION['admin_user'])) {
	include 'logout.php';
}
$username = $password = $error_text ="";
$error_flag = 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$username = $_POST['username'];
	$password = $_POST['password'];

	if(empty($username) || empty($password)) {
		$error_flag = 1;
		$error_text = "Fields shouldn't be empty";
	}
	if(!$error_flag) {

		$sql = "SELECT * FROM admin WHERE username = '$username'";
		$result = mysqli_query($conn, $sql);
		if ($row = mysqli_fetch_assoc($result)) {
			if (password_verify($password, $row['password'])) {
				$_SESSION['admin_user'] = $row['id'];
				 echo '<script type="text/javascript">
					window.location = "business.php"
					 </script>';
			} else {
				$error_flag = 1;
				$error_text = "Invalid credentials.";
			}
		} else {
			$error_flag = 1;
			$error_text = "Invalid credentials.";
		}
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/style.css">
	<title> Admin signin</title>
</head>
<body>
<nav class="navbar navbar-light bg-info">
        <span class="navbar-brand mb-0 h1 text-light">Know your destination</span>
        <div class="ml-auto">
        <a class="mr-2" href="../user/">
                <Button class="btn btn-light">
                    Sign in as User
                </Button>
            </a>
            <a class="mr-2" href="../businessadmin/">
                <Button class="btn btn-light">
                    Sign in as Business
                </Button>
            </a>
            
        </div>
    </nav>
	<div class="container col-md-6 rounded mt-5 p-4 bg-white">
		<form action="" method="POST">
			<div align="center">
				<h2>Admin Signin </h2>
			</div>
		<div class="form-group">
			<label class="col-md-3 ">Username:</label>
				<input type="text" name="username" class="form-control">
		</div>
		
		
		<div class="form-group">
			<label class="col-md-3 ">Password:</label>
			<input type="password" name="password" class="form-control">
		</div>
		<?php
		if ($error_flag) { ?>
				<div align="center" class=" text-danger">
					<?php echo $error_text ?>
				</div>
			<?php
			}
			?>
		<div align="center">	
		   <input type="Submit" value="submit" class="btn  btn-primary w-100 mt-4">
	    </div>
	    </form>
	</div>
	
</body>
</html>