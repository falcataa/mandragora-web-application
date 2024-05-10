<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta property="og:title" content="Mandragora | өсімдіктер" />
  <meta property="og:description" content="Дипломдық жоба / Ақылбек пен Рабига жасаған" />
  <meta name="description" content="Дипломдық жоба / Ақылбек пен Рабига жасаған" />
  <title>Кіру беті | Mandragora</title>

  <link rel="stylesheet" href="src/fonts/Gilroy/stylesheet.css" />
  <link rel="stylesheet" href="src/fonts/Inter/stylesheet.css" />
  <link rel="stylesheet" href="css/normalize.css" />
  <link rel="stylesheet" href="css/swiper-bundle.min.css" />
  <link rel="stylesheet" href="css/style.css" />
</head>

<body>

  <section class="section-login">
    <div class="section-login__box">
      <div class="section-login__heading">Mandragora</div>
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
      }
      ?>
      <form action="includes/login_script.php" method="POST" class="section-login__form">
        <div class="login-input__wrapper">
          <input type="text" class="login-input" placeholder="Логин" name="username" />
          <svg xmlns="http://www.w3.org/2000/svg" width="6" height="7" viewBox="0 0 6 7" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
              d="M2.89748 1.17969C2.36627 1.17969 1.93602 1.62478 1.93602 2.17431C1.93602 2.72383 2.36627 3.16892 2.89748 3.16892C3.42869 3.16892 3.85894 2.72383 3.85894 2.17431C3.85894 1.62478 3.42869 1.17969 2.89748 1.17969ZM3.37829 2.17431C3.37829 1.90079 3.16196 1.677 2.89756 1.677C2.63316 1.677 2.41683 1.90079 2.41683 2.17431C2.41683 2.44783 2.63316 2.67162 2.89756 2.67162C3.16196 2.67162 3.37829 2.44783 3.37829 2.17431ZM4.33971 4.66085C4.29163 4.48431 3.5465 4.16355 2.89751 4.16355C2.25092 4.16355 1.5106 4.48182 1.45531 4.66085H4.33971ZM0.974609 4.66086C0.974609 3.99943 2.25576 3.66624 2.89754 3.66624C3.53932 3.66624 4.82047 3.99943 4.82047 4.66086V5.15817H0.974609V4.66086Z"
              fill="white" />
          </svg>
        </div>
        <div class="login-input__wrapper">
          <input type="password" class="login-input" placeholder="Құпия сөз" name="password" />
          <div class="login-input__eye">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="14" viewBox="0 0 20 14" fill="none" class="show">
              <path
                d="M10.0007 0.75C5.83398 0.75 2.27565 3.34167 0.833984 7C2.27565 10.6583 5.83398 13.25 10.0007 13.25C14.1715 13.25 17.7257 10.6583 19.1673 7C17.7257 3.34167 14.1715 0.75 10.0007 0.75ZM10.0007 11.1667C7.70065 11.1667 5.83398 9.3 5.83398 7C5.83398 4.7 7.70065 2.83333 10.0007 2.83333C12.3007 2.83333 14.1673 4.7 14.1673 7C14.1673 9.3 12.3007 11.1667 10.0007 11.1667ZM10.0007 4.5C8.62148 4.5 7.50065 5.62083 7.50065 7C7.50065 8.37917 8.62148 9.5 10.0007 9.5C11.3798 9.5 12.5007 8.37917 12.5007 7C12.5007 5.62083 11.3798 4.5 10.0007 4.5Z"
                fill="#fff" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17" fill="none"
              class="hidden">
              <path
                d="M10.0007 3.83333C12.3007 3.83333 14.1673 5.7 14.1673 8C14.1673 8.5375 14.059 9.05 13.8715 9.52083L16.309 11.9583C17.5673 10.9083 18.559 9.55 19.1715 8C17.7257 4.34167 14.1715 1.75 10.0007 1.75C8.83398 1.75 7.71732 1.95833 6.67982 2.33333L8.47982 4.12917C8.95065 3.94583 9.46315 3.83333 10.0007 3.83333ZM1.66732 1.5625L3.56732 3.4625L3.94648 3.84167C2.57148 4.91667 1.48398 6.34583 0.833984 8C2.27565 11.6583 5.83398 14.25 10.0007 14.25C11.2923 14.25 12.5257 14 13.6548 13.5458L14.009 13.9L16.4382 16.3333L17.5007 15.275L2.72982 0.5L1.66732 1.5625ZM6.27565 6.16667L7.56315 7.45417C7.52565 7.63333 7.50065 7.8125 7.50065 8C7.50065 9.37917 8.62148 10.5 10.0007 10.5C10.1882 10.5 10.3673 10.475 10.5423 10.4375L11.8298 11.725C11.2757 12 10.659 12.1667 10.0007 12.1667C7.70065 12.1667 5.83398 10.3 5.83398 8C5.83398 7.34167 6.00065 6.725 6.27565 6.16667ZM9.86315 5.5125L12.4882 8.1375L12.5007 8C12.5007 6.62083 11.3798 5.5 10.0007 5.5L9.86315 5.5125Z"
                fill="#fff" />
            </svg>
          </div>
        </div>
        <button type="submit" class="section-login__btn">Кіру</button>
      </form>
      <div class="section-login__register">
        <a href="register.php">Менің аккаунтым жоқ</a>
      </div>
    </div>
  </section>


  <script src="js/swiper-bundle.min.js"></script>
  <script src="js/swipers.js"></script>
  <script src="js/main.js"></script>
</body>

</html>