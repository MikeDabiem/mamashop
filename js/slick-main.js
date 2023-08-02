jQuery(function($) {
  $('.banner__items').slick({
    autoplay: true,
    autoplaySpeed: 5000,
    infinite: true,
    swipeToSlide: true,
    prevArrow: $('.banner__prev'),
    nextArrow: $('.banner__next'),
    dots: true,
    dotsClass: 'banner__dots',
    responsive: [
      {
        breakpoint: 768,
        settings: {
          arrows: false,
        }
      }
    ]
  });
  $('.top__items').slick({
    slidesToShow: 5,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 5000,
    infinite: true,
    swipeToSlide: true,
    prevArrow: $('.top__prev'),
    nextArrow: $('.top__next'),
    responsive: [
      {
        breakpoint: 768,
        settings: {
          arrows: false,
        }
      }
    ]
  });
  $('.hits__items').slick({
    slidesToShow: 5,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 5000,
    infinite: true,
    swipeToSlide: true,
    prevArrow: $('.hits__prev'),
    nextArrow: $('.hits__next'),
    responsive: [
      {
        breakpoint: 768,
        settings: {
          arrows: false,
        }
      }
    ]
  });
});