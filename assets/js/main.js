(function ($) {
  "use strict";

  $(document).ready(function () {
    initMobileMenu();
    initSmoothScrolling();
    initHeaderScroll();
    initMegaMenu();
  });

  function initMobileMenu() {
    const mobileMenuToggle = document.getElementById("mobile-menu-toggle");
    const mobileMenu = document.getElementById("mobile-menu");
    const mobileMenuOverlay = document.getElementById("mobile-menu-overlay");
    const mobileMenuClose = document.getElementById("mobile-menu-close");

    if (mobileMenuToggle) {
      mobileMenuToggle.addEventListener("click", function () {
        mobileMenu.classList.add("active");
        mobileMenuOverlay.classList.add("active");
        document.body.style.overflow = "hidden";
      });
    }

    function closeMobileMenu() {
      mobileMenu.classList.remove("active");
      mobileMenuOverlay.classList.remove("active");
      document.body.style.overflow = "";
    }

    if (mobileMenuClose) {
      mobileMenuClose.addEventListener("click", closeMobileMenu);
    }

    if (mobileMenuOverlay) {
      mobileMenuOverlay.addEventListener("click", closeMobileMenu);
    }

    const mobileNavItems = document.querySelectorAll(".mobile-nav-item");
    mobileNavItems.forEach((item) => {
      item.addEventListener("click", closeMobileMenu);
    });

    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape") {
        closeMobileMenu();
      }
    });
  }

  function initSmoothScrolling() {
    $('a[href*="#"]:not([href="#"])').on("click", function (e) {
      if (
        location.pathname.replace(/^\//, "") ===
          this.pathname.replace(/^\//, "") &&
        location.hostname === this.hostname
      ) {
        var target = $(this.hash);
        target = target.length
          ? target
          : $("[name=" + this.hash.slice(1) + "]");

        if (target.length) {
          e.preventDefault();
          $("html, body").animate(
            {
              scrollTop: target.offset().top - 80,
            },
            800
          );
        }
      }
    });
  }

  function initHeaderScroll() {
    window.addEventListener("scroll", function () {
      const header = document.querySelector(".site-header");
      if (window.scrollY > 50) {
        header.classList.add("scrolled");
      } else {
        header.classList.remove("scrolled");
      }
    });
  }

  function initMegaMenu() {
    const megaMenuItems = document.querySelectorAll(".has-children");
    let megaMenuTimeout;

    megaMenuItems.forEach((item) => {
      const megaMenu = item.querySelector(".mega-menu");

      item.addEventListener("mouseenter", function () {
        clearTimeout(megaMenuTimeout);

        megaMenuItems.forEach((otherItem) => {
          if (otherItem !== item) {
            otherItem.classList.remove("active");
          }
        });

        item.classList.add("active");
      });

      item.addEventListener("mouseleave", function () {
        megaMenuTimeout = setTimeout(() => {
          item.classList.remove("active");
        }, 150);
      });

      if (megaMenu) {
        megaMenu.addEventListener("mouseenter", function () {
          clearTimeout(megaMenuTimeout);
        });

        megaMenu.addEventListener("mouseleave", function () {
          megaMenuTimeout = setTimeout(() => {
            item.classList.remove("active");
          }, 150);
        });
      }
    });

    document.addEventListener("click", function (e) {
      if (!e.target.closest(".has-children")) {
        megaMenuItems.forEach((item) => {
          item.classList.remove("active");
        });
      }
    });
  }
})(jQuery);
