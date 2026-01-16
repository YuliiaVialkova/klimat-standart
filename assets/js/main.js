document.addEventListener("DOMContentLoaded", () => {
  // === 1. ЛОГІКА БУРГЕР-МЕНЮ ===
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

  // === 2. ДИНАМІЧНА ВИСОТА ХЕДЕРА ===
  const header = document.querySelector(".header");

  function updateHeaderHeight() {
    if (!header) return;

    const height = header.offsetHeight;

    document.documentElement.style.setProperty(
      "--header-height",
      `${height}px`
    );
  }
  updateHeaderHeight();

  window.addEventListener("resize", updateHeaderHeight);

  // === СЛАЙДЕР СЕРТИФІКАТІВ ===
  if (document.querySelector(".glightbox")) {
    const lightbox = GLightbox({
      selector: ".glightbox",
      touchNavigation: true,
      loop: true,
      zoomable: true,
    });

    // === ВИПРАВЛЕННЯ ПОМИЛКИ ARIA-HIDDEN ===
    // Коли слайдер починає відкриватися...
    lightbox.on("open", () => {
      // ...ми примусово знімаємо фокус з натиснутого посилання
      if (document.activeElement instanceof HTMLElement) {
        document.activeElement.blur();
      }
    });
  }
});
