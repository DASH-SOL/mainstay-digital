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
    const accordionTriggers = document.querySelectorAll(
      ".mobile-accordion-trigger"
    );

    // Open mobile menu
    if (mobileMenuToggle) {
      mobileMenuToggle.addEventListener("click", function () {
        openMobileMenu();
      });
    }

    // Close mobile menu functions
    function closeMobileMenu() {
      mobileMenu.classList.remove("active");
      mobileMenuOverlay.classList.remove("active");
      mobileMenuToggle.classList.remove("active");
      document.body.style.overflow = "";

      // Close all accordions
      setTimeout(() => {
        closeAllAccordions();
      }, 300);
    }

    function openMobileMenu() {
      mobileMenu.classList.add("active");
      mobileMenuOverlay.classList.add("active");
      mobileMenuToggle.classList.add("active");
      document.body.style.overflow = "hidden";
      closeAllAccordions();
    }

    // Close menu events
    if (mobileMenuClose) {
      mobileMenuClose.addEventListener("click", closeMobileMenu);
    }

    if (mobileMenuOverlay) {
      mobileMenuOverlay.addEventListener("click", closeMobileMenu);
    }

    // Close on escape key
    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape" && mobileMenu.classList.contains("active")) {
        closeMobileMenu();
      }
    });

    // Close on menu item click (for actual links)
    const mobileNavLinks = document.querySelectorAll(
      ".mobile-nav-item:not(.mobile-accordion-trigger)"
    );
    mobileNavLinks.forEach((link) => {
      if (link.tagName === "A") {
        link.addEventListener("click", closeMobileMenu);
      }
    });

    // Accordion functionality
    accordionTriggers.forEach((trigger) => {
      trigger.addEventListener("click", function (e) {
        e.preventDefault();
        const accordionId = this.getAttribute("data-accordion");
        const content = document.querySelector(
          `[data-content="${accordionId}"]`
        );

        if (!content) return;

        const isActive = this.classList.contains("active");

        if (isActive) {
          // Close this accordion
          closeAccordion(this, content);
        } else {
          // Close other accordions at the same level
          const level = accordionId.split("-").length;
          closeAccordionsAtLevel(level);

          // Open this accordion
          openAccordion(this, content);
        }
      });
    });

    function openAccordion(trigger, content) {
      trigger.classList.add("active");
      content.classList.add("active");
    }

    function closeAccordion(trigger, content) {
      trigger.classList.remove("active");
      content.classList.remove("active");
    }

    function closeAccordionsAtLevel(level) {
      accordionTriggers.forEach((trigger) => {
        const triggerLevel = trigger
          .getAttribute("data-accordion")
          .split("-").length;
        if (triggerLevel === level) {
          const accordionId = trigger.getAttribute("data-accordion");
          const content = document.querySelector(
            `[data-content="${accordionId}"]`
          );
          if (content) {
            closeAccordion(trigger, content);
          }
        }
      });
    }

    function closeAllAccordions() {
      accordionTriggers.forEach((trigger) => {
        const accordionId = trigger.getAttribute("data-accordion");
        const content = document.querySelector(
          `[data-content="${accordionId}"]`
        );
        if (content) {
          closeAccordion(trigger, content);
        }
      });
    }

    // Handle window resize
    window.addEventListener("resize", function () {
      if (
        window.innerWidth >= 1024 &&
        mobileMenu.classList.contains("active")
      ) {
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
