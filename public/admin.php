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
    <input type="textarea" name="TransplantationDescription${stepCount}" id="TransplantationDescription${stepCount}" style="width:200px; height:50px;">
    `;

    transplantationStepsDiv.appendChild(newStepDiv);

    stepCount++;
}
</script>

<script>
$(document).ready(function() {
    $('#uploadPlantFrom').submit(function(e) {
        e.preventDefault(); // Предотвращаем стандартное поведение формы

        $.ajax({
            type: 'POST',
            url: 'upload.php', // Укажите путь к вашему обработчику формы
            data: $(this).serialize(),
            success: function(response) {
                // Обработка успешного ответа от сервера
                console.log(response);
                // Можно добавить здесь логику для обновления части страницы или вывода сообщения об успешной отправке
            },
            error: function(xhr, status, error) {
                // Обработка ошибок
                console.error(error);
            }
        });
    });
});
</script>


</head>

  <body>
  <form id="uploadPlantFrom" enctype="multipart/form-data" class="center-form">
    Добавьте фото растения (выберите сразу все фотографии):
    <input type="file" name="fileToUpload[]" id="fileToUpload" multiple>

    Название:
    <input type="text" name="flowerName" id="flowerName" style="width:200px;">

    Описание:
    <input type="textarea" name="flowerDescription" id="flowerDescription" style="width:200px; height:50px;">

    Происхождение:
    <input type="textarea" name="plantOrigin" id="plantOrigin" style="width:200px; height:50px;">

    Уход за растением:
    <input type="textarea" name="plantCare" id="plantCare" style="width:200px; height:50px;">

    Научные данные:
    <input type="textarea" name="scientificData" id="scientificData" style="width:200px; height:50px;">

    Пересадка шаг 1:
    <input type="file" name="TransplantationImage1" id="TransplantationImage1">

    Описание 1 пересадки:
    <input type="textarea" name="TransplantationDescription1" id="TransplantationDescription1" style="width:200px; height:50px;">

    <div id="transplantationSteps"></div>

    <button type="button" onclick="addTransplantationStep()">Добавить шаг пересадки</button>

    <input type="submit" value="Upload Form" name="submit">
</form>
</body>

</html>
