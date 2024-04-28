<?php
include_once 'header.php'; // Подключаем header
// Получаем ID растения из URL
$plant_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Подключение конфигурации и базы данных
include 'includes/config.php';
$plant_images = [];
$transplantations = [];

if ($plant_id > 0) {
  $stmt = $mysqli->prepare("SELECT * FROM plants WHERE id = ? ORDER BY id ASC");
  $stmt->bind_param("i", $plant_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $plant = $result->fetch_assoc();

  // Запрос для получения изображений растения
  $img_stmt = $mysqli->prepare("SELECT image_url FROM plant_imgs WHERE plant_id = ? ORDER BY id ASC");
  $img_stmt->bind_param("i", $plant_id);
  $img_stmt->execute();
  $img_result = $img_stmt->get_result();
  while ($img_row = $img_result->fetch_assoc()) {
    $plant_images[] = $img_row['image_url'];
  }
  // Запрос для получения данных о пересадке
  $trans_stmt = $mysqli->prepare("SELECT image_url, description FROM transplantation WHERE plant_id = ? ORDER BY id ASC");
  $trans_stmt->bind_param("i", $plant_id);
  $trans_stmt->execute();
  $trans_result = $trans_stmt->get_result();
  while ($trans_row = $trans_result->fetch_assoc()) {
    $transplantations[] = $trans_row;
  }

  $img_stmt->close();
  $trans_stmt->close();
  $stmt->close();
}
$mysqli->close();
?>


<section class="section-catalog-banner">
  <div class="container">
    <div class="section-catalog-banner__heading">
      <span> Растение </span>
      <div class="section-catalog-banner__separator"></div>
      <h1><?php echo htmlspecialchars($plant['title']); ?></h1>
    </div>
  </div>
</section>

<section class="section-single">
  <div class="container">
    <a href="\catalog.php" class="section-single__back-link">
      <svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" viewBox="0 0 8 12" fill="none">
        <path d="M8 1.41L3.41 6L8 10.59L6.58 12L0.58 6L6.58 -6.20702e-08L8 1.41Z" fill="#343434" fill-opacity="0.6" />
      </svg>
      <span>каталог</span>
    </a>
    <div class="section-single__box">
      <div class="plant-swipers-wrapper">
        <div class="swiper-plants-thumbs">
          <div class="swiper-wrapper">
            <?php foreach ($plant_images as $image_url): ?>
              <div class="swiper-slide swiper-plants-thumbs__slide">
                <img src="<?php echo htmlspecialchars($image_url); ?>" alt="mandragora" />
              </div>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="swiper-plants">
          <div class="swiper-wrapper">
            <?php foreach ($plant_images as $image_url): ?>
              <div class="swiper-slide swiper-plants__slide">
                <img src="<?php echo htmlspecialchars($image_url); ?>" alt="mandragora" />
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <div class="section-single__info">
        <div class="section-single__title"><?php echo htmlspecialchars($plant['title']); ?></div>
        <div class="section-single__short-desc">
          <?php echo htmlspecialchars($plant['description']); ?>
        </div>
        <a href="#single-specifications" class="section-single__btn button">
          Смотреть характеристики
        </a>
      </div>
    </div>
  </div>
</section>

<section class="single-specifications" id="single-specifications">
  <div class="container">
    <ul class="single-specifications__tabs" data-tabs>
      <li>
        <a class="button" data-tabby-default href="#origin">Происхождение</a>
      </li>
      <li><a class="button" href="#care">Уход за растением</a></li>
      <li><a class="button" href="#science">Научные данные</a></li>
      <li><a class="button" href="#transfer">Пересадка</a></li>
    </ul>

    <div id="origin">
      <div class="single-specifications__box">
        <div class="single-specifications__tab-title">
          Происхождение растения
        </div>
        <div class="single-specifications__desc">
          <?php echo htmlspecialchars($plant['plant_origin']); ?>

        </div>
      </div>
    </div>
    <div id="care">
      <div class="single-specifications__box">
        <div class="single-specifications__tab-title">
          Уход за растением
        </div>
        <div class="single-specifications__tab-subtitle">
          <?php echo htmlspecialchars($plant['plant_care']); ?>
        </div>

      </div>
    </div>
    <div id="science">
      <div class="single-specifications__box">
        <div class="single-specifications__tab-title">
          Научные данные о растении
        </div>
        <div class="single-specifications__tab-subtitle">
          <?php echo htmlspecialchars($plant['scientific_data']); ?>
        </div>
      </div>
    </div>
    <div id="transfer">
      <div class="single-specifications__box">
        <div class="single-specifications__tab-title">
          Подготовка к пересадке
        </div>
        <div class="specifications-swiper">
          <div class="swiper-wrapper">
            <?php foreach ($transplantations as $transplant): ?>
              <div class="swiper-slide specifications-swiper__slide">
                <img src="<?php echo htmlspecialchars($transplant['image_url']); ?>" alt="mandragora" />
              </div>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="single-specifications__desc single-specifications__desc_one-column">
          <ol class="single-specifications__points">
            <?php foreach ($transplantations as $transplant): ?>
              <li>
                <p>
                  <?php echo nl2br(htmlspecialchars($transplant['description'])); ?>
                </p>
              </li>
            <?php endforeach; ?>
          </ol>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include_once 'footer.php'; ?>