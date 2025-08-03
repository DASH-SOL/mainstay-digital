(function ($) {
  "use strict";

  $(document).ready(function () {
    initMobileMenu();
    initSmoothScrolling();
    initHeaderScroll();
    initMegaMenu();
    initRecentWorkFilters();
    initServicesAccordion();
    initDynamicServiceHeader();
    initTableOfContents(); // Add this here
    initSocialShare(); // Add this here too
  });

  function setupAccordionHandlers() {
    const mobileMenu = document.getElementById("mobile-menu");
    if (!mobileMenu) {
      return;
    }

    mobileMenu.removeEventListener("click", delegatedAccordionHandler);
    mobileMenu.addEventListener("click", delegatedAccordionHandler);
  }

  function delegatedAccordionHandler(event) {
    const trigger = event.target.closest(".mobile-accordion-trigger");
    
    if (!trigger) {
      return;
    }

    event.preventDefault();
    event.stopPropagation();
    event.stopImmediatePropagation();

    const accordionId = trigger.getAttribute("data-accordion");

    if (!accordionId) {
        return;
    }

    const content = document.querySelector(`[data-content="${accordionId}"]`);

    if (!content) {
        return;
    }

    const isCurrentlyActive = trigger.classList.contains("active");

    if (trigger.hasAttribute("data-processing")) {
      return;
    }

    trigger.setAttribute("data-processing", "true");

    if (isCurrentlyActive) {
        trigger.classList.remove("active");
        content.classList.remove("active");
        
        const arrow = trigger.querySelector(".accordion-arrow");
        if (arrow) {
          arrow.style.transform = "rotate(0deg)";
        }
    } else {
        const allTriggers = document.querySelectorAll(".mobile-accordion-trigger");
        const allContents = document.querySelectorAll(".mobile-accordion-content");
        
        allTriggers.forEach(t => {
          t.classList.remove("active");
          const arr = t.querySelector(".accordion-arrow");
          if (arr) arr.style.transform = "rotate(0deg)";
        });
        allContents.forEach(c => c.classList.remove("active"));
        
        trigger.classList.add("active");
        content.classList.add("active");
        
        const arrow = trigger.querySelector(".accordion-arrow");
        if (arrow) {
          arrow.style.transform = "rotate(180deg)";
        }
    }

    setTimeout(() => {
      trigger.removeAttribute("data-processing");
    }, 300);
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
      if (mobileMenu) {
        mobileMenu.classList.remove("active");
      }
      if (mobileMenuOverlay) {
        mobileMenuOverlay.classList.remove("active");
      }
      if (mobileMenuToggle) {
        mobileMenuToggle.classList.remove("active");
      }
      document.body.style.overflow = "";

      setTimeout(() => {
        closeAllAccordions();
      }, 300);
    }

    function openMobileMenu() {
      if (mobileMenu) {
        mobileMenu.classList.add("active");
      }
      if (mobileMenuOverlay) {
        mobileMenuOverlay.classList.add("active");
      }
      if (mobileMenuToggle) {
        mobileMenuToggle.classList.add("active");
      }
      document.body.style.overflow = "hidden";
      closeAllAccordions();

      setTimeout(() => {
        setupAccordionHandlers();
      }, 200);
    }

    if (mobileMenuClose) {
      mobileMenuClose.addEventListener("click", function() {
        closeMobileMenu();
      });
    }

    if (mobileMenuOverlay) {
      mobileMenuOverlay.addEventListener("click", function() {
        closeMobileMenu();
      });
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
      const allTriggers = document.querySelectorAll(".mobile-accordion-trigger");
      const allContents = document.querySelectorAll(".mobile-accordion-content");

      allTriggers.forEach((trigger) => {
        trigger.classList.remove("active");
        const arrow = trigger.querySelector(".accordion-arrow");
        if (arrow) arrow.style.transform = "rotate(0deg)";
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

  function initServicesAccordion() {
    const servicesAccordion = document.querySelector('.services-accordion');
    
    if (!servicesAccordion) return;

    // Remove any existing listeners first
    servicesAccordion.removeEventListener('click', handleServicesAccordionClick);
    servicesAccordion.addEventListener('click', handleServicesAccordionClick);
  }

  function handleServicesAccordionClick(event) {
    const trigger = event.target.closest('.service-accordion-trigger');
    
    if (!trigger) return;

    // Stop all event propagation immediately
    event.preventDefault();
    event.stopPropagation();
    event.stopImmediatePropagation();

    // Prevent rapid clicks
    if (trigger.hasAttribute('data-processing')) {
      return;
    }
    
    trigger.setAttribute('data-processing', 'true');

    const accordionId = trigger.getAttribute('data-service-accordion');
    if (!accordionId) {
      trigger.removeAttribute('data-processing');
      return;
    }

    const content = document.querySelector(`[data-service-content="${accordionId}"]`);
    if (!content) {
      trigger.removeAttribute('data-processing');
      return;
    }

    const isCurrentlyOpen = content.style.maxHeight && content.style.maxHeight !== "0px" && content.style.maxHeight !== "0";

    // Close all service accordions first
    const servicesAccordion = document.querySelector('.services-accordion');
    const allTriggers = servicesAccordion.querySelectorAll('.service-accordion-trigger');
    const allContents = servicesAccordion.querySelectorAll('.service-accordion-content');
    
    allTriggers.forEach(t => {
      t.removeAttribute('data-processing');
      const plus = t.querySelector('.accordion-plus');
      const minus = t.querySelector('.accordion-minus');
      if (plus) plus.style.opacity = '1';
      if (minus) minus.style.opacity = '0';
    });
    
    allContents.forEach(c => {
      c.style.maxHeight = '0px';
    });

    // Open this accordion if it wasn't already open
    if (!isCurrentlyOpen) {
      setTimeout(() => {
        content.style.maxHeight = content.scrollHeight + 'px';
        
        const plus = trigger.querySelector('.accordion-plus');
        const minus = trigger.querySelector('.accordion-minus');
        if (plus) plus.style.opacity = '0';
        if (minus) minus.style.opacity = '1';
        
        trigger.removeAttribute('data-processing');
      }, 50);
    } else {
      trigger.removeAttribute('data-processing');
    }
  }

  function initDynamicServiceHeader() {
    const serviceHeader = document.querySelector('.service-header-content');
    
    if (!serviceHeader) return;

    function updateVerticalLinePosition() {
      const serviceLabel = serviceHeader.querySelector('.service-label');
      const serviceTitle = serviceHeader.querySelector('.service-title');
      
      if (!serviceLabel || !serviceTitle) return;

      // Get the container width (assuming max 1340px site container)
      const containerRect = serviceHeader.getBoundingClientRect();
      const containerWidth = Math.min(containerRect.width, 1340);

      // Get the widths of both text elements
      const labelRect = serviceLabel.getBoundingClientRect();
      const titleRect = serviceTitle.getBoundingClientRect();

      const labelWidth = labelRect.width;
      const titleWidth = titleRect.width;

      // Based on your working example:
      // - Title width: 90% of container
      // - Top line: 1200px
      // - Bottom border: 1200px  
      // - Vertical line: 1150px

      // Calculate proportional values based on container width
      const baseContainerWidth = 1340; // Your site container max width
      const scaleFactor = containerWidth / baseContainerWidth;

      // Reference values that work (scaled proportionally)
      const referenceTopLineWidth = Math.min(1200 * scaleFactor, containerWidth * 0.9);
      const referenceBottomBorderWidth = Math.min(1200 * scaleFactor, containerWidth * 0.9);
      const referenceVerticalLinePosition = Math.min(1150 * scaleFactor, containerWidth * 0.85);

      // For different title lengths, we'll adjust these values
      const titleWidthRatio = titleWidth / (containerWidth * 0.9); // How much of 90% does title use

      let topLineWidth, bottomBorderWidth, linePosition;

      if (titleWidthRatio > 0.7) {
        // Long title case (like your example)
        topLineWidth = referenceTopLineWidth;
        bottomBorderWidth = referenceBottomBorderWidth;
        linePosition = referenceVerticalLinePosition;
      } else if (titleWidthRatio > 0.4) {
        // Medium title case
        topLineWidth = Math.max(referenceTopLineWidth * 0.8, 800 * scaleFactor);
        bottomBorderWidth = Math.max(referenceBottomBorderWidth * 0.7, 600 * scaleFactor);
        linePosition = Math.max(referenceVerticalLinePosition * 0.8, 700 * scaleFactor);
      } else {
        // Short title case
        topLineWidth = Math.max(600 * scaleFactor, 400);
        bottomBorderWidth = Math.max(400 * scaleFactor, 300);
        linePosition = Math.max(500 * scaleFactor, 450);
      }

      // Ensure top line is always longer than bottom border
      topLineWidth = Math.max(topLineWidth, bottomBorderWidth + 50);

      // Keep vertical line within container bounds
      linePosition = Math.min(linePosition, containerWidth - 50);

      // Set CSS custom properties
      serviceHeader.style.setProperty('--vertical-line-position', `${linePosition}px`);
      serviceHeader.style.setProperty('--top-line-width', `${topLineWidth}px`);
      serviceHeader.style.setProperty('--bottom-border-width', `${bottomBorderWidth}px`);
    }

    // Update position on load
    setTimeout(updateVerticalLinePosition, 100);

    // Update position on window resize
    window.addEventListener('resize', updateVerticalLinePosition);

    // Update position if fonts are loaded later
    if (document.fonts) {
      document.fonts.ready.then(updateVerticalLinePosition);
    }
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

  function initRecentWorkFilters() {
    const filterTabs = document.querySelectorAll('.filter-tab');
    const workCards = document.querySelectorAll('.recent-work-card');
    
    if (filterTabs.length === 0 || workCards.length === 0) return;
    
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            
            filterTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            workCards.forEach((card) => {
                const categories = card.getAttribute('data-categories') || '';
                
                if (filter === 'all') {
                    card.classList.remove('filtered-out');
                } else if (categories.includes(filter)) {
                    card.classList.remove('filtered-out');
                } else {
                    card.classList.add('filtered-out');
                }
            });
        });
    });
  }

  function initTableOfContents() {
    const tocContainer = document.getElementById('tableOfContents');
    const contentArea = document.querySelector('.single-blog-template-post-content');
    
    if (!tocContainer || !contentArea) return;
    
    // Clear any existing content first to prevent duplicates
    tocContainer.innerHTML = '';
    
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

  // Blog filter initialization
  function initBlogFilters() {
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
  }

  // Initialize blog filters when DOM is ready
  $(document).ready(function() {
    initBlogFilters();
  });

})(jQuery);

// Remove the duplicate DOMContentLoaded event listeners below
// They were causing the table of contents to initialize twice