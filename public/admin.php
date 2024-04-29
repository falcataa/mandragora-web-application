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
            newStepDiv.classList.add("transplantation-step")
            newStepDiv.innerHTML = `
            <div class="input-wrapper">
                <label for="TransplantationImage${stepCount}">
                    Пересадка шаг ${stepCount}:
                </label>
                <input type="file" name="TransplantationImage${stepCount}" id="TransplantationImage${stepCount}"/>
            </div>
            <div class="input-wrapper">
                <label for="TransplantationDescription${stepCount}">
                    Описание ${stepCount} пересадки:
                </label>
                <input type="text" name="TransplantationDescription${stepCount}" id="TransplantationDescription${stepCount}"/>
            </div>`;

            transplantationStepsDiv.appendChild(newStepDiv);

            stepCount++;
        }
    </script>
    <!-- <script>
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
    </script> -->
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
                        <div class="input-wrapper">
                            <label for="fileToUpload">
                                Добавьте фото растения (выберите сразу все фотографии):
                            </label>
                            <input type="file" name="fileToUpload[]" id="fileToUpload" multiple>
                        </div>

                        <div class="input-wrapper">
                            <label for="flowerName">
                                Название:
                            </label>
                            <input type="text" name="flowerName" id="flowerName">
                        </div>



                        <!-- <input type="textarea" name="flowerDescription" id="flowerDescription" > -->
                        <div class="input-wrapper">
                            <label for="flowerDescription">
                                Описание:
                            </label>
                            <textarea name="flowerDescription" id="flowerDescription"></textarea>
                        </div>


                        <!-- <input type="textarea" name="plantOrigin" id="plantOrigin"> -->
                        <div class="input-wrapper">
                            <label for="plantOrigin">
                                Происхождение:
                            </label>
                            <textarea name="plantOrigin" id="plantOrigin"></textarea>
                        </div>

                        <!-- <input type="textarea" name="plantCare" id="plantCare"> -->
                        <div class="input-wrapper">
                            <label for="plantCare">
                                Уход за растением:
                            </label>
                            <textarea name="plantCare" id="plantCare"></textarea>
                        </div>

                        <!-- <input type="textare" name="scientificData" id="scientificData"> -->
                        <div class="input-wrapper">
                            <label for="scientificData">
                                Научные данные:
                            </label>
                            <textarea name="scientificData" id="scientificData"></textarea>
                        </div>

                        <div class="input-wrapper">
                            <label for="TransplantationImage1">
                                Пересадка шаг 1:
                            </label>
                            <input type="file" name="TransplantationImage1" id="TransplantationImage1">
                        </div>

                        <div class="input-wrapper">
                            <label for="TransplantationDescription1">
                                Описание 1 пересадки:
                            </label>
                            <input type="text" name="TransplantationDescription1" id="TransplantationDescription1">
                        </div>

                        <div id="transplantationSteps"></div>

                        <button class="button" type="button" onclick="addTransplantationStep()"
                            class="center-form">Добавить шаг
                            пересадки</button>

                        <input class="button" type="submit" value="Нажмите, если готовы добавить растение"
                            name="submit">
                    </form>
                </div>
                <div class="section-admin__wrapper section-admin__right">
                    <h2 class="section-admin__heading">Данные о растениях</h2>
                    <table class="admin-table">
                        <tr>
                            <th>ID</th>
                            <th>Фото</th>
                            <th>Название</th>
                            <!-- <th>Описание</th> -->
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
                            // $description = (strlen($row['description']) > 20) ? substr($row['description'], 0, 20) . '...' : $row['description'];
                            // echo "<td>" . $description . "</td>";
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