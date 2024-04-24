document.addEventListener("DOMContentLoaded", () => {
  const passwordInputs = document.querySelectorAll("input[type='password']");

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

  const inputSearch = document.querySelector(".search-form__input");
  const formSearchWrapper = document.querySelector(".header__right");

  inputSearch.addEventListener("focus", function () {
    formSearchWrapper.classList.add("is_active");
  });

  inputSearch.addEventListener("blur", function () {
    formSearchWrapper.classList.remove("is_active");
  });

  if (document.querySelector("[data-tabs]")) {
    new Tabby("[data-tabs]");
  }

  if (window.location.pathname.includes("settings")) {
    const inputFile = document.querySelector("#profile__avatar");
    const pictureImage = document.querySelector(".profile__avatar-desc");
    const pictureImageTxt = "Выберите <br/> изображение";
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
    const pictureImageTxt = "Выберите <br/> изображение";
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
});
