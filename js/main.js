jQuery(function($) {
  $.expr[":"].contains = $.expr.createPseudo(function(arg) {
    return function( elem ) {
      return $(elem).text().toLowerCase().indexOf(arg.toLowerCase()) >= 0;
    };
  });
  const body = $('body');
  const ajaxURL = ajaxurl;

  // header scroll event
  const header = $(".header");
  let currentMenuScroll = $(window).scrollTop();
  function checkHeaderClass() {
    (currentMenuScroll > 0) ? header.addClass("header-scrolled") : header.removeClass("header-scrolled");
  }
  checkHeaderClass();
  $(window).on("scroll", function () {
    currentMenuScroll = $(this).scrollTop();
    checkHeaderClass();
  });

  // header menus handler
  const blurBG = $('.blur-bg');
  const mainMenu = $('.main-menu');
  blurBG.on('click', function(e) {
    if (e.target === this || e.target.closest('.close-menu')) {
      $(this).removeClass('active');
      body.removeClass('overflow-hidden');
      backMenu();
    }
  });
  function showMenu(element) {
    element.parent().addClass('active');
    body.addClass('overflow-hidden');
  }
  $('.burger').on('click', () => {
    showMenu(mainMenu);
  });
  $('.header__catalog').on('click', () => {
    showMenu($('.catalog-menu'));
  });
  $('.header__cart').on('click', () => {
    showMenu($('.cart-menu'));
  });

  // header search
  const searchInput = $('.header-search__input');
  const searchMenu = $('.header-search__menu');
  if (searchInput.length) {
    // stop submit if empty
    $('#search').on('submit', e => {
      if (searchInput.val() === '') {
        e.preventDefault();
      }
    });

    // open search help menu
    searchInput.on('focus', () => {
      searchMenu.slideDown(300).css('display', 'flex');
    });

    // add search help variants
    const searchHelpBlock = $('.search-try');
    const searchHelpList = $('.search-try__items');
    searchInput.on('input', function(e) {
      let searchHelp = [];
      if (searchInput.val() !== '') {
        searchHelp = searchHelpArr.filter(el => (el.toLowerCase().includes(e.target.value.toLowerCase())));
      }
      if (searchHelpBlock.hasClass('active') && searchInput.val() === '' || searchHelp.length === 0) {
        searchHelpBlock.removeClass('active');
      } else {
        searchHelpBlock.addClass('active');
      }
      searchHelpList.html('');
      searchHelp.forEach((item, i) => {
        if (i < 3) {
          searchHelpList.append(`<p class="search-try__item search-try__val font-14-20 fw-400">${item}</p>`);
        }
      });
      $('.search-try__val').on('click', function() {
        searchInput.val($(this).text());
      });
    })
  }

  // product heart handler
  if ($('.product-item__heart').length) {
    body.on('click', '.product-item__heart', function() {
      $(this).toggleClass('active');
    });
  }

  // random product rating
  const rating = $('.rating__stars-val');
  const infoRating = $('.info__rating-title');
  if (infoRating.length) {
    const randomValue = Math.floor(Math.random() * (100 - 10 + 1) + 10);
    if (randomValue < 20) {
      infoRating.text('0.0');
      rating.each(function() {
        $(this).css('width', 0 + "%");
      });
      $('.info__rating__percents-value').addClass('d-none');
      $('.info__rating__percents-text').css('maxWidth', 'none').addClass('text-center').text('Допоможіть іншим користувачам з вибором - будьте першим, хто поділиться своєю думкою про цей товар.');
      $('.rating__value').text('0 Відгуків');
    } else {
      infoRating.text(randomValue / 20);
      rating.each(function() {
        $(this).css('width', randomValue + "%");
      });
      $('.info__rating__percents-value').text(randomValue + '%');
    }
  } else {
    rating.each(function() {
      $(this).css('width', Math.floor(Math.random() * (100 - 10 + 1) + 10) + "%");
    });
  }

  // show category children
  const catalogCategories = $('.catalog__categories');
  if (catalogCategories.length) {
    const catalogCategoryParent = $('.catalog__category--parent');
    const catalogCategoriesChildren = $('.catalog__categories__children');
    const catalogCategoriesChild = $('.catalog__categories__child');
    const catalogBack = $('.catalog__back');
    const catalogBackTitle = $('.catalog__back-title');
    const catalogTitle = $('.catalog__title');
    function backMenu() {
      catalogCategories.removeClass('active');
      catalogCategoriesChildren.removeClass('active')
      catalogCategoriesChild.removeClass('active');
      catalogBack.removeClass('active');
      catalogTitle.removeClass('hide');
    }
    catalogCategoryParent.on('click', function(e) {
      e.preventDefault();
      catalogCategories.addClass('active');
      catalogCategoriesChildren.addClass('active').find(`[data-cat-child="${$(this).data('cat')}"]`).addClass('active');
      catalogBackTitle.text($(this).find($('.catalog__category-title')).text());
      catalogBack.addClass('active');
      catalogTitle.addClass('hide');
    });
    catalogBack.on('click', function() {
      backMenu();
    });
  }

  // price filter
  const priceFilter = $('.product-filter__price');
  const productFilter = $('.product-filter__filter');
  const priceRangeMin = $('#price-range-min');
  const priceRangeMax = $('#price-range-max');
  if(priceFilter.length) {
    // price filter ranges handler
    const priceRangeTrack = $('.product-filter__price__range-track');
    if (priceRangeTrack.length) {
      const priceInputMin = $('#price-val-min');
      const priceInputMax = $('#price-val-max');
      const minGap = 10;
      const priceRangeMaxValue = priceRangeMin.attr('max');
      const priceRangeMinValue = priceRangeMin.attr('min');

      function slideMin() {
        if (+priceRangeMax.val() - +priceRangeMin.val() <= minGap) {
          priceRangeMin.val(+priceRangeMax.val() - minGap);
        }
        priceInputMin.val(priceRangeMin.val());
        fillColor();
      }

      function slideMax() {
        if (+priceRangeMax.val() - +priceRangeMin.val() <= minGap) {
          priceRangeMax.val(+priceRangeMin.val() + minGap);
        }
        priceInputMax.val(priceRangeMax.val());
        fillColor();
      }

      function fillColor() {
        const percent1 = ((priceRangeMin.val() - priceRangeMinValue) / (priceRangeMaxValue - priceRangeMinValue)) * 100;
        const percent2 = ((priceRangeMax.val() - priceRangeMinValue) / (priceRangeMaxValue - priceRangeMinValue)) * 100;
        priceRangeTrack.css('background', `linear-gradient(to right, #dadae5 ${percent1}% , #6757A9 ${percent1}% , #6757A9 ${percent2}%, #dadae5 ${percent2}%)`);
      }

      slideMin();
      slideMax();
      priceInputMin.on('change', function () {
        if (+$(this).val() > +priceRangeMinValue && +$(this).val() < +priceRangeMax.val() - minGap) {
          priceRangeMin.val($(this).val());
        } else if (+$(this).val() <= +priceRangeMinValue) {
          priceRangeMin.val(priceRangeMinValue);
        } else {
          priceRangeMin.val(+priceRangeMax.val() - minGap);
        }
        priceRangeMin.trigger('input');
      });
      priceInputMax.on('change', function () {
        if (+$(this).val() < +priceRangeMaxValue && +$(this).val() > +priceRangeMin.val() + minGap) {
          priceRangeMax.val($(this).val());
        } else if (+$(this).val() >= +priceRangeMaxValue) {
          priceRangeMax.val(priceRangeMaxValue);
        } else {
          priceRangeMax.val(+priceRangeMin.val() + minGap);
        }
        priceRangeMax.trigger('input');
      });
      priceRangeMin.on('input', slideMin);
      priceRangeMax.on('input', slideMax);
    }
  }

  body.on('click', '.product-filter__spoiler', function () {
    $(this).toggleClass('hide');
    $(`.product-filter__spoiler__content[data-name="${$(this).data('name')}"]`).slideToggle(300);
  });

  // filters filter brands names
  if ($('.brand-filter__input').length) {
    body.on('input', '.brand-filter__input', function() {
      const brandsParent = $(`.product-filter__spoiler__content[data-name="pa_brand"]`);
      if ($(this).val() === ' ') {
        $(this).val('');
      }
      if ($(this).val().length) {
        brandsParent.addClass('showall');
        brandsParent.children('.product-filter__check').hide();
        $(`.product-filter__check-label-title:contains(${$(this).val().toLowerCase()})`).parent().parent('.product-filter__check').show();
      } else {
        brandsParent.removeClass('showall');
        brandsParent.children('.product-filter__check').show();
      }
    });
  }

  // spoil too many filters
  const notSpoilArr = [];
  function spoilFilters() {
    const moreFiltersButton = $('.product-filter__spoiler__content__more');
    const notSpoiledFilterItemHeight = parseInt($('.product-filter__check').css('height')) + 16;
    if (moreFiltersButton.length) {
      function brandInputHeight(button) {
        if (button.siblings('.product-filter__brand-filter').length) {
          return parseInt(button.siblings('.product-filter__brand-filter').css('height')) + 16;
        } else {
          return 0;
        }
      }
      moreFiltersButton.each(function() {
        $(this).parent('.product-filter__spoiler__content').css('max-height', (notSpoiledFilterItemHeight * 7 + 13) + brandInputHeight($(this)) + 'px');
        if ($.inArray($(this).parent().data('name'), notSpoilArr) >= 0) {
          $(this).children('.product-filter__spoiler__content__more-text').text('Згорнути');
          $(this).parent('.product-filter__spoiler__content').css({maxHeight: notSpoiledFilterItemHeight * $(this).siblings('.product-filter__check').length + 13 + brandInputHeight($(this)) + 'px'});
          $(this).addClass('active');
        }
      });
      moreFiltersButton.on('click', function() {
        $(this).toggleClass('active');
        if ($(this).hasClass('active')) {
          if ($.inArray($(this).parent().data('name'), notSpoilArr) < 0) {
            notSpoilArr.push($(this).parent().data('name'));
          }
          $(this).children('.product-filter__spoiler__content__more-text').text('Згорнути');
          $(this).parent('.product-filter__spoiler__content').animate({maxHeight: notSpoiledFilterItemHeight * $(this).siblings('.product-filter__check').length + 13 + brandInputHeight($(this)) + 'px'});
        } else {
          notSpoilArr.splice($.inArray($(this).parent().data('name'), notSpoilArr),1)
          $(this).parent('.product-filter__spoiler__content').animate({maxHeight: (notSpoiledFilterItemHeight * 7 + 13) + brandInputHeight($(this)) + 'px'});
          $(this).children('.product-filter__spoiler__content__more-text').text(`Показати ще ${$(this).siblings('.product-filter__check').length - 7}`);
        }
      });
    }
  }
  spoilFilters();

  // filters checkboxes handler
  const filterItems = $('.product-filter__chosen__items');
  const filterChosen = $('.product-filter__chosen');
  const filterHeadTitle = $('.product-filter__chosen-title');

  // show/hide product filter head with chosen filters
  function hideChosenFiltersTitle() {
    if ($('.product-filter__chosen-item').length) {
      filterHeadTitle.addClass('active');
      filterChosen.addClass('active');
    } else {
      filterChosen.removeClass('active');
      setTimeout(() => {
        filterHeadTitle.removeClass('active');
      }, 300)
    }
  }
  hideChosenFiltersTitle();

  // add/remove chosen filters in filter head
  body.on('change', '.product-filter__check-checkbox', function() {
    const id = $(this).attr('id');
    const name = $(`.product-filter__check-label[for="${id}"] > .product-filter__check-label-title`).text();
    if ($(this).is(':checked')) {
      filterItems.append(
        `<div class="product-filter__chosen-item d-flex align-items-center" data-name="${id}">
        <p class="font-12-16 fw-400">${name}</p>
        <label for="${id}" class="product-filter__chosen-item-close transition-default d-flex">
          <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="cross"><rect width="16" height="16" rx="8" fill="#494558"/><g id="Group 2088"><path id="Vector 73" d="M4.80078 4.80078L11.2007 11.2013" stroke="#F5E4E7" stroke-width="1.5"/><path id="Vector 74" d="M11.1992 4.80078L4.79928 11.2012" stroke="#F5E4E7" stroke-width="1.5"/></g></g></svg>
        </label>
      </div>`
      )
    } else {
      filterItems.children(`[data-name=${id}]`).remove();
    }
    hideChosenFiltersTitle();
  });

  // clear filter form
  const clearFilters = $('.product-filter-clear');
  if (clearFilters.length) {
    clearFilters.on('click', function () {
      const searchParams = Object.fromEntries(new URLSearchParams(window.location.search)).s;
      if (searchParams) {
        window.location.search = `s=${searchParams}`;
      } else {
        window.location.href = window.location.origin + window.location.pathname;
      }
    });
  }

  // sort menu handler
  const sortSelect = $('.sort__select');
  const sortMenu = $('.sort__menu');
  if (sortSelect.length) {
    body.on('click', '.sort__select', function () {
      $(this).toggleClass('active');
      sortMenu.slideToggle(300);
    });
    const sortMenuItem = $('.sort__menu__item');
    sortMenuItem.on('click', function () {
      $('.sort__select-chosen').text($(this).children('.sort__menu__item-title').text());
      sortMenuItem.removeClass('active');
      $(this).addClass('active');
      $('.sort__select-input').val($(this).data('value')).trigger('change');
    });
  }

  // close menus on outside click
  body.on('click', (e) => {
    if (e.target.closest('.header-search__input') || e.target.closest('.header-search__menu')) {
      searchInput.trigger('focus');
    } else {
      searchMenu.slideUp(300);
    }
    if (sortSelect.length && !e.target.closest('.sort__select')) {
      sortSelect.removeClass('active');
      sortMenu.slideUp(300);
    }
  });

  // single-product gallery
  const gallery = $('.info__main__image');
  if (gallery.length) {
    const mainImage = $('.info__main__image-main > img');
    const galleryImage = $('.info__main__image__gallery > img');
    galleryImage.on('click', function() {
      galleryImage.removeClass('d-none');
      $(this).addClass('d-none');
      mainImage.attr('src', $(this).attr('src'));
      mainImage.attr('alt', $(this).attr('alt'));
    })
  }

  // single-product tabs
  const tabButton = $('.tab-button');
  if (tabButton.length) {
    const tabButtonBorder = $('.tab-button--border');
    tabButton.on('click', function() {
      const id = $(this).attr('id');
      tabButton.removeClass('active');
      $(this).addClass('active');
      tabButtonBorder.width($(this).outerWidth()).css({left: $(this).position().left - 2});
      $('.info__advanced__tab').animate({opacity: 0}, 200, function () {
        $(this).removeClass('active');
        $(`.info__advanced__tab[data-name="${id}"]`)
          .addClass('active')
          .animate({opacity: 1}, 200);
      });
    });
  }

  // review stars handler
  if ($('.std-form__stars').length) {
    const star = $('.std-form__stars-image');
    let starsValue = 0;
    function starsHandler(it) {
      star.each((i, item) => {
        if (i + 1 <= it.data('star')) {
          $(item).addClass('active');
        } else {
          $(item).removeClass('active');
        }
      });
    }
    star.on('mouseenter', function() {
      if (!starsValue) {
        starsHandler($(this));
      }
    });
    star.on('mouseleave', function() {
      if (!starsValue) {
        star.removeClass('active');
      }
    });
    star.on('click', function() {
      starsValue = $(this).data('star');
      starsHandler($(this));
    });
  }

  // make review button
  const makeReviewBtn = $('#make-review__btn');
  const askQuestionBtn = $('#ask-question__btn');
  const reviewForm = $('.review__form');
  const questionForm = $('.question__form');
  const reviewSuccessMsg = $('.review-success');
  const questionSuccessMsg = $('.question-success');

  if(makeReviewBtn.length) {
    makeReviewBtn.on('click', () => {
      $('.make-review').addClass('active');
      body.addClass('overflow-hidden');
    });
  }

  if (askQuestionBtn.length) {
    askQuestionBtn.on('click', () => {
      $('.ask-question').addClass('active');
      body.addClass('overflow-hidden');
    });
  }

  const successBtn = $('.success-button');
  if (reviewForm.length) {
    reviewForm.on('submit', function(e) {
      e.preventDefault();
      $(this).addClass('d-none');
      reviewSuccessMsg.removeClass('d-none');
    });
    successBtn.on('click', () => {
      blurBG.trigger('click');
    })
  }

  if (questionForm.length) {
    questionForm.on('submit', function(e) {
      e.preventDefault();
      $(this).addClass('d-none');
      questionSuccessMsg.removeClass('d-none');
    });
    successBtn.on('click', () => {
      blurBG.trigger('click');
    })
  }

  // click "Перейти до кошика" button in product card
  body.on('click', '.buy-button--cart', function() {
    showMenu($('.cart-menu'));
  });

  // click checkout link if total is less
  const cartCheckoutLink = $('.cart-menu__order');
  if (cartCheckoutLink.length) {
    cartCheckoutLink.on('click', function(e) {
      if (cartCheckoutLink.hasClass('disabled-check')) {
        e.preventDefault();
        const errorMin = $('.error-min');
        errorMin.addClass('red');
        setTimeout(() => {
          errorMin.removeClass('red');
        }, 5000);
      }
    });
  }

  // toggle checkout tabs
  if ($('.checkout-page').length) {
    const checkoutNextButton = $('.checkout-next-button');
    const checkoutChangeButton = $('.checkout-change-button');

    // forbid change value to space
    $('.checkout__input-item').on('input', function() {
      if ($(this).val() === ' ') {
        $(this).val('');
      }
    });

    // click "Продовжити" button
    checkoutNextButton.on('click', function() {
      // errors check
      let errorsCount = 0;
      if ($(this).siblings('.checkout__inputs').length) {
        $(this).siblings('.checkout__inputs').find('.checkout__input-item').each(function() {
          if (
            $(this).is('[required]') &&
            $(this).val().length < 2
            ||
            $(this).is('#billing_email') &&
            $(this).val() &&
            !$(this).val().toLowerCase().match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)
          ) {
            $(this).addClass('input--error');
            $(this).siblings('.input--error-text').fadeIn(300);
            errorsCount++;
          }
          if ($(this).is('#billing_email') && !$(this).val()) {
            $('.ready__item__email').addClass('d-none');
          }
          // remove error after focusing input
          $(this).on('focus', function() {
            $(this).removeClass('input--error');
            $(this).siblings('.input--error-text').fadeOut(300);
            errorsCount = 0;
            if ($(this).is('#billing_email')) {
              $('.ready__item__email').removeClass('d-none');
            }
          });
        });
      }

      // toggle to next tab
      if (!errorsCount) {
        if ($(this).parent().hasClass('contacts__body')) {
          $('.ready__item--name').text($('#billing_last_name').val() + ' ' + $('#billing_first_name').val());
          $('.ready__item--phone').text($('#billing_phone').val());
          $('.ready__item--email').text($('#billing_email').val());
        }
        if ($(this).parent().hasClass('payment__body')) {
          $('.checkout-page__confirm').fadeIn(300);
          const checkedRadioId = $('.input-radio:checked').attr('id');
          $('.ready__item--payment').html($(`.payment__item-label[for=${checkedRadioId}]`).html());
          $('.comment-title').text('Згорунти');
        }
        $(this).parent().slideUp(300);
        $(this).parent().siblings('.checkout-page__section__ready').slideDown(300);
        $(this).closest('.checkout-page__section').next().find('.checkout-change-button').hide();
        $(this).closest('.checkout-page__section').next().addClass('active').children('.checkout-page__section__body').slideDown(300);
        $(this).parent().siblings('.checkout-page__section__head').children('.checkout-change-button').fadeIn(300);
        $(this).parent().siblings('.checkout-page__section__head').children('.checkout-page__section-title').children('span')
          .fadeOut(200)
          .queue(function() {
            $(this).html(
              `<svg xmlns="http://www.w3.org/2000/svg" width="21" height="20" viewBox="0 0 21 20" fill="none">
                <path d="M5 9.5L9 13.5L16 6.5" stroke="white" stroke-width="2"/>
              </svg>`
            )
          })
          .fadeIn(200);
      }
    });

    // click "Змінити" button
    checkoutChangeButton.on('click', function() {
      $(this).parent().siblings('.checkout-page__section__body').slideDown(300);
      $(this).parent().siblings('.checkout-page__section__ready').slideUp(300);
      $(this).fadeOut(300);
    });

    // show checkout comment field
    const checkoutComment = $('.checkout-page__comment');
    if (checkoutComment.length) {
      const checkoutCommentTitle = $('.comment-title');
      const checkoutCommentBody = $('.comment__body');
      const commentInput = $('#order_comments');
      const commentReadyBlock = $('.comment__ready');
      const commentReadyText = $('.comment__ready-text');
      checkoutComment.on('click', function(e) {
        if (e.target.closest('.comment__body') || e.target.closest('.comment__ready')) {
          return false;
        }
        if (!$(this).hasClass('active')) {
          $(this).addClass('active');
          checkoutCommentTitle.text('Згорунти');
          checkoutCommentBody.slideDown(300);
          commentInput.trigger('focus');
          if (commentReadyText.text()) {
            commentReadyBlock.slideUp(300);
          }
        } else {
          $(this).removeClass('active');
          checkoutCommentTitle.text('Додати коментар до замовлення');
          checkoutCommentBody.slideUp(300);
          if (commentReadyText.text()) {
            commentReadyBlock.slideDown(300);
          }
        }
      });

      // add a comment
      $('.comment-button').on('click', function() {
        if(commentInput.val()) {
          commentReadyText.text(`«${commentInput.val()}»`);
          commentReadyBlock.slideDown(300);
        } else {
          commentReadyText.text('');
          commentReadyBlock.slideUp(300);
        }
        checkoutComment.trigger('click');
      });
    }
  }

  const couponBody = $('.coupon__body');
  if (couponBody.length) {
    const couponHeadButton = $('.coupon__head-button');
    function showCouponBody() {
      if (couponBody.hasClass('active')) {
        couponBody.removeClass('active');
        couponHeadButton.text('Додати');
      } else {
        couponBody.addClass('active');
        couponHeadButton.text('Закрити');
      }
    }
    couponHeadButton.on('click', showCouponBody);
    const couponSubmitButton = $('.coupon-button');
    const couponInput = $('.coupon-input');
    couponSubmitButton.on('click', function(e) {
      if (!couponInput.val()) {
        e.preventDefault();
        couponInput.addClass('input--error');
        couponInput.siblings('.input--error-text').fadeIn(300);
      } else {
        showCouponBody();
      }
    });
    couponInput.on('focus', function() {
      couponInput.removeClass('input--error');
      couponInput.siblings('.input--error-text').fadeOut(300);
    });
  }

  const customSelect = $('.custom-select');
  if (customSelect.length) {
    const customSelectMenu = $('.custom-select__menu');
    const customSelectChosen = $('.custom-select__chosen');
    customSelectChosen.on('click', function() {
      if ($(this).hasClass('active')) {
        $(this).removeClass('active');
        $(this).siblings('.custom-select__menu').slideUp(300);
      } else {
        customSelectChosen.removeClass('active');
        customSelectMenu.slideUp(300);
        $(this).addClass('active');
        $(this).siblings('.custom-select__menu').slideDown(300);
      }
    });
    body.on('click', '.custom-select__menu__item', function() {
      $(this).siblings().removeClass('active');
      $(this).addClass('active');
      $(this).parent().siblings().find('.custom-select__chosen-title').text($(this).children('.custom-select__menu__item-title').text());
      $(this).parent().siblings().find('.custom-select-input').val($(this).data('value'));
      customSelectMenu.slideUp(300);
      customSelectChosen.removeClass('active');

      const billingCityInput = $('#billing_city');
      if ($(this).closest('.delivery__place__item').attr('id') === 'delivery_region') {
        billingCityInput.val($(this).children('.custom-select__menu__item-title').text() + ', ');
        $('#delivery_city').find('.custom-select__chosen-title').text('Оберіть населений пункт');
      } else if ($(this).closest('.delivery__place__item').attr('id') === 'delivery_city') {
        billingCityInput.val(billingCityInput.val() + $(this).children('.custom-select__menu__item-title').text());
      }
    });
    body.on('click', (e) => {
      if (!e.target.closest('.custom-select')) {
        $('.custom-select__chosen').removeClass('active');
        customSelectMenu.slideUp(300);
      }
    });
  }

  const editAccountForm = $('.edit-account');
  if (editAccountForm.length) {
    const firstNameInput = $('#account_first_name');
    const lastNameInput = $('#account_last_name');
    const displayNameInput = $('#account_display_name');

    function setDisplayName() {
      displayNameInput.val(lastNameInput.val() + ' ' + firstNameInput.val());
    }

    firstNameInput.on('change', function() {
      setDisplayName();
    });
    lastNameInput.on('change', function() {
      setDisplayName();
    });

    editAccountForm.on('submit', function(e) {
      let errorsCount = 0;
      $(this).find('.woocommerce-Input').each(function() {
        if (
          $(this).hasClass('required') &&
          $(this).val().length < 2
        ) {
          $(this).addClass('input--error');
          if ($(this).siblings('.input--error-text').text() !== 'Заповніть будь ласка поле') {
            $(this).siblings('.input--error-text').text('Заповніть будь ласка поле');
          }
          $(this).siblings('.input--error-text').fadeIn(300);
          errorsCount++;
        } else if (
          $(this).is('#account_email') &&
          !$(this).val().toLowerCase().match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)
        ) {
          $(this).siblings('.input--error-text').text('Невірний формат адреси електронної пошти');
          $(this).siblings('.input--error-text').fadeIn(300);
          errorsCount++;
        }
        // remove error after focusing input
        $(this).on('focus', function() {
          $(this).removeClass('input--error');
          $(this).siblings('.input--error-text').fadeOut(300);
          errorsCount = 0;
        });
      });
      if (errorsCount) {
        e.preventDefault();
      }
    });

    const bDayInput = $('#birthday');
    if (bDayInput.length) {
      bDayInput.on('focus', function() {
        this.type='date';
        this.showPicker()
      });
      bDayInput.on('blur', function() {
        if (!$(this).val()) {
          this.type='text';
        }
      });
    }
  }

  const accountOrdersPage = $('.account-page__orders');
  if (accountOrdersPage.length) {
    body.on('click', '.account-page__orders__item__head', function() {
      $(this).parent().toggleClass('active');
      $(this).siblings('.account-page__orders__item__body').slideToggle(300);
    });
  }



  //////////
  // AJAX //
  //////////



  const searchParams = window.location.search;
  const urlParams = Object.fromEntries(new URLSearchParams(searchParams));
  const searchResults = $('.search-page__results');
  const productFilterParent = $('.product-filter');

  let sortBy = urlParams.sort ? urlParams.sort : null;
  let priceData = urlParams.price ? {price: urlParams.price} : {};
  let formData = {};
  let page = urlParams.page || '1';
  const searchString = urlParams.s ? {s: urlParams.s} : {};

  const defaultData = {
    action: 'filter',
    ...searchString,
    page
  }

  function sendAJAX(ajaxData) {
    searchResults.animate({opacity: .5}, 300);
    productFilterParent.animate({opacity: .5}, 300);
    const data = {...defaultData, ...ajaxData};
    const getParams = new URLSearchParams(ajaxData);
    const search = searchString.s ? `s=${searchString.s}` : '';
    window.history.pushState(null, '', `?${search}&${decodeURIComponent(getParams.toString())}`);
    $.get(ajaxURL.url, data, function(response) {
      searchResults.empty().append(response).animate({opacity: 1}, 300);
    });
    $.get(ajaxURL.url, {...data, action: 'hide_filters'}, function(response) {
      productFilter.empty().append(response);
      productFilterParent.animate({opacity: 1}, 300);
      spoilFilters();
    });
  }

  if (sortSelect.length) {
    const sortSelectInput = $('.sort__select-input');
    sortBy = sortSelectInput.val() ? sortSelectInput.val() : 'popular';
    sortSelectInput.on('change', function () {
      sortBy = $(this).val();
      const data = {
        page: '1',
        sort: sortBy,
        ...priceData,
        ...formData
      }
      sendAJAX(data);
    });
  }

  if (priceFilter.length) {
    $('.product-filter__price__send').on('click', function() {
      priceFilter.trigger('change');
    });
    priceFilter.on('change', function(e) {
      if (e.target.closest('.product-filter__price__inputs') || e.target.closest('.product-filter__price__range')) {
        return false;
      }

      priceData = {};
      $.each($(this).serializeArray(), function() {
        if (priceData[this.name]) {
          priceData[this.name] += '-' + this.value;
        } else {
          priceData[this.name] = this.value;
        }
      });

      page = '1';

      const data = {
        page,
        sort: sortBy,
        ...priceData,
        ...formData
      }

      sendAJAX(data);
    });
  }

  if (productFilter.length) {

    productFilter.on('change', function(e) {
      if (e.target.closest('.brand-filter__input')) {
        return false;
      }

      if (e.target.closest('.product-filter__check')) {
        page = '1';
      }

      formData = {};
      $.each($(this).serializeArray(), function() {
        if (formData[this.name]) {
          formData[this.name] += ',' + this.value;
        } else {
          formData[this.name] = this.value;
        }
      });


      const data = {
        page,
        sort: sortBy,
        ...priceData,
        ...formData,
      }

      sendAJAX(data);
    });
  }

  // handle cart item
  body.on('click', '.buy-button--buy', function () {
    const id = $(this).data('id');
    const data = {
      action: 'handle_cart_item',
      id
    }
    $.post(ajaxURL.url, data, function (response) {
      $(`button[data-id="${id}"]`).replaceWith(
        `<button data-id="${id}" class="buy-button buy-button--cart std-btn blue-btn font-16-22 fw-600 transition-default d-flex justify-content-center align-items-center">
          <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
              <path d="M21.8327 14.8306L21.8325 14.8315C21.6915 15.6066 21.4445 16.4439 20.8545 17.0873C20.2627 17.7326 19.3325 18.1758 17.84 18.1758H9.00916C7.53241 18.1758 6.26022 17.0732 6.05159 15.6105L4.43839 4.32358C4.34791 3.69431 3.80172 3.22014 3.16641 3.22014H2.88329C2.41338 3.22014 2.03203 2.83879 2.03203 2.36888C2.03203 1.89897 2.41338 1.51763 2.88329 1.51763H3.16746C4.64418 1.51763 5.91635 2.62024 6.12502 4.08285L21.8327 14.8306ZM21.8327 14.8306L22.9157 8.24413C22.9157 8.24398 22.9158 8.24384 22.9158 8.24369C23.0754 7.37027 22.8397 6.47724 22.2715 5.79613L22.2331 5.82816L22.2715 5.79612C21.7022 5.11381 20.8654 4.72265 19.9767 4.72265H6.21705L6.12502 4.08291L21.8327 14.8306ZM6.45895 6.42408H19.9757C20.3582 6.42408 20.717 6.59266 20.9629 6.8859C21.2085 7.17871 21.3095 7.56311 21.2384 7.95265L21.2383 7.95351L20.54 12.1999H13.5667C13.0968 12.1999 12.7154 12.5813 12.7154 13.0512C12.7154 13.5211 13.0968 13.9025 13.5667 13.9025H20.2597L20.1551 14.5412C20.1551 14.5413 20.155 14.5415 20.155 14.5416C20.034 15.2084 19.8715 15.6872 19.5368 16.0014C19.2031 16.3147 18.6884 16.4733 17.84 16.4733H9.00916C8.37386 16.4733 7.82756 15.9992 7.73705 15.3699L6.45895 6.42408ZM6.45895 6.42408L7.73705 15.3699L6.45895 6.42408ZM9.31471 22.9833C10.0795 22.9833 10.7001 22.3627 10.7001 21.5979C10.7001 20.8332 10.0795 20.2125 9.31471 20.2125H9.30402C8.53899 20.2125 7.92394 20.8334 7.92394 21.5979C7.92394 22.363 8.5513 22.9833 9.31471 22.9833ZM17.8614 20.2125H17.8507C17.0857 20.2125 16.4707 20.8334 16.4707 21.5979C16.4707 22.363 17.0969 22.9833 17.8614 22.9833C18.6262 22.9833 19.2469 22.3627 19.2469 21.5979C19.2469 20.8332 18.6262 20.2125 17.8614 20.2125Z" stroke-width="0.1"/>
          </svg>
          Перейти до кошика
        </button>
      `);
      $('.cart-menu__body').empty().html(response);
    });
  });

  // delete cart item button
  body.on('click', '.delete-cart-item', function() {
    const id = $(this).data('id');
    const data = {
      action: 'handle_cart_item',
      key: $(this).data('key')
    }
    $.post(ajaxURL.url, data, function(response) {
      $('.cart-menu__body').empty().html(response);
      $(`button[data-id="${id}"]`).replaceWith(
        `<button data-id="${id}" class="buy-button buy-button--buy std-btn purple-btn font-16-22 fw-600 transition-default d-block">Купити</button>`
      );
    });
  });

  // change cart item quantity
  body.on('click', '.item__qty-button', function () {
    const input = $(this).siblings('.item__qty-num');
    let act;
    if ($(this).hasClass('qty_plus')) {
      act = 'plus';
    } else {
      act = 'minus';
    }
    const data = {
      action: 'change_qty',
      key: $(this).data('key'),
      act,
      value: input.val()
    }
    $.post(ajaxURL.url, data, function (resp) {
      const response = JSON.parse(resp);
      $('.cart-menu__value').text(response.allCount);
      input.val(+response.itemCount);
      if (input.val() > 1) {
        input.siblings('.qty_minus').removeAttr('disabled');
      } else {
        input.siblings('.qty_minus').prop('disabled', true);
      }
      $('.cart-menu__order-price > p').html(response.total);
      const cartTotal = response.total.replace(/\D/g, '');
      if (cartTotal < 250) {
        $('.cart-menu__order').addClass('disabled-check');
        $('.error-min').addClass('show');
        $('.error-free').removeClass('show');
      } else {
        $('.cart-menu__order').removeClass('disabled-check');
        $('.error-min').removeClass('show');
      }
      if (cartTotal > 250 && cartTotal < 500) {
        $('.error-free').addClass('show');
      }
      if (cartTotal > 500) {
        $('.error-free').removeClass('show');
      }
    });
  });

  if (accountOrdersPage.length) {
    body.on('click', '.account-page__orders__sort-button', function() {
      const container = $('.account-page__orders__items');
      container.animate({opacity: .5}, 200);
      $(this).addClass('active').siblings('.account-page__orders__sort-button').removeClass('active');
      const data = {
        action: 'user_orders_sort',
        post_status: this.id
      }
      $.post(ajaxURL.url, data, function (response) {
        container.html(response).animate({opacity: 1}, 200);
      });
    });
  }
});
