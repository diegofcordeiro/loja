$(document).ready(function() {

  $('.animate-effect').addClass('anim-section');

  $(window).on('scroll', function() { 

    animSection();
    fadeInSection();

  });

  animSection();
  fadeInSection();

});

var animSection = function() {
  $('.anim-section').each(function() {
    if ($(window).scrollTop() > ($(this).offset().top - $(window).height() / 1.15)) {
      $(this).addClass('animate');
    } else {
      $(this).removeClass('animate');
    }
  });
}

var fadeInSection = function() {
  $('.fadeIn-section').each(function() {
    if ($(window).scrollTop() > ($(this).offset().top - $(window).height() / 1.15)) {
      $(this).addClass('fadeIn');
    }
  });
}