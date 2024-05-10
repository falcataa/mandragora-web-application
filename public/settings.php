<?php include_once 'header.php'; ?>

<section class="section-settings">
  <div class="container">
    <div class="section-settings__box">
      <div class="section-settings__title">Жеке ақпарат</div>
      <?php
      session_start();
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
      } ?>
      <form action="includes/settings_script.php" method="POST" class="section-settings__grid"
        enctype="multipart/form-data">
        <div class="section-settings__input-wrapper">
          <label for="profile__name">Аты</label>
          <input name="first_name" type="text" class="section-settings__input" id="profile__name" />
        </div>
        <div class="section-settings__input-wrapper">
          <label for="profile__surname">Тегі</label>
          <input name="last_name" type="text" class="section-settings__input" id="profile__surname" />
        </div>
        <div class="section-settings__input-wrapper section-settings__input-wrapper_order">
          <label class="picture" for="profile__avatar">
            <span class="profile__avatar-desc"></span>
          </label>
          <input name="image_url" type="file" class="section-settings__input" id="profile__avatar" />
        </div>
        <div class="section-settings__input-wrapper">
          <label for="profile__city">Қала</label>
          <input name="city" type="text" class="section-settings__input" id="profile__city" />
        </div>
        <div class="section-settings__input-wrapper">
          <label for="profile__number">Телефон нөмірі</label>
          <input name="phone" type="tel" class="section-settings__input" id="profile__number" />
        </div>
        <div class="section-settings__input-wrapper">
          <label for="profile__mail">Пошта</label>
          <input name="email" type="email" class="section-settings__input" id="profile__mail" />
        </div>
        <div class="section-settings__btns">
          <button type="submit" class="button">Сақтау</button>
        </div>
      </form>
    </div>
    <div class="section-settings__box">
      <div class="section-settings__title">Тіркелгі рұқсаттары</div>
      <form action="includes/change_password.php" method="POST"
        class="section-settings__grid section-settings__grid_two-columns">
        <div class="section-settings__input-wrapper">
          <label for="profile__password">Жаңа құпия сөз</label>
          <input name="new_password" type="password" class="section-settings__input" id="profile__password"
            pattern="(?=.*\d)(?=.*[a-zA-Z]).{6,}"
            title="Құпия сөз 6-дан 30-ға дейін таңбадан тұруы керек және әріптерден де, сандардан да тұруы керек" />
        </div>
        <div class="section-settings__input-wrapper">
          <label for="profile__password-repeat">Жаңа құпия сөзді қайталаңыз</label>
          <input name="new_password_repeat" type="password" class="section-settings__input"
            id="profile__password-repeat" />
        </div>
        <div class="section-settings__btns section-settings__btns_span-2">
          <button type="submit" class="button">Сақтау</button>
        </div>
      </form>
    </div>
  </div>
</section>
<?php include_once 'footer.php'; ?>