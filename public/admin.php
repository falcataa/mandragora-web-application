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
    <body>
  <form action="upload.php" method="post" enctype="multipart/form-data" class="center-form">
    Select images to upload (you can select multiple images):
    <input type="file" name="fileToUpload[]" id="fileToUpload" multiple>

    Flower name:
    <input type="text" name="flowerName" id="flowerName">

    Flower description:
    <input type="text" name="flowerDescription" id="flowerDescription">

    Plant origin:
    <input type="text" name="plantOrigin" id="plantOrigin">

    Plant care:
    <input type="text" name="plantCare" id="plantCare">

    Scientific data:
    <input type="text" name="scientificData" id="scientificData">

    Select another image to upload:
    <input type="file" name="anotherFileToUpload" id="anotherFileToUpload">

    Another image description:
    <input type="text" name="anotherImageDescription" id="anotherImageDescription">

    <input type="submit" value="Upload Image" name="submit">
  </form>
</body>

  </body>

</html>
