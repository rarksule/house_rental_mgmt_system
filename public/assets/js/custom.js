!(function (n) {
    "use strict";

    // Preloader Start
    $(window).on('load',function () {
        $('#preloaderInner').fadeOut();
        $('#preloader')
            .delay(350)
            .fadeOut('slow');
        $('body')
            .delay(350)
    });
    // Preloader End

  /*---------------------------------
    Top Menu / Side Menu JS
  -----------------------------------*/
    function s() {
        for (
            var e = document
                .getElementById("topnav-menu-content")
                .getElementsByTagName("a"),
            t = 0,
            n = e.length;
            t < n;
            t++
        )
            "nav-item dropdown active" === e[t].parentElement.getAttribute("class") &&
                (e[t].parentElement.classList.remove("active"),
                    e[t].nextElementSibling.classList.remove("show"));
    };

    var a;
    n("#side-menu").metisMenu(),
        n("#vertical-menu-btn").on("click", function (e) {
            e.preventDefault(),
                n("body").toggleClass("sidebar-enable"),
                992 <= n(window).width()
                    ? n("body").toggleClass("vertical-collpsed")
                    : n("body").removeClass("vertical-collpsed");
        }),
        n("body,html").on("click",function (e) {
            var t = n("#vertical-menu-btn");
            t.is(e.target) ||
                0 !== t.has(e.target).length ||
                e.target.closest("div.vertical-menu") ||
                n("body").removeClass("sidebar-enable");
        }),
        n("#sidebar-menu a").each(function () {
            $('#sidebar-menu ul li a').removeClass('mm-active');
            var e = window.location.href.split(/[?#]/)[0];
            this.href == e &&
                (n(this).addClass("active"),
                    n(this).parent().addClass("mm-active"),
                    n(this).parent().parent().addClass("mm-show"),
                    n(this).parent().parent().prev().addClass("mm-active"),
                    n(this).parent().parent().parent().addClass("mm-active"),
                    n(this).parent().parent().parent().parent().addClass("mm-show"),
                    n(this)
                        .parent()
                        .parent()
                        .parent()
                        .parent()
                        .parent()
                        .addClass("mm-active"));
        }),
        n(".navbar-nav a").each(function () {
            var e = window.location.href.split(/[?#]/)[0];
            this.href == e &&
                (n(this).addClass("active"),
                    n(this).parent().addClass("active"),
                    n(this).parent().parent().addClass("active"),
                    n(this).parent().parent().parent().addClass("active"),
                    n(this).parent().parent().parent().parent().addClass("active"),
                    n(this)
                        .parent()
                        .parent()
                        .parent()
                        .parent()
                        .parent()
                        .addClass("active"));
        }),
        n(document).ready(function () {
            var e;
            0 < n("#sidebar-menu").length &&
                0 < n("#sidebar-menu .mm-active .active").length &&
                300 < (e = n("#sidebar-menu .mm-active .active").offset().top) &&
                ((e -= 300),
                    n(".vertical-menu .simplebar-content-wrapper").animate(
                        { scrollTop: e },
                        "slow"
                    ));
        });
/*---------------------------------
  Top Menu / Side Menu JS
-----------------------------------*/

  /*---------------------------------
    Show/Hide Password/ Toggle Password JS
  -----------------------------------*/
    $(".toggle").on("click", function () {

        if ($(".password").attr("type") == "password")
        {
            //Change type attribute
            $(".password").attr("type", "text");
            $(this).removeClass("fa-eye");
            $(this).addClass("fa-eye-slash");
        } else
        {
            //Change type attribute
            $(".password").attr("type", "password");
            $(this).addClass("fa-eye");
            $(this).removeClass("fa-eye-slash");
        }
    });
  /*---------------------------------
    Show/Hide Password/ Toggle Password JS
  -----------------------------------*/

  $(".submit").on("click",function () {
    return false;
  });


/*---------------------------------
account-page- dropdown menu
-----------------------------------*/
  $( ".menu-has-children" ).on("click", function() {
    $(this).toggleClass( "has-open" );
  });
/*---------------------------------
account-page- dropdown menu
-----------------------------------*/

})(jQuery);
