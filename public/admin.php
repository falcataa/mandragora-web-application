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

  <link rel="stylesheet" type="text/css" href="./css/admin-style.css?<?php echo uniqid(); ?>">
  <link rel="stylesheet" type="text/css" href="./css/normalize.css">

<script>
  const urlParams = new URLSearchParams(window.location.search);
  const upload_status = urlParams.get('upload_status');
  if (upload_status != null){
    alert(upload_status);
  }
</script>

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
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form'); // Получаем форму

    form.addEventListener('submit', function(event) {
        const inputs = document.querySelectorAll('input[type="text"], textarea'); // Получаем все текстовые поля и textarea

        inputs.forEach(function(input) {
            const maxLength = input.maxLength; // Максимальная длина поля
            const forbiddenCharacters = /[&<>"'/]/g; // Запрещенные символы

            if (input.value.length > maxLength) {
                alert(`Длина текста в поле '${input.name}' превышает допустимое значение (${maxLength}).`);
                event.preventDefault(); // Отменяем отправку формы
            }

            if (forbiddenCharacters.test(input.value)) {
                alert(`Поле '${input.name}' содержит запрещенные символы.`);
                event.preventDefault(); // Отменяем отправку формы
            }
        });
    });
});
</script>
<script>
function confirmDelete() {
    var result = confirm("Вы уверены, что хотите удалить этот пост?");
    
    if (result) {
        // Если пользователь нажал "ОК", отправляем форму
        return true;
    } else {
        // Если пользователь нажал "Отмена", отменяем отправку формы
        return false;
    }
}
</script>
</head>

<body>
<section class="section-admin">
<div class="left-div">
  <h2>Загрузить растения</h2>
    <form action="upload.php" method="post" enctype="multipart/form-data" class="center-form">
      Добавьте фото растения (выберите сразу все фотографии):
      <input type="file" name="fileToUpload[]" id="fileToUpload" multiple>

      Название:
      <input type="textarea" name="flowerName" id="flowerName" style="width:200px;">

      Описание:
      <input type="textarea" name="flowerDescription" id="flowerDescription" style="width:200px; height:50px;">

      Происхождение:
      <input type="textarea" name="plantOrigin" id="plantOrigin" style="width:200px; height:50px;">

      Уход за растением:
      <input type="textarea" name="plantCare" id="plantCare" style="width:200px; height:50px;">

      Научные данные:
      <input type="textare" name="scientificData" id="scientificData" style="width:200px; height:50px;">

      Пересадка шаг 1:
      <input type="file" name="TransplantationImage1" id="TransplantationImage1">

      Описание 1 пересадки:
      <input type="textarea" name="TransplantationDescription1" id="TransplantationDescription1" style="width:200px; height:50px;">

      <div id="transplantationSteps"></div>

      <button type="button" onclick="addTransplantationStep()">Добавить шаг пересадки</button>

      <input type="submit" value="Upload Form" name="submit">
  </form>
</div>


    <div class="right-div"> 
        <h2>Данные о растениях</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Фото</th>
                <th>Название</th>
                <th>Описание</th>
                <th>Дата загрузки</th>
            </tr>

            <?php
            // Подключение к базе данных
            $dbh = new PDO('mysql:host=localhost;dbname=mandragora', 'dev', 'DarkhanBestProgrammerSuckHisDIck!!_27');

            // Выполнение запроса SELECT
            $stmt = $dbh->query('SELECT id, main_image_url, title, description, posted_at FROM plants');
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td><img src='uploads/" . $row['main_image_url'] . "' class='small-image'></td>";
                echo "<td>" . $row['title'] . "</td>";
                $description = (strlen($row['description']) > 20) ? substr($row['description'], 0, 20) . '...' : $row['description'];
                echo "<td>" . $description . "</td>";
                echo "<td>" . $row['posted_at'] . "</td>";
                echo "<td><form method='post' action='delete_post.php'><input type='hidden' name='post_id' value='" . $row['id'] . "'><button type='submit' name='delete' onclick='return confirmDelete()'>Удалить</button></form></td>";
                echo "</tr>";
              }
            ?>
        </table>
    </div>
</section>
</body>

</html>
