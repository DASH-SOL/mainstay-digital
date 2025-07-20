(function ($) {
  "use strict";

  $(document).ready(function () {
    initMobileMenu();
    initSmoothScrolling();
    initHeaderScroll();
    initMegaMenu();

    // Simple direct accordion handler for debugging
    setTimeout(() => {
      console.log("Setting up accordion handlers...");
      setupAccordionHandlers();
    }, 1000);
  });

  function setupAccordionHandlers() {
    // Find all accordion triggers
    const triggers = document.querySelectorAll(".mobile-accordion-trigger");
    console.log("Found triggers:", triggers.length);

    triggers.forEach((trigger, index) => {
      console.log(`Trigger ${index}:`, trigger);
      console.log(`Data-accordion: ${trigger.getAttribute("data-accordion")}`);

      // Remove any existing event listeners and add new one
      trigger.removeEventListener("click", handleAccordionClick);
      trigger.addEventListener("click", handleAccordionClick);
    });
  }

  function handleAccordionClick(event) {
    event.preventDefault();
    event.stopPropagation();

    console.log("Accordion clicked!");
    console.log("Event target:", event.target);
    console.log("Current target:", event.currentTarget);

    const trigger = event.currentTarget;
    const accordionId = trigger.getAttribute("data-accordion");

    console.log("Accordion ID:", accordionId);

    if (!accordionId) {
      console.error("No accordion ID found!");
      return;
    }

    // Find the content
    const content = document.querySelector(`[data-content="${accordionId}"]`);
    console.log("Found content:", content);

    if (!content) {
      console.error("No content found for ID:", accordionId);
      return;
    }

    // Check current state
    const isActive = trigger.classList.contains("active");
    console.log("Is currently active:", isActive);

    // Toggle the classes
    if (isActive) {
      console.log("Removing active class...");
      trigger.classList.remove("active");
      content.classList.remove("active");
    } else {
      console.log("Adding active class...");
      trigger.classList.add("active");
      content.classList.add("active");
    }

    console.log("Trigger classes after:", trigger.className);
    console.log("Content classes after:", content.className);
    console.log("---");
  }

  function initMobileMenu() {
    const mobileMenuToggle = document.getElementById("mobile-menu-toggle");
    const mobileMenu = document.getElementById("mobile-menu");
    const mobileMenuOverlay = document.getElementById("mobile-menu-overlay");
    const mobileMenuClose = document.getElementById("mobile-menu-close");

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

      // Re-setup accordion handlers when menu opens
      setTimeout(() => {
        setupAccordionHandlers();
      }, 100);
    }

    if (mobileMenuClose) {
      mobileMenuClose.addEventListener("click", closeMobileMenu);
    }

    if (mobileMenuOverlay) {
      mobileMenuOverlay.addEventListener("click", closeMobileMenu);
    }

    document.addEventListener("keydown", function (e) {
      if (
        e.key === "Escape" &&
        mobileMenu &&
        mobileMenu.classList.contains("active")
      ) {
        closeMobileMenu();
      }
    });

    function closeAllAccordions() {
      const allTriggers = document.querySelectorAll(
        ".mobile-accordion-trigger"
      );
      const allContents = document.querySelectorAll(
        ".mobile-accordion-content"
      );

      allTriggers.forEach((trigger) => {
        trigger.classList.remove("active");
      });

      allContents.forEach((content) => {
        content.classList.remove("active");
      });
    }

    window.addEventListener("resize", function () {
      if (
        window.innerWidth >= 1024 &&
        mobileMenu &&
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
      if (header) {
        if (window.scrollY > 50) {
          header.classList.add("scrolled");
        } else {
          header.classList.remove("scrolled");
        }
      }
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

        const targetContent = document.querySelector(
          `[data-content="${menuIndex}"]`
        );
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
      if (
        !e.target.closest(".has-children") &&
        !e.target.closest(".mega-menu")
      ) {
        if (megaMenu) {
          megaMenu.classList.remove("opacity-100", "visible");
          megaMenu.classList.add("opacity-0", "invisible");
        }
      }
    });
  }
})(jQuery);
