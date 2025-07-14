(function ($) {
  "use strict";

  wp.customize("custom_logo", function (value) {
    value.bind(function (newval) {
      if (newval) {
        const logoImg = wp.media.attachment(newval);
        logoImg.fetch().done(function () {
          const logoUrl = logoImg.get("url");
          const logoAlt = logoImg.get("alt") || wp.customize("blogname")();

          $(".logo-container a").html(
            '<img src="' +
              logoUrl +
              '" alt="' +
              logoAlt +
              '" class="custom-logo" style="width: 200px; height: 60px; object-fit: contain;">'
          );
          $("body").removeClass("no-custom-logo").addClass("has-custom-logo");
        });
      } else {
        $(".logo-container a").html(
          '<span class="logo-slashes">///</span><span class="logo-text">MAINSTAY</span>'
        );
        $("body").removeClass("has-custom-logo").addClass("no-custom-logo");
      }
    });
  });

  wp.customize("mainstay_logo_width", function (value) {
    value.bind(function (newval) {
      $(".custom-logo").css("width", newval + "px");
    });
  });

  wp.customize("mainstay_logo_height", function (value) {
    value.bind(function (newval) {
      $(".custom-logo").css("height", newval + "px");
    });
  });

  wp.customize("mainstay_footer_logo", function (value) {
    value.bind(function (newval) {
      if (newval) {
        const logoImg = wp.media.attachment(newval);
        logoImg.fetch().done(function () {
          const logoUrl = logoImg.get("url");
          const logoAlt = logoImg.get("alt") || wp.customize("blogname")();

          $(".footer-logo-container").html(
            '<img src="' +
              logoUrl +
              '" alt="' +
              logoAlt +
              '" class="footer-logo" style="width: 150px; height: auto; object-fit: contain;">'
          );
        });
      } else {
        $(".footer-logo-container").html(
          '<div class="footer-logo-text"><span class="footer-logo-slashes">///</span><span class="footer-logo-text-content">MAINSTAY</span></div>'
        );
      }
    });
  });

  wp.customize("mainstay_footer_logo_width", function (value) {
    value.bind(function (newval) {
      $(".footer-logo").css("width", newval + "px");
    });
  });

  wp.customize("mainstay_footer_heading_1", function (value) {
    value.bind(function (newval) {
      $(".footer-menu-column:first-child .footer-menu-heading").text(newval);
      $(
        ".footer-mobile-menu-section:first-child .footer-mobile-menu-heading"
      ).text(newval);
    });
  });

  wp.customize("mainstay_footer_heading_2", function (value) {
    value.bind(function (newval) {
      $(".footer-menu-column:nth-child(2) .footer-menu-heading").text(newval);
      $(
        ".footer-mobile-menu-section:nth-child(2) .footer-mobile-menu-heading"
      ).text(newval);
    });
  });

  wp.customize("mainstay_footer_heading_3", function (value) {
    value.bind(function (newval) {
      $(".footer-menu-column:last-child .footer-menu-heading").text(newval);
      $(
        ".footer-mobile-menu-section:last-child .footer-mobile-menu-heading"
      ).text(newval);
    });
  });

  wp.customize("mainstay_footer_button_text", function (value) {
    value.bind(function (newval) {
      $(".footer-cta-button, .footer-mobile-cta-button").text(newval);
    });
  });

  wp.customize("mainstay_footer_button_url", function (value) {
    value.bind(function (newval) {
      $(".footer-cta-button, .footer-mobile-cta-button").attr("href", newval);
    });
  });

  wp.customize("mainstay_footer_phone", function (value) {
    value.bind(function (newval) {
      $(
        ".footer-contact-item:has(.footer-contact-label:contains('P:')) .footer-contact-value"
      ).text(newval);
      $(
        ".footer-mobile-contact-item:has(.footer-mobile-contact-label:contains('P:')) .footer-mobile-contact-value"
      ).text(newval);
    });
  });

  wp.customize("mainstay_footer_email", function (value) {
    value.bind(function (newval) {
      $(
        ".footer-contact-item:has(.footer-contact-label:contains('E:')) .footer-contact-value"
      ).text(newval);
      $(
        ".footer-mobile-contact-item:has(.footer-mobile-contact-label:contains('E:')) .footer-mobile-contact-value"
      ).text(newval);
    });
  });

  wp.customize("mainstay_footer_address", function (value) {
    value.bind(function (newval) {
      $(
        ".footer-contact-item:has(.footer-contact-label:contains('A:')) .footer-contact-value"
      ).text(newval);
      $(
        ".footer-mobile-contact-item:has(.footer-mobile-contact-label:contains('A:')) .footer-mobile-contact-value"
      ).text(newval);
    });
  });

  wp.customize("mainstay_footer_copyright", function (value) {
    value.bind(function (newval) {
      $(".footer-copyright").text(newval);
    });
  });

  wp.customize("mainstay_footer_acknowledgment", function (value) {
    value.bind(function (newval) {
      $(".footer-acknowledgment").text(newval);
    });
  });
})(jQuery);
