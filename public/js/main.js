document.addEventListener("DOMContentLoaded", () => {
  const passwordInputs = document.querySelectorAll("input[type='password']");

  if (passwordInputs) {
    passwordInputs.forEach((input) => {
      let eye = input.nextElementSibling;

      if (eye) {
        eye.addEventListener("click", function () {
          let show = eye.querySelector(".show");
          let hidden = eye.querySelector(".hidden");
          let type =
            input.getAttribute("type") === "password" ? "text" : "password";
          input.setAttribute("type", type);

          if (type == "password") {
            show.style.display = "none";
            hidden.style.display = "flex";
          } else {
            hidden.style.display = "none";
            show.style.display = "flex";
          }
        });
      }
    });
  }

  const inputSearch = document.querySelector(".search-form__input");
  const formSearchWrapper = document.querySelector(".header__right");

  if (inputSearch && formSearchWrapper) {
    inputSearch.addEventListener("focus", function () {
      formSearchWrapper.classList.add("is_active"); // Добавляем класс при фокусе на поле
    });

    inputSearch.addEventListener("blur", function () {
      // При потере фокуса проверяем, есть ли текст в поле ввода
      if (inputSearch.value.trim() === "") {
        formSearchWrapper.classList.remove("is_active"); // Удаляем класс, если поле пустое
      }
    });

    // Дополнительно, можно добавить обработчик для события ввода,
    // чтобы управлять классом динамически при изменении содержимого поля
    inputSearch.addEventListener("input", function () {
      if (inputSearch.value.trim() !== "") {
        formSearchWrapper.classList.add("is_active"); // Ещё раз добавляем класс, если в поле есть текст
      }
    });
  }

  if (document.querySelector("[data-tabs]")) {
    new Tabby("[data-tabs]");
  }

  if (window.location.pathname.includes("settings")) {
    const inputFile = document.querySelector("#profile__avatar");
    const pictureImage = document.querySelector(".profile__avatar-desc");
    const pictureImageTxt = "Cуретті <br/> таңдаңыз";
    pictureImage.innerHTML = pictureImageTxt;

    inputFile.addEventListener("change", function (e) {
      const inputTarget = e.target;
      const file = inputTarget.files[0];

      if (file) {
        const reader = new FileReader();

        reader.addEventListener("load", function (e) {
          const readerTarget = e.target;

          const img = document.createElement("img");
          img.src = readerTarget.result;
          img.classList.add("profile__avatar-img");

          pictureImage.innerHTML = "";
          pictureImage.appendChild(img);
        });

        reader.readAsDataURL(file);
      } else {
        pictureImage.innerHTML = pictureImageTxt;
      }
    });
  }

  if (window.location.pathname.includes("profile")) {
    const inputFile = document.querySelector("#post-img");
    const pictureImage = document.querySelector(".modal-add-post__span");
    const pictureImageTxt = "Cуретті <br/> таңдаңыз";
    pictureImage.innerHTML = pictureImageTxt;

    inputFile.addEventListener("change", function (e) {
      const inputTarget = e.target;
      const file = inputTarget.files[0];

      if (file) {
        const reader = new FileReader();

        reader.addEventListener("load", function (e) {
          const readerTarget = e.target;

          const img = document.createElement("img");
          img.src = readerTarget.result;
          img.classList.add("modal-add-post__img");

          pictureImage.innerHTML = "";
          pictureImage.appendChild(img);
        });

        reader.readAsDataURL(file);
      } else {
        pictureImage.innerHTML = pictureImageTxt;
      }
    });

    const modalCaller = document.querySelector(".modal-add-post__caller");
    const modalClose = document.querySelector(".modal-add-post__close");
    const modalWindow = document.querySelector(".modal-add-post");

    modalCaller.addEventListener("click", function () {
      modalWindow.classList.add("is_open");
    });

    modalClose.addEventListener("click", function () {
      modalWindow.classList.remove("is_open");
    });
  }
  if (document.querySelector("input[type='tel']")) {
    [].forEach.call(
      document.querySelectorAll('input[type="tel"]'),
      function (input) {
        var keyCode;
        function mask(event) {
          event.keyCode && (keyCode = event.keyCode);
          var pos = this.selectionStart;
          if (pos < 3) event.preventDefault();
          var matrix = "+7 (___) ___ ____",
            i = 0,
            def = matrix.replace(/\D/g, ""),
            val = this.value.replace(/\D/g, ""),
            new_value = matrix.replace(/[_\d]/g, function (a) {
              return i < val.length ? val.charAt(i++) : a;
            });
          i = new_value.indexOf("_");
          if (i !== -1) {
            if (i < 5) i = 3;
            new_value = new_value.slice(0, i);
          }
          var reg = matrix
            .substr(0, this.value.length)
            .replace(/_+/g, function (a) {
              return "\\d{1," + a.length + "}";
            })
            .replace(/[+()]/g, "\\$&");
          reg = new RegExp("^" + reg + "$");
          if (
            !reg.test(this.value) ||
            this.value.length < 5 ||
            (keyCode > 47 && keyCode < 58)
          ) {
            this.value = new_value;
          }
          if (event.type === "blur" && this.value.length < 5) {
            this.value = "";
          }
        }

        input.addEventListener("input", mask, false);
        input.addEventListener("focus", mask, false);
        input.addEventListener("blur", mask, false);
        input.addEventListener("keydown", mask, false);
      }
    );
  }

  document.querySelectorAll(".delete-post-btn").forEach((button) => {
    button.addEventListener("click", function () {
      const postId = this.getAttribute("data-post-id");
      if (confirm("Сіз бұл жазбаны жойғыңыз келетініне сенімдісіз бе?")) {
        fetch("../delete_post.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: "post_id=" + postId,
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.error) {
              alert(data.error);
            } else {
              alert(data.success);
              location.reload(); // Перезагрузка страницы после удаления
            }
          })
          .catch((error) => console.error("Ошибка:", error));
      }
    });
  });

  const searchInput = document.querySelector(".search-form__input");
  const resultsDiv = document.createElement("div");
  resultsDiv.className = "search-results";
  document
    .querySelector(".header .container .search-form")
    .appendChild(resultsDiv);

  searchInput.addEventListener("input", function () {
    const query = searchInput.value.trim();
    if (query.length > 1) {
      // Начинаем поиск, если введено более одного символа
      fetch(`../search.php?query=${encodeURIComponent(query)}`)
        .then((response) => response.json())
        .then((data) => {
          resultsDiv.innerHTML = ""; // Очищаем предыдущие результаты
          if (data.length > 0) {
            data.forEach((item) => {
              const resultItem = document.createElement("div");
              resultItem.className = "result-item";
              resultItem.innerHTML = `
                              <a href="single.php?id=${item.id}" class="result-link">
                                  <img src="../uploads/${item.image_url}" alt="${item.title}" />
                                  <p>${item.title}</p>
                              </a>
                          `;
              resultsDiv.appendChild(resultItem);
            });
          } else {
            resultsDiv.innerHTML = '<div class="no-results">Нәтиже жоқ</div>';
          }
        });
    } else {
      resultsDiv.innerHTML = ""; // Очищаем результаты, если строка поиска пуста или слишком коротка
    }
  });
});
