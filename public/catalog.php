<?php include_once 'header.php'; ?>
<section class="section-catalog-banner">
  <div class="container">
    <div class="section-catalog-banner__heading">
      <span>Mandragora</span>
      <div class="section-catalog-banner__separator"></div>
      <h1>Каталог растений</h1>
    </div>
  </div>
</section>

<section class="section-catalog">
  <div class="container">
    <div class="section-catalog__box">
      <?php
      include_once 'includes/config.php'; // Подключаем конфигурационный файл
      
      // Запрос к базе данных для получения данных о растениях
      $query = "SELECT * FROM plants";
      $result = $mysqli->prepare($query);
      $result->execute();
      $result = $result->get_result();

      if ($result->num_rows > 0) {
        // Вывод данных о каждом растении
        while ($row = $result->fetch_assoc()) {
          $title = htmlspecialchars($row['title']);
          $desc = htmlspecialchars($row['description']);
          $img = htmlspecialchars($row['main_image_url']);
          $id = $row['id'];

          echo <<<HTML
          <div class="plant-card">
            <a href="single.php?id={$id}" class="plant-card__img-wrapper">
              <img class="plant-card__img" src="./uploads/{$img}" alt="{$title}" />
            </a>
            <div class="plant-card__bottom">
              <a href="single.php?id={$id}" class="plant-card__title">{$title}</a>
              <div class="plant-card__desc">{$desc}</div>
            </div>
            <a href="single.php?id={$id}" class="button plant-card__btn">Посмотреть</a>
          </div>
HTML;
        }
      } else {
        echo "Нет доступных растений.";
      }

      $mysqli->close();
      ?>
    </div>
  </div>
</section>

<?php include_once 'footer.php'; ?>