<?php session_start(); require_once("../../config/config.php"); ?>
<header>
	<?php require("../../helpers/helpers.php"); sweetalert_link(); ?>
</header>

<?php
	class User {
		private $conn;
		private $username;

		public function __construct($conn, $username) {
			$this->conn = $conn;
			$this->username = $username;
		}

		public function updateProfile($passkey, $phoneNumber) {
			$stmt = $this->conn->prepare("UPDATE `library`.`users` SET `password` = ?, `phone_number` = ? WHERE (`username` = ?)");
			$stmt->bind_param("sss", $passkey, $phoneNumber, $this->username);
			$stmt->execute();
		}

		public function formatPhoneNumber() {
			$stmt = $this->conn->prepare("UPDATE `library`.`users` SET phone_number = CONCAT('+1 (', SUBSTR(phone_number, 1, 3), ') ', SUBSTR(phone_number, 4, 3), '-', SUBSTR(phone_number, 7)) WHERE (`username` = ?)");
			$stmt->bind_param("s", $this->username);
			$stmt->execute();
		}

		public function updateProfileImg($profileImg) {
			$tmp_name = $profileImg['tmp_name'];

			// Verificar si se envió un archivo de imagen
			if (is_uploaded_file($tmp_name)) {
				// Obtener el tipo real del archivo
				$img_type = exif_imagetype($tmp_name);

				// Verificar si el tipo de archivo es una imagen válida
				if (in_array($img_type, [IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG])) {
					// Generar un nombre único para el archivo
					$img_file = uniqid() . image_type_to_extension($img_type);

					// Generar una ruta para guardar el archivo en el servidor
					$repository_route = "../../assets/images/profile";
					$route = $repository_route . '/' . $img_file;

					// Mover el archivo al servidor
					if (move_uploaded_file($tmp_name, $route)) {
						// Actualizar la URL de la imagen de perfil del usuario en la base de datos
						$stmt = mysqli_prepare($this->conn, "UPDATE `library`.`users` SET `profile_img_url` = ? WHERE (`username` = ?)");
						mysqli_stmt_bind_param($stmt, 'ss', $route, $this->username);
						mysqli_stmt_execute($stmt);
						mysqli_stmt_close($stmt);

						// Mostrar un mensaje de éxito al usuario
						echo "
							<script>
								Swal.fire({
									icon:'success',
									text: 'Your data has been changed successfully',
									confirmButtonText: 'Ok',
									confirmButtonColor: '#3d68ff'
								}).then(function() {
									window.location = 'account.php';
								})
							</script>
						";
						exit();
					}
				}
			}
		}
	}

	if (!isset($_SESSION['user'])) {
		header("Location: login.php");
	}

	$username = $_SESSION['user'];
	$passkey = $_POST['passkey'];
	$confirmPasskey = $_POST['confirmPasskey'];
	$phoneNumber = $_POST['phoneNumber'];

	$user = new User($conn, $username);

	$profileImg = $_FILES['profileImg'];
	$user->updateProfileImg($profileImg);

	if ($passkey != $confirmPasskey) {
		echo " 
			<script> 
				Swal.fire({ 
					icon: 'error',
					title: 'Oops...',
					text: 'Passwords do not match!',
					confirmButtonText: 'Go back',
					confirmButtonColor: '#3d68ff'
				}).then(function() {
					window.location = 'account.php';
				}) 
			</script> 
		";
		exit();
	} elseif (empty($passkey) || empty($confirmPasskey)) {
		echo "
			<script> 
				Swal.fire({ 
					icon: 'error',
					title: 'Hey!',
					text: 'Both fields must be filled!',
					confirmButtonText: 'Go back',
					confirmButtonColor: '#3d68ff'
				}).then(function() {
					window.location = 'account.php';
				}) 
			</script>
		";
		exit();
	} else {
		$user->updateProfile($passkey, $phoneNumber);
		$user->formatPhoneNumber();

		echo " 
			<script>
				Swal.fire({
					icon:'success',
					text: 'Your data has been changed successfully',
					confirmButtonText: 'Ok',
					confirmButtonColor: '#3d68ff'
				}).then(function() {
					window.location = 'account.php';
				})
			</script>
		";
	}
?>