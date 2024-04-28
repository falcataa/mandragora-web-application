<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: admin_login.php');
    exit;
}

$exampleParam = $_GET['upload_status'];
if ($exampleParam == '' || $exampleParam == null) {}
else {echo $exampleParam;}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Admin Panel</title>
  <link rel="stylesheet" type="text/css" href="./css/admin-style.css">

<script>
let stepCount = 2;

function addTransplantationStep() {
    let transplantationStepsDiv = document.getElementById('transplantationSteps');

    let newStepDiv = document.createElement('div');
    newStepDiv.innerHTML = `
    Пересадка шаг ${stepCount}:
    <input type="file" name="TransplantationImage${stepCount}" id="TransplantationImage${stepCount}">

    Описание ${stepCount} пересадки:
    <input type="text" name="TransplantationDescription${stepCount}" id="TransplantationDescription${stepCount}" style="width:200px; height:50px;">
    `;

    transplantationStepsDiv.appendChild(newStepDiv);

    stepCount++;
}
</script>


</head>

<body>
<div style="float:left; margin-left:20px;">
  <h2>Загрузить растения</h2>
    <form action="upload.php" method="post" enctype="multipart/form-data" class="center-form">
      Добавьте фото растения (выберите сразу все фотографии):
      <input type="file" name="fileToUpload[]" id="fileToUpload" multiple>

      Название:
      <input type="text" name="flowerName" id="flowerName" style="width:200px;">

      Описание:
      <input type="text" name="flowerDescription" id="flowerDescription" style="width:200px; height:50px;">

      Происхождение:
      <input type="text" name="plantOrigin" id="plantOrigin" style="width:200px; height:50px;">

      Уход за растением:
      <input type="text" name="plantCare" id="plantCare" style="width:200px; height:50px;">

      Научные данные:
      <input type="text" name="scientificData" id="scientificData" style="width:200px; height:50px;">

      Пересадка шаг 1:
      <input type="file" name="TransplantationImage1" id="TransplantationImage1">

      Описание 1 пересадки:
      <input type="text" name="TransplantationDescription1" id="TransplantationDescription1" style="width:200px; height:50px;">

      <div id="transplantationSteps"></div>

      <button type="button" onclick="addTransplantationStep()">Добавить шаг пересадки</button>

      <input type="submit" value="Upload Form" name="submit">
  </form>
</div>


    <div style="float:right; margin-right:20px;"> 
        <h2>Данные о растениях</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Описание</th>
                <th>Дата загрузки</th>
            </tr>

            <?php
            // Подключение к базе данных
            $dbh = new PDO('mysql:host=localhost;dbname=mandragora', 'dev', 'DarkhanBestProgrammerSuckHisDIck!!_27');

            // Выполнение запроса SELECT
            $stmt = $dbh->query('SELECT id, title, description, posted_at FROM plants');
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['title'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td>" . $row['posted_at'] . "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>




</body>

</html>
