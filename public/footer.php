</main>

<footer class="footer">
    <div class="container">
        <div class="footer__box">
            <div class="footer__first">
                Дипломдық жоба <span>Mandragora</span>
            </div>
            <div class="footer__second">Авторлары: Ақылбек пен Рабига</div>
        </div>
    </div>
</footer>
<div class="modal-add-post">
    <div class="modal-add-post__box">
        <div class="modal-add-post__content">
            <button class="button modal-add-post__close">
                <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 34 34" fill="none">
                    <path d="M1 1L33 33" stroke="white" stroke-width="2" stroke-linejoin="round" />
                    <path d="M33 1L1 33" stroke="white" stroke-width="2" stroke-linejoin="round" />
                </svg>
            </button>
            <form action="add_post.php" method="POST" enctype="multipart/form-data" class="modal-add-post__form">
                <div class="modal-add-post__input-wrapper">
                    <label for="modal-add-post__label_title" class="modal-add-post__label">
                        Жазбаның атауы
                    </label>
                    <input name="title" id="modal-add-post__label_title" type="text" class="modal-add-post__input"
                        placeholder="Жазбаның атын енгізіңіз" />
                </div>
                <div class="modal-add-post__input-wrapper">
                    <label for="modal-add-post__desc" class="modal-add-post__label">
                        Жазбаның сипаттамасы
                    </label>
                    <textarea name="description" id="modal-add-post__desc"
                        class="modal-add-post__input modal-add-post__textarea"
                        placeholder="Жазбаның сипаттамасын енгізіңіз"></textarea>
                </div>
                <div class="modal-add-post__input-wrapper">
                    <label class="modal-add-post__label_img" for="post-img">
                        <span class="modal-add-post__span"></span>
                    </label>
                    <input name="post_img" type="file" id="post-img" />
                </div>

                <button class="button" type="submit">Жазбаны қосу</button>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/gh/cferdinandi/tabby@12.0.0/dist/js/tabby.polyfills.min.js"></script>
<script src="js/swiper-bundle.min.js"></script>
<script src="js/swipers.js"></script>
<script src="js/main.js"></script>
</body>

</html>