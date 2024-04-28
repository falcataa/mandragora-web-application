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
    Добавьте фото растения (выберите сразу все фотографии):
    <input type="file" name="fileToUpload[]" id="fileToUpload" multiple>

    Название:
    <input type="text" name="flowerName" id="flowerName">

    Описание:
    <input type="text" name="flowerDescription" id="flowerDescription" style="width:200px; height:50px;">

    Происхождение:
    <input type="text" name="plantOrigin" id="plantOrigin" style="width:200px; height:50px;">

    Уход за растением:
    <input type="text" name="plantCare" id="plantCare" style="width:200px; height:50px;">

    Научные данные:
    <input type="text" name="scientificData" id="scientificData" style="width:200px; height:50px;">

    Пересадка шаг 1:
    <input type="file" name="anotherFileToUpload" id="anotherFileToUpload">

    Описание 1 пересадки:
    <input type="text" name="TransplantationDescription" id="TransplantationDescription1" style="width:200px; height:50px;">

    Фото пересадки 1
    <input type="file" name="TransplantationImage" id="TransplantationImage1">

    <input type="submit" value="Upload Form" name="submit">
  </form>
</body>

  </body>

</html>
