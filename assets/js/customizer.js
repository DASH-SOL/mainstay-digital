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
})(jQuery);
