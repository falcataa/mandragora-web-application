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
    <!-- Тут может быть ваша JavaScript проверка -->
  </head>
  <body>
    <form action="upload.php" method="post" enctype="multipart/form-data">
      Select image to upload:
      <input type="file" name="fileToUpload" id="fileToUpload">
      File name:
      <input type="text" name="fileName" id="fileName">
      Description:
      <input type="text" name="description" id="description">
      User ID:
      <input type="number" name="user_id" id="user_id" value="0">

      <input type="submit" value="Upload Image" name="submit">
    </form>
  </body>
</html>
