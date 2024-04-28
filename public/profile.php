<?php include_once 'header.php'; ?>
<?php

session_start(); // Начало сессии

include 'includes/config.php'; // Подключение файла конфигурации базы данных

// Проверяем, залогинен ли пользователь
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php'); // Перенаправляем на страницу входа, если пользователь не залогинен
  exit;
}

$user_id = $_SESSION['user_id']; // Получаем ID текущего пользователя из сессии

// Подготовка запроса для получения данных пользователя
$stmt = $mysqli->prepare("SELECT login, image_url, first_name, last_name, city, phone, email, created_at FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();
?>

<section class="section-profile">
  <div class="container">
    <div class="section-profile__box">
      <div class="section-profile__left">
        <div class="section-profile__avatar-wrapper">
          <img class="section-profile__avatar-img"
            src="src/avatars/<?php echo htmlspecialchars($user['image_url'] ?: 'src/img/avatar.webp'); ?>"
            alt="mandragora" />
        </div>
        <a href="settings.php" class="button"> Редактировать профиль </a>
      </div>
      <div class="section-profile__right">
        <div class="section-profile__info">
          <div class="section-profile__info-top">
            <div class="section-profile__name">
              <span>
                <?php echo htmlspecialchars($user['first_name'] ?: 'Фамилия'); ?>
              </span>
              <span>
                <?php echo htmlspecialchars($user['last_name'] ?: 'Имя'); ?>
              </span>
            </div>
          </div>
          <div class="section-profile__info-bottom">
            <div class="section-profile__secondary-info">
              <h3>Дата регистрации:</h3>
              <p><?php echo htmlspecialchars($user['created_at']); ?></p>
              <h3>Город:</h3>
              <p><?php echo htmlspecialchars($user['city'] ?: 'Не указан'); ?></p>
              <h3>Номер телефона:</h3>
              <a
                href="tel:<?php echo htmlspecialchars($user['phone']); ?>"><?php echo htmlspecialchars($user['phone'] ?: 'Не указан'); ?></a>
              <h3>Почта:</h3>
              <a
                href="mailto:<?php echo htmlspecialchars($user['email']); ?>"><?php echo htmlspecialchars($user['email'] ?: 'Не указан'); ?></a>
            </div>
          </div>
        </div>
        <div class="section-profile__posts">
          <div class="section-profile__title">Мои посты</div>
          <?php


          if (isset($_SESSION['error'])) {
            echo '<div class="alert"><div class="alert__icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
          <path fill-rule="evenodd" clip-rule="evenodd"
            d="M8.4845 2.49499C9.15808 1.32833 10.842 1.32833 11.5156 2.495L17.7943 13.37C18.4678 14.5367 17.6259 15.995 16.2787 15.995H3.72136C2.37421 15.995 1.53224 14.5367 2.20582 13.37L8.4845 2.49499ZM10 5C10.4142 5 10.75 5.33579 10.75 5.75V9.25C10.75 9.66421 10.4142 10 10 10C9.58579 10 9.25 9.66421 9.25 9.25L9.25 5.75C9.25 5.33579 9.58579 5 10 5ZM10 14C10.5523 14 11 13.5523 11 13C11 12.4477 10.5523 12 10 12C9.44772 12 9 12.4477 9 13C9 13.5523 9.44772 14 10 14Z"
            fill="#CA383A" />
        </svg>
      </div>
      <div class="alert__title">' . $_SESSION['error'] . '</div></div>';
            unset($_SESSION['error']);
          }
          if (isset($_SESSION['success'])) {
            echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
            unset($_SESSION['success']);
          }
          ?>
          <div class="section-profile__posts-box">
            <?php
            $stmt = $mysqli->prepare("SELECT * FROM posts WHERE user_id = ? ORDER BY id DESC");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo "<div class='user-post'>";
                if (!empty($row['main_image_url'])) {
                  echo "<img src='{$row['main_image_url']}' alt='mandragora' class='user-post__img'>";
                }
                echo "<div class='user-post__heading'>";
                if (!empty($row['title'])) {
                  echo "<div class='user-post__title'>{$row['title']}</div>";
                }
                if (!empty($row['posted_at'])) {
                  echo "<div class='user-post__date'>{$row['posted_at']}</div>";
                }
                echo "</div>"; // Закрытие user-post__heading
            
                if (!empty($row['description'])) {
                  echo "<div class='user-post__desc'>{$row['description']}</div>";
                }
                echo "<button class='button delete-post-btn' data-post-id='{$row['id']}'>Удалить пост</button>";
                echo "</div>"; // Закрытие user-post
              }
            } else {
              echo "<div class='section-profile__posts-no-image'><img src='src/img/posts-no.webp' alt='mandragora'></div>";
              echo "<div class='section-profile__posts-desc'>У вас еще нет постов</div>";
            }

            $stmt->close();
            $mysqli->close();
            ?>
            <button class="button section-profile__posts-btn modal-add-post__caller">
              Добавить пост
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include_once 'footer.php'; ?>