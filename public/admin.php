<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: admin_login.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
  <head>
        <title>Admin Panel</title>
        <link rel="stylesheet" type="text/css" href="./css/admin-style.css">
  </head>

  <body>
    <form action="upload.php" method="post" enctype="multipart/form-data" class="center-form">
      Select image to upload:
      <input type="file" name="fileToUpload" id="fileToUpload">
      File name:
      <input type="text" name="fileName" id="fileName">
      Description:
      <input type="text" name="description" id="description">

      <input type="hidden" name="user_id" id="user_id" value="0">

      <input type="submit" value="Upload Image" name="submit">
    </form>
  </body>

</html>
