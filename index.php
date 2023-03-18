<?php 

    if(isset($_POST['submit'])){
        // validate form inputs
    if ( empty( $_POST['name'] ) || empty( $_POST['email'] ) || empty( $_POST['password'] ) || empty( $_FILES['propic'] ) ) {
        die( 'All fields are required.' );
    }

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $profile_pic = $_FILES['propic'];

    // validate email format
    if ( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
        die( 'Invalid email format.' );
    }

     // save profile picture to server
     $upload_dir = 'uploads/';
     $filename = uniqid() . '_' . date( 'Y-m-d_H-i-s' ) . '_' . $profile_pic['name'];
 

     if ( !move_uploaded_file( $profile_pic['tmp_name'], $upload_dir . $filename ) ) {
        die( 'Error uploading file.' );
    }


     // save user's data to CSV file
     $data = array( $name, $email, $password, $filename );
     $file = fopen( 'users.csv', 'a' );


     if ( fputcsv( $file, $data ) === false ) {
        die( 'Error writing to file.' );
    }
    fclose( $file );


     // start session and set cookie
     session_start();
     setcookie( 'username', $name );
 
     // redirect to success page
     header( 'Location: success.php' );
     exit();


    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TAssignment - 6</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
		<div class="row" style="margin-bottom: 55px;">
			<div class="heading">
				<h2>Project - Assignment Six</h2>
					<p>Hello Users, Please Login Below</p>
			</div>
		</div>
		<div class="row">
			<div class="area-form">
				<form action="" method="POST" enctype="multipart/form-data">
					<label for="name">Name</label> <br>
					<input type="text" name="name" id="name"> <br>					

                    <label for="email">Email Address</label> <br>
					<input type="email" name="email" id="email"> <br>					

					<label for="password">Password</label> <br>
					<input type="password" name="password" id="password"> <br>
					
                    <label for="propic">Profile Picture</label> <br>
					<input type="file" name="propic" id="propic"> <br>
					
					<input type="submit" value="Submit" name="submit">
				</form>

			</div>
		</div>
	</div>
</body>
</html>