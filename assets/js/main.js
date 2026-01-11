document.addEventListener("DOMContentLoaded", () => {
  const burger = document.querySelector(".header__burger");
  const menu = document.querySelector(".header__menu");
  const body = document.body;

  if (burger && menu) {
    burger.addEventListener("click", () => {
      burger.classList.toggle("active");
      menu.classList.toggle("active");
      body.classList.toggle("lock");

      const isExpended = burger.classList.contains("active");
      burger.setAttribute("aria-expended", isExpended);
    });

    menu.querySelectorAll("a").forEach((link) => {
      link.addEventListener("click", () => {
        burger.classList.remove("active");
        menu.classList.remove("active");
        body.classList.remove("lock");
        burger.setAttribute("aria-expended", false);
      });
    });
  }
});
