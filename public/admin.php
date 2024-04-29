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

    <link rel="stylesheet" href="src/fonts/Gilroy/stylesheet.css" />
    <link rel="stylesheet" href="src/fonts/Inter/stylesheet.css" />
    <link rel="stylesheet" type="text/css" href="./css/normalize.css">
    <link rel="stylesheet" type="text/css" href="./css/admin-style.css">
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <link rel="stylesheet" type="text/css" href="./css/admin-style.css?<?php echo uniqid(); ?>">
    <!-- <link rel="stylesheet" type="text/css" href="./css/normalize.css"> -->

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const upload_status = urlParams.get('upload_status');
        if (upload_status != null) {
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
    <input type="textarea" name="TransplantationDescription${stepCount}" id="TransplantationDescription${stepCount}">
    `;

            transplantationStepsDiv.appendChild(newStepDiv);

            stepCount++;
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form'); // Получаем форму

            form.addEventListener('submit', function (event) {
                const inputs = document.querySelectorAll('input[type="text"]'); // Получаем все текстовые поля и textarea

                inputs.forEach(function (input) {
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
    <section class="section-register section-login section-admin">
        <div class="container">
            <div class="section-admin__box">
                <div class="section-admin__wrapper">
                    <h1 class="section-admin__heading">Загрузить растения</h1>
                    <form action="upload.php" method="post" enctype="multipart/form-data" class="section-admin__form">
                        Добавьте фото растения (выберите сразу все фотографии):
                        <input type="file" name="fileToUpload[]" id="fileToUpload" multiple>

                        Название:
                        <input type="textarea" name="flowerName" id="flowerName">

                        Описание:
                        <!-- <input type="textarea" name="flowerDescription" id="flowerDescription" > -->
                        <textarea name="flowerDescription" id="flowerDescription"></textarea>

                        Происхождение:
                        <!-- <input type="textarea" name="plantOrigin" id="plantOrigin"> -->
                        <textarea name="plantOrigin" id="plantOrigin"></textarea>

                        Уход за растением:
                        <!-- <input type="textarea" name="plantCare" id="plantCare"> -->
                        <textarea name="plantCare" id="plantCare"></textarea>

                        Научные данные:
                        <!-- <input type="textare" name="scientificData" id="scientificData"> -->
                        <textarea name="scientificData" id="scientificData"></textarea>


                        Пересадка шаг 1:
                        <input type="file" name="TransplantationImage1" id="TransplantationImage1">

                        Описание 1 пересадки:
                        <input type="textarea" name="TransplantationDescription1" id="TransplantationDescription1">

                        <div id="transplantationSteps"></div>

                        <button class="button" type="button" onclick="addTransplantationStep()"
                            class="center-form">Добавить шаг
                            пересадки</button>

                        <input class="button" type="submit" value="Нажмите, если готовы добавить растение"
                            name="submit">
                    </form>
                </div>
                <div class="section-admin__wrapper section-admin__right">
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
                            echo "<td><form method='post' action='delete_admin.php'><input type='hidden' name='post_id' value='" . $row['id'] . "'><button type='submit' name='delete' onclick='return confirmDelete()'>Удалить</button></form></td>";
                            echo "</tr>";
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </section>
</body>

</html>