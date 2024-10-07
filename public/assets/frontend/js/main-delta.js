let $ = jQuery.noConflict();

$(document).ready(function () {
    $(".popup-show-all-filters").click(function (evt) {
        evt.preventDefault();
        $("#all-filters").addClass("active");
        $("body").addClass("ovh");
        $("html").addClass("ovh");
    });

    $(".popup-show-popup-about-product").click(function (evt) {
        evt.preventDefault();
        $("#popup-about-product").addClass("active");
        $("body").addClass("ovh");
        $("html").addClass("ovh");
    });

    $(".popup-show-login-form").click(function (evt) {
        evt.preventDefault();
        $("#login-form").addClass("active");
        $("body").addClass("ovh");
        $("html").addClass("ovh");
    });

    $(".popup-show-about-selected-meal").click(function (evt) {
        evt.preventDefault();
        $("#popup-about-selected-meal").addClass("active");
        $("body").addClass("ovh");
        $("html").addClass("ovh");
    });

    $(".popup-delete-entry").click(function (evt) {
        evt.preventDefault();
        $("#popup-delete-entry").addClass("active");
        $("body").addClass("ovh");
        $("html").addClass("ovh");
    });
    $(".open-menu .open-menu__header").click(function () {
        let link                  = $(this);
        let closest_ul            = link.closest("ul");
        let parallel_active_links = closest_ul.find(".active");
        let closest_li            = link.closest("li");
        let link_status           = closest_li.hasClass("active");
        let arrow                 = link.find(".open-menu__icon");
        let count                 = 0;

        closest_ul.find("ul").slideUp(function () {
            if (++count == closest_ul.find("ul").length) {
                parallel_active_links.removeClass("active");
            }
        });
        if (!link_status) {
            closest_li.find("ul:first-of-type").first().slideDown();
            closest_li.addClass("active");
            arrow.addClass("active");
        }
    });

    let menuLink = $(".sort-link").html();
    if (!menuLink) {
    } else {
        let menu         = document.querySelector(".sort-categories__list");
        let openmenu     = document.querySelector(".sort-link");
        openmenu.onclick = function () {
            menu.style.display = menu.style.display === "none" ? "block" : "none";
            openmenu.classList.toggle("active");
        };
    }

    let mainMenuHeader = $(".mobile-header-main-menu").html();
    if (!mainMenuHeader) {
    } else {
        let menu      = document.querySelector(".mobile-header-main-menu");
        let openMenu  = document.querySelector(
            ".mobile-header-main-menu__open-link"
        );
        let closeMenu = document.querySelector(
            ".mobile-header-main-menu__close-link"
        );

        closeMenu.onclick = function () {
            menu.classList.toggle("open");
        };

        // openMenu.onclick = function () {
        //   menu.classList.toggle("open");
        // };
    }

    let HeaderHome = $(".header-home").html();
    if (!HeaderHome) {
    } else {
        let prevScrollpos = window.pageYOffset;
        $(window).on("scroll", function () {
            let currentScrollPos = window.pageYOffset;
            if (prevScrollpos > currentScrollPos) {
                $(".header-home").addClass("active");
            } else {
                $(".header-home").removeClass("active");
            }
            prevScrollpos = currentScrollPos;
        });
    }
});
