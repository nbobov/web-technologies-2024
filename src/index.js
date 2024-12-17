document.querySelectorAll('.header__menu-button,.header__close-button').forEach((button) => {
  button.addEventListener("click", () => {
    document.querySelectorAll('.header__menu-button,.header__close-button,.header__navigation,.header__address,.menu__mail').forEach((element) => {
      element.classList.toggle('hidden');
    });

    document.querySelector('.header__title').classList.toggle('menu-header__title');

    document.querySelector('.header__container').classList.toggle('show-menu');
  })
})