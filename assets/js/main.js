(function($) {

  "use strict";

  // Toggle .header-scrolled class to #header when page is scrolled
  $(window).scroll(function() {
    if ($(this).scrollTop() > 100) {
      $('#header').addClass('header-scrolled');
    } else {
      $('#header').removeClass('header-scrolled');
    }
    
    if ($(this).scrollTop() > 60) {
      $('.mobile-nav-top').addClass('background-mobile-nav-top');
    } else {
      $('.mobile-nav-top').removeClass('background-mobile-nav-top');
    }
  });

  if ($(window).scrollTop() > 100) {
    $('#header').addClass('header-scrolled');
  }

  // Preloader
  $(window).on('load', function() {
    $('.preloader').fadeOut('slow', function() {});
  });

  // Smooth scroll for the navigation menu and links with .scrollto classes
  $(document).on('click', '.nav-menu a, .mobile-nav a, .scrollto', function(e) {
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      //e.preventDefault();
      var target = $(this.hash);
      if (target.length) {

        var scrollto = target.offset().top;
        var scrolled = 2;

        if ($('#header-sticky-wrapper').length) {
          scrollto -= $('#header-sticky-wrapper').outerHeight() - scrolled;
        }

        if ($(this).attr("href") == '#header') {
          scrollto = 0;
        }

        $('html, body').animate({
          scrollTop: scrollto
        }, 1500, 'easeInOutExpo');

        if ($(this).parents('.nav-menu, .mobile-nav').length) {
          $('.nav-menu .active, .mobile-nav .active').removeClass('active');
          $(this).closest('li').addClass('active');
        }

        if ($('body').hasClass('mobile-nav-active')) {
          $('body').removeClass('mobile-nav-active');
          $('.mobile-nav-toggle i').toggleClass('icofont-navigation-menu icofont-close');
          $('.mobile-nav-overly').fadeOut();
        }
        return false;
      }
    }
  });

  // Mobile Navigation
  if ($('.nav-menu').length) {
    var $mobile_nav = $('.nav-menu').clone().prop({
      class: 'mobile-nav d-lg-none'
    });
    $('body').append($mobile_nav);
    
    var $contact_info = $('.contact-info').clone();
    $('.mobile-nav').append($contact_info);

    var $social_links = $('#topbar .social-links').clone();
    $('.mobile-nav').append($social_links);

    var $logo = $('#header .logo').clone();
    $('.mobile-nav').prepend($logo);

    $('body').prepend('<div class="mobile-nav-top"><a href="" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a><button type="button" class="mobile-nav-toggle d-lg-none"><i class="icofont-navigation-menu"></i></button></div>');
    $('body').append('<div class="mobile-nav-overly"></div>');

    $(document).on('click', '.mobile-nav-toggle', function(e) {
      $('body').toggleClass('mobile-nav-active');
      $('.mobile-nav-toggle i').toggleClass('icofont-navigation-menu icofont-close');
      $('.mobile-nav-overly').toggle();
    });

    $(document).on('click', '.mobile-nav .drop-down > a', function(e) {
      e.preventDefault();
      $(this).next().slideToggle(300);
      $(this).parent().toggleClass('active');
    });

    $(document).click(function(e) {
      var container = $(".mobile-nav, .mobile-nav-toggle");
      if (!container.is(e.target) && container.has(e.target).length === 0) {
        if ($('body').hasClass('mobile-nav-active')) {
          $('body').removeClass('mobile-nav-active');
          $('.mobile-nav-toggle i').toggleClass('icofont-navigation-menu icofont-close');
          $('.mobile-nav-overly').fadeOut();
        }
      }
    });
  } else if ($(".mobile-nav, .mobile-nav-toggle").length) {
    $(".mobile-nav, .mobile-nav-toggle").hide();
  }

  // Navigation active state on scroll
  var nav_sections = $('section');
  var main_nav = $('.nav-menu, #mobile-nav');
  var main_nav_height = $('#header').outerHeight();

  $(window).on('scroll', function() {
    var cur_pos = $(this).scrollTop() + 10;

    nav_sections.each(function() {
      var top = $(this).offset().top - main_nav_height,
        bottom = top + $(this).outerHeight();

      if (cur_pos >= top && cur_pos <= bottom) {
        if (cur_pos <= bottom) {
          main_nav.find('li').removeClass('active');
        }
        main_nav.find('a[href="#' + $(this).attr('id') + '"]').parent('li').addClass('active');
      }
    });
  });

  // Check if device is touch-enabled
  function isTouchDevice() {
    return (('ontouchstart' in window) ||
      (navigator.maxTouchPoints > 0) ||
      (navigator.msMaxTouchPoints > 0));
  }

  // Add touch-device class to body if on mobile
  if (isTouchDevice()) {
    $('body').addClass('touch-device');
  }

  // Back to top button with mobile enhancements
  $(window).scroll(function() {
    if ($(this).scrollTop() > 100) {
      $('.back-to-top').fadeIn('slow');
    } else {
      $('.back-to-top').fadeOut('slow');
    }
  });

  $('.back-to-top').click(function(e) {
    // Add ripple effect for mobile
    if (isTouchDevice()) {
      const button = $(this);
      const ripple = $('<span class="ripple-effect"></span>');
      const buttonPos = button.offset();
      const xPos = e.pageX - buttonPos.left;
      const yPos = e.pageY - buttonPos.top;
      
      ripple.css({
        top: yPos + 'px',
        left: xPos + 'px'
      }).appendTo(button);

      setTimeout(function() {
        ripple.remove();
      }, 600);
    }
    
    $('html, body').animate({
      scrollTop: 0
    }, 1500, 'easeInOutExpo');
    return false;
  });
  
  // Add touch feedback for mobile devices
  if (isTouchDevice()) {
    // Add touch feedback to buttons
    $('.btn, .nav-link, .card').on('touchstart', function() {
      $(this).addClass('touch-active');
    }).on('touchend touchcancel', function() {
      $(this).removeClass('touch-active');
    });
  }

})(jQuery);