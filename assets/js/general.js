jQuery(document).ready(function($) {

  // setting all the variables
  var nav_btn         = $(".main-nav-toggler")[0];
  var menu            = $(".main-menu");
  var menu_list_item  = $(".main-menu li");
  var top_btn         = $(".back-to-top")[0];
  var footer          = $(".wavesound-footer .rights");
  var footer_offset   = $(footer).offset().top;

  // working with rem. So getting the font-size of the rendered html
  var html            = $("html")[0];
  var rem             = parseInt(window.getComputedStyle(html)["fontSize"]);

  // navigation toggle
  nav_btn.onclick = function () {
    $(this).toggleClass("toggled");
    $(menu).addClass("menu-is-open menu-fade-in");
    $("body").addClass("modal-open");
    toggleSlide();

    function toggleSlide() {
      $(menu_list_item).each(function(i) {

        setTimeout(function() {
          $(".main-menu .nr-" + i + "").toggleClass("slide-in");

          // wait until animation is finished then remove classes
          if(i == $(menu_list_item).length - 1 && !$(nav_btn).hasClass( "toggled" ) ) {
            setTimeout(function() {
              $(menu).removeClass("menu-fade-in");
              $("body").removeClass("modal-open");

              setTimeout(function() {
                  $(menu).removeClass("menu-is-open");
              }, 200);
            }, 200);
          }
        }, 100*i);

      });
    }

  }

  // to top button
  top_btn.onclick = function () {
    $("body,html").animate( { scrollTop: 0 }, 200);
    return false;
  }

  // function to make the to top button sticky, if footer is reached
  function top_btnPosition(){

    // $( window ).height() doesn't worked for me
    var window_bottom_pos = window.innerHeight + $(window).scrollTop();

    if ( window_bottom_pos - rem >= footer_offset ) {
      $( top_btn ).css({
          position: "absolute",
          bottom: footer.outerHeight(true),
          opacity: 1
      });
    } else if ( $(window).scrollTop() >= 100 ) {
      $( top_btn ).css({
          position: "fixed",
          bottom:  rem / 2,
          opacity: 1
      });
    } else {
      $( top_btn ).css({
          opacity: 0
      });
    }
    console.log(window_bottom_pos, footer_offset);
  }

  // run the function on scrolling on page
  $(window).scroll(top_btnPosition);
});
