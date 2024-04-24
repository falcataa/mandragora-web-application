<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Get post data
$fileName = $_POST['fileName'];
$description = $_POST['description'];
$author = $_POST['user_id'];;

// Get extension of the file
$imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));

// Hash the file name and append the extension
$hashedFileName = hash('sha256', $fileName . time()) . '.' . $imageFileType;

$target_dir = "uploads/";
$target_file = $target_dir . $hashedFileName;


// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  $dbh = new PDO('mysql:host=localhost;dbname=test', $user, $pass);

  $stmt = $dbh->prepare("INSERT INTO plants (user_id, title, description, filename)
                       VALUES (:user_id, :title, :description, :filename");
  $stmt->bindParam(':user_id', $fileName);
  $stmt->bindParam(':title', $description);
  $stmt->bindParam(':description', $description);
  $stmt->bindParam(':filename', $hashedFileName);

  $stmt->execute();

  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". basename($hashedFileName). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
?>
