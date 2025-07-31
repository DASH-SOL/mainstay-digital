(function ($) {
  "use strict";

  $(document).ready(function () {
    initMobileMenu();
    initSmoothScrolling();
    initHeaderScroll();
    initMegaMenu();
    initRecentWorkFilters();
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

function initRecentWorkFilters() {
    const filterTabs = document.querySelectorAll('.filter-tab');
    const workCards = document.querySelectorAll('.recent-work-card');
    
    if (filterTabs.length === 0 || workCards.length === 0) return;
    
    console.log('Initializing Recent Work Filters');
    console.log('Found', filterTabs.length, 'filter tabs');
    console.log('Found', workCards.length, 'work cards');
    
    workCards.forEach((card, index) => {
        const categories = card.getAttribute('data-categories');
        console.log('Card', index, 'categories:', categories);
    });
    
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            console.log('Filter clicked:', filter);
            
            filterTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            workCards.forEach((card, index) => {
                const categories = card.getAttribute('data-categories') || '';
                console.log('Card', index, '- categories:', categories, '- filter:', filter);
                
                if (filter === 'all') {
                    card.classList.remove('filtered-out');
                    console.log('Card', index, '- showing (all)');
                } else if (categories.includes(filter)) {
                    card.classList.remove('filtered-out');
                    console.log('Card', index, '- showing (match)');
                } else {
                    card.classList.add('filtered-out');
                    console.log('Card', index, '- hiding (no match)');
                }
            });
        });
    });
}
function initTableOfContents() {
    const tocContainer = document.getElementById('tableOfContents');
    const contentArea = document.querySelector('.single-blog-template-post-content');
    
    if (!tocContainer || !contentArea) return;
    
    const headings = contentArea.querySelectorAll('h2, h3');
    
    if (headings.length === 0) {
        tocContainer.innerHTML = '<p class="single-blog-no-headings">No headings found</p>';
        return;
    }
    
    const tocList = document.createElement('ul');
    tocList.className = 'single-blog-toc-ul';
    
    headings.forEach((heading, index) => {
        const headingId = `heading-${index}`;
        heading.id = headingId;
        
        const listItem = document.createElement('li');
        listItem.className = 'single-blog-toc-item';
        
        const link = document.createElement('a');
        link.href = `#${headingId}`;
        link.textContent = heading.textContent;
        link.className = 'single-blog-toc-link';
        
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            document.querySelectorAll('.single-blog-toc-link').forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            
            document.getElementById(headingId).scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        });
        
        listItem.appendChild(link);
        tocList.appendChild(listItem);
    });
    
    tocContainer.appendChild(tocList);

    function highlightCurrentSection() {
        const headings = contentArea.querySelectorAll('h2, h3');
        const tocLinks = document.querySelectorAll('.single-blog-toc-link');
        let currentHeading = null;
        
        headings.forEach(heading => {
            const rect = heading.getBoundingClientRect();
            if (rect.top <= 100) {
                currentHeading = heading;
            }
        });
        
        tocLinks.forEach(link => link.classList.remove('active'));
        
        if (currentHeading) {
            const activeLink = document.querySelector(`[href="#${currentHeading.id}"]`);
            if (activeLink) {
                activeLink.classList.add('active');
            }
        }
    }

    let ticking = false;
    window.addEventListener('scroll', function() {
        if (!ticking) {
            requestAnimationFrame(function() {
                highlightCurrentSection();
                ticking = false;
            });
            ticking = true;
        }
    });
}

function initSocialShare() {
    const facebookBtns = document.querySelectorAll('.facebook');
    const twitterBtns = document.querySelectorAll('.twitter');
    const linkedinBtns = document.querySelectorAll('.linkedin');
    
    const currentUrl = encodeURIComponent(window.location.href);
    const pageTitle = encodeURIComponent(document.title);
    
    facebookBtns.forEach(btn => {
        btn.href = `https://www.facebook.com/sharer/sharer.php?u=${currentUrl}`;
        btn.target = '_blank';
        btn.rel = 'noopener';
    });
    
    twitterBtns.forEach(btn => {
        btn.href = `https://twitter.com/intent/tweet?url=${currentUrl}&text=${pageTitle}`;
        btn.target = '_blank';
        btn.rel = 'noopener';
    });
    
    linkedinBtns.forEach(btn => {
        btn.href = `https://www.linkedin.com/sharing/share-offsite/?url=${currentUrl}`;
        btn.target = '_blank';
        btn.rel = 'noopener';
    });
}

document.addEventListener('DOMContentLoaded', function() {
    initTableOfContents();
    initSocialShare();
});
document.addEventListener('DOMContentLoaded', function() {
    const filterContainer = document.querySelector('.blog-listings-filters');
    if (filterContainer) {
        const filterButtons = filterContainer.querySelectorAll('.filter-tab');
        const blogCards = document.querySelectorAll('.blog-listings-card');

        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                const filter = this.getAttribute('data-filter');

                blogCards.forEach(card => {
                    if (filter === 'all' || card.getAttribute('data-categories').includes(filter)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    }
});