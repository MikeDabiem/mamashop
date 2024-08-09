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
        breakpoint: 769,
        settings: {
          arrows: false,
        }
      }
    ]
  });

  const productsCardsResponsive = [
    {
      breakpoint: 1025,
      settings: {
        slidesToShow: 4,
      }
    },
    {
      breakpoint: 815,
      settings: {
        slidesToShow: 3,
      }
    },
    {
      breakpoint: 555,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    }
  ];

  $('.top__items').slick({
    slidesToShow: 5,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 5000,
    infinite: true,
    swipeToSlide: true,
    prevArrow: $('.top__prev'),
    nextArrow: $('.top__next'),
    responsive: productsCardsResponsive
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
    responsive: productsCardsResponsive
  });

  $('.post__products__items').each(function() {
    $(this).slick({
      slidesToShow: 5,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 5000,
      infinite: true,
      swipeToSlide: true,
      prevArrow: $(this).siblings('.post__products__prev'),
      nextArrow: $(this).siblings('.post__products__next'),
      responsive: productsCardsResponsive
    });
  });

  $('.more__posts__items').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 5000,
    infinite: true,
    swipeToSlide: true,
    prevArrow: $('.more__posts__prev'),
    nextArrow: $('.more__posts__next'),
    responsive: [
      {
        breakpoint: 555,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 420,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });
});