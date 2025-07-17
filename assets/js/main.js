(function ($) {
  "use strict";

  $(document).ready(function () {
    initMobileMenu();
    initSmoothScrolling();
    initHeaderScroll();
    initMegaMenu();
    initServiceAccordion();
  });

  function initMobileMenu() {
    const mobileMenuToggle = document.getElementById("mobile-menu-toggle");
    const mobileMenu = document.getElementById("mobile-menu");
    const mobileMenuOverlay = document.getElementById("mobile-menu-overlay");
    const mobileMenuClose = document.getElementById("mobile-menu-close");
    const accordionTriggers = document.querySelectorAll(".mobile-accordion-trigger");

    if (mobileMenuToggle) {
      mobileMenuToggle.addEventListener("click", function () {
        openMobileMenu();
      });
    }

    function closeMobileMenu() {
      if (mobileMenu) mobileMenu.classList.remove("active");
      if (mobileMenuOverlay) mobileMenuOverlay.classList.remove("active");
      if (mobileMenuToggle) mobileMenuToggle.classList.remove("active");
      document.body.style.overflow = "";
      setTimeout(() => {
        closeAllAccordions();
      }, 300);
    }

    function openMobileMenu() {
      if (mobileMenu) mobileMenu.classList.add("active");
      if (mobileMenuOverlay) mobileMenuOverlay.classList.add("active");
      if (mobileMenuToggle) mobileMenuToggle.classList.add("active");
      document.body.style.overflow = "hidden";
      closeAllAccordions();
    }

    if (mobileMenuClose) {
      mobileMenuClose.addEventListener("click", closeMobileMenu);
    }

    if (mobileMenuOverlay) {
      mobileMenuOverlay.addEventListener("click", closeMobileMenu);
    }

    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape" && mobileMenu && mobileMenu.classList.contains("active")) {
        closeMobileMenu();
      }
    });

    const mobileNavLinks = document.querySelectorAll(".mobile-nav-item:not(.mobile-accordion-trigger)");
    mobileNavLinks.forEach((link) => {
      if (link.tagName === "A") {
        link.addEventListener("click", closeMobileMenu);
      }
    });

    accordionTriggers.forEach((trigger) => {
      trigger.addEventListener("click", function (e) {
        e.preventDefault();
        
        const accordionId = this.getAttribute("data-accordion");
        const content = document.querySelector(`[data-content="${accordionId}"]`);

        if (!content) return;

        const isActive = this.classList.contains("active");

        if (isActive) {
          closeAccordion(this, content);
        } else {
          const level = accordionId.split("-").length;
          closeAccordionsAtLevel(level);
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
        const triggerLevel = trigger.getAttribute("data-accordion").split("-").length;
        if (triggerLevel === level) {
          const accordionId = trigger.getAttribute("data-accordion");
          const content = document.querySelector(`[data-content="${accordionId}"]`);
          if (content) {
            closeAccordion(trigger, content);
          }
        }
      });
    }

    function closeAllAccordions() {
      accordionTriggers.forEach((trigger) => {
        const accordionId = trigger.getAttribute("data-accordion");
        const content = document.querySelector(`[data-content="${accordionId}"]`);
        if (content) {
          closeAccordion(trigger, content);
        }
      });
    }

    window.addEventListener("resize", function () {
      if (window.innerWidth >= 1024 && mobileMenu && mobileMenu.classList.contains("active")) {
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

  function initServiceAccordion() {
    const accordionTriggers = document.querySelectorAll(".service-accordion-trigger");

    accordionTriggers.forEach((trigger) => {
      trigger.addEventListener("click", function () {
        const accordionId = this.getAttribute("data-service-accordion");
        const content = document.querySelector(`[data-service-content="${accordionId}"]`);
        const plusIcon = this.querySelector(".accordion-plus");
        const minusIcon = this.querySelector(".accordion-minus");

        if (!content) return;

        const isActive = content.style.maxHeight && content.style.maxHeight !== "0px";

        accordionTriggers.forEach((otherTrigger) => {
          const otherId = otherTrigger.getAttribute("data-service-accordion");
          const otherContent = document.querySelector(`[data-service-content="${otherId}"]`);
          const otherPlusIcon = otherTrigger.querySelector(".accordion-plus");
          const otherMinusIcon = otherTrigger.querySelector(".accordion-minus");

          if (otherContent && otherId !== accordionId) {
            otherContent.style.maxHeight = "0px";
            if (otherPlusIcon && otherMinusIcon) {
              otherPlusIcon.style.opacity = "1";
              otherMinusIcon.style.opacity = "0";
            }
          }
        });

        if (isActive) {
          content.style.maxHeight = "0px";
          if (plusIcon && minusIcon) {
            plusIcon.style.opacity = "1";
            minusIcon.style.opacity = "0";
          }
        } else {
          content.style.maxHeight = content.scrollHeight + "px";
          if (plusIcon && minusIcon) {
            plusIcon.style.opacity = "0";
            minusIcon.style.opacity = "1";
          }
        }
      });
    });
  }

  function initMegaMenu() {
    const megaMenu = document.querySelector(".mega-menu");
    const menuItems = document.querySelectorAll(".nav-menu-item.has-children");
    const menuContents = document.querySelectorAll(".mega-menu-content");
    let currentTimeout;

    if (!megaMenu || !menuItems.length) return;

    menuItems.forEach((item) => {
      const menuIndex = item.getAttribute("data-menu");

      item.addEventListener("mouseenter", function () {
        clearTimeout(currentTimeout);

        menuContents.forEach((content) => {
          content.style.display = "none";
        });

        const targetContent = document.querySelector(`[data-content="${menuIndex}"]`);
        if (targetContent) {
          targetContent.style.display = "grid";
        }

        megaMenu.classList.remove("opacity-0", "invisible");
        megaMenu.classList.add("opacity-100", "visible");
      });

      item.addEventListener("mouseleave", function () {
        currentTimeout = setTimeout(() => {
          megaMenu.classList.remove("opacity-100", "visible");
          megaMenu.classList.add("opacity-0", "invisible");
        }, 150);
      });
    });

    if (megaMenu) {
      megaMenu.addEventListener("mouseenter", function () {
        clearTimeout(currentTimeout);
      });

      megaMenu.addEventListener("mouseleave", function () {
        megaMenu.classList.remove("opacity-100", "visible");
        megaMenu.classList.add("opacity-0", "invisible");
      });
    }

    document.addEventListener("click", function (e) {
      if (!e.target.closest(".has-children") && !e.target.closest(".mega-menu")) {
        if (megaMenu) {
          megaMenu.classList.remove("opacity-100", "visible");
          megaMenu.classList.add("opacity-0", "invisible");
        }
      }
    });
  }
})(jQuery);