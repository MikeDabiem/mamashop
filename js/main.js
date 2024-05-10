jQuery(function($) {
  $.expr[":"].contains = $.expr.createPseudo(function(arg) {
    return function( elem ) {
      return $(elem).text().toLowerCase().indexOf(arg.toLowerCase()) >= 0;
    };
  });
  const body = $('body');
  const ajaxURL = phpData.ajaxurl;

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

  $('.header__catalog').on('click', () => {
    showMenu($('.catalog-menu'));
  });

  $('.header__btn').on('click', function(e) {
    if (($(this).hasClass('header__profile') || $(this).hasClass('header__fav')) && $(this).attr('href') === '#') {
      e.preventDefault();
      showMenu($('.user-login'));
    }
    if ($(this).hasClass('burger')) {
      showMenu(mainMenu);
    }
    if ($(this).hasClass('header__cart')) {
      showMenu($('.cart-menu'));
    }
  });

  // header search
  const searchInput = $('.header-search__input');
  const searchMenu = $('.header-search__menu');
  const searchForm = $('#search');
  if (searchInput.length) {
    // stop submit if empty
    searchForm.on('submit', e => {
      searchInput.val(searchInput.val().trim());
      if (searchInput.val() === '') {
        e.preventDefault();
      }
    });

    // show search menu
    function showSearchMenu() {
      searchMenu.slideDown(300).removeAttr('style').addClass('active');
    }

    // open search help menu
    searchInput.on('focus', () => {
      showSearchMenu();
    });

    searchInput.on('input', function() {
      if ($(this).val() === ' ') {
        $(this).val('');
      }
      if (!searchMenu.hasClass('active')) {
        showSearchMenu();
      }
    });

    searchInput.on('keyup', function(e) {
      if (e.key === "Escape") {
        $(this).trigger('blur');
        searchMenu.slideUp(300).removeClass('active');
      }
    });

    // add search help variants
    const searchHelpBlock = $('.search-try');
    const searchHelpList = $('.search-try__items');
    searchInput.on('input', function(e) {
      let searchHelp = [];
      if (searchInput.val() !== '') {
        searchHelp = phpData.searchHelpArr.filter(el => (el.toLowerCase().includes(e.target.value.toLowerCase())));
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

  // random product rating
  const rating = $('.rating__stars-val');
  if (rating.length) {
    rating.each(function() {
      const value = $(this).siblings('.rating-value').text();
      $(this).css('width', value * 20 + "%");
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
      if ($(`.catalog__categories__child[data-cat-child="${$(this).data('cat')}"]`).length) {
        e.preventDefault();
        catalogCategories.addClass('active');
        catalogCategoriesChildren.addClass('active').find(`[data-cat-child="${$(this).data('cat')}"]`).addClass('active');
        catalogBackTitle.text($(this).find($('.catalog__category-title')).text());
        catalogBack.addClass('active');
        catalogTitle.addClass('hide');
      }
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

  // filter show button
  const filterShowButton = $('.product-filter__filter-button');
  if (filterShowButton.length) {
    const filterBody = $('.search-page__filter');

    // show filter
    function showFilter() {
      filterBody.addClass('active');
      body.addClass('overflow-hidden');
    }

    // show filter on click filter button
    filterShowButton.on('click', showFilter);

    // show filter on swipe to right
    let startX, endX;

    body.on('touchstart', function(e) {
      startX = e.originalEvent.touches[0].pageX;
    });

    body.on('touchmove', function(e) {
      endX = e.originalEvent.touches[0].pageX;
    });

    body.on('touchend', function() {
      const threshold = 200;
      const deltaX = endX - startX;
      if (Math.abs(deltaX) > threshold && !filterBody.hasClass('active') && $(window).width() < 769 && deltaX > 0) {
        showFilter();
      }
    });

    // close filter
    function closeFilter() {
      filterBody.removeClass('active');
      body.removeClass('overflow-hidden');
    }

    // close filter on click close button
    $('.product-filter__mob-close').on('click', function() {
      closeFilter();
    });

    // close filter on swipe to left

    filterBody.on('touchstart', function(e) {
      startX = e.originalEvent.touches[0].pageX;
    });

    filterBody.on('touchmove', function(e) {
      endX = e.originalEvent.touches[0].pageX;
    });

    filterBody.on('touchend', function() {
      const threshold = 100;
      const deltaX = endX - startX;
      if (Math.abs(deltaX) > threshold && $(this).hasClass('active')) {
        if (deltaX < 0) {
          closeFilter();
        }
      }
    });

    $(window).on('resize', function() {
      if (filterBody.hasClass('active') && $(window).width() > 768) {
        closeFilter();
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
      searchMenu.slideUp(300).removeClass('active');
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
    function tabButtonBorder() {
      const tabTitle = $('.tab-button.active');
      $('.tab-button--border').width(tabTitle.outerWidth()).css({left: tabTitle.position().left - 2});
    }
    $(window).on('resize', tabButtonBorder);
    tabButton.on('click', function() {
      const id = $(this).attr('id');
      tabButton.removeClass('active');
      $(this).addClass('active');
      tabButtonBorder();
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
  const reviewForm = $('#review-form');
  const questionForm = $('.question__form');
  const reviewSuccessMsg = $('.review-success');
  const questionSuccessMsg = $('.question-success');

  if(makeReviewBtn.length) {
    makeReviewBtn.on('click', function() {
      if ($(this).hasClass('login')) {
        showMenu($('.user-login'));
      } else {
        $('.make-review').addClass('active');
        body.addClass('overflow-hidden');
      }
    });
  }

  if (askQuestionBtn.length) {
    askQuestionBtn.on('click', function() {
      if ($(this).hasClass('login')) {
        showMenu($('.user-login'));
      } else {
        $('.ask-question').addClass('active');
        body.addClass('overflow-hidden');
      }
    });
  }

  function showInputError(input) {
    if (input.siblings('.input--error-text').text() !== 'Заповніть будь ласка поле') {
      input.siblings('.input--error-text').text('Заповніть будь ласка поле');
    }
    input.addClass('input--error').siblings('.input--error-text').fadeIn(300);
    input.on('focus', function() {
      $(this).removeClass('input--error').siblings('.input--error-text').fadeOut(300);
    });
  }

  // click "Перейти до кошика" button in product card
  body.on('click', '.buy-button--cart', function() {
    showMenu($('.cart-menu'));
  });

  // click checkout link if total is less
  body.on('click', '.cart-menu__order', function(e) {
    if ($('.cart-menu__order').hasClass('disabled-check')) {
      e.preventDefault();
      const errorMin = $('.error-min');
      errorMin.addClass('red');
      setTimeout(() => {
        errorMin.removeClass('red');
      }, 5000);
    }
  });

  // toggle checkout tabs
  if ($('.checkout-page').length) {
    body.on('keypress', function(e) {
      const key = e.which;
      if(key === 13) {
        return false;
      }
    });
    const checkoutNextButton = $('.checkout-next-button');
    const checkoutChangeButton = $('.checkout-change-button');
    const buildingNum = $('#building-number');
    const apartmentNum = $('#apartment-number');
    const billingCityInput = $('#billing_city');

    // forbid change value to space
    $('.checkout__input-item').on('input', function() {
      if ($(this).val() === ' ') {
        $(this).val('');
      }
    });

    // disable next button in payment section if no one method is checked
    function payNextDisabler() {
      const payNextBtn = $('.payment__body .checkout-next-button');
      if (!$('.payment_method:checked').length) {
        payNextBtn.prop('disabled', true);
        $('.checkout-page__confirm').hide();
      } else {
        payNextBtn.removeAttr('disabled');
      }
    }

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
            showInputError($(this));
            errorsCount++;
          }
          if ($(this).is('#billing_email') && !$(this).val()) {
            $('.ready__item__email').addClass('d-none');
          }
          // remove error after focusing input
          $(this).on('focus', function() {
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

        if ($(this).parent().hasClass('delivery__body')) {
          const delRegionInput = $('#delivery_region-input');
          const delCityInput = $('#delivery_city-input');
          const billingAddress = $('#billing_address_1');
          const billingApartment = $('#billing_address_2');
          const shipMethParent = $('.shipping_method:checked').closest('.delivery__type__item');
          $('.ready__delivery__logo-image').hide();
          billingCityInput.val(delRegionInput.val() + ', ' + delCityInput.val());
          billingAddress.val(shipMethParent.find('.checkout-select-input').val());
          if (shipMethParent.has('#building-number').length && shipMethParent.has('#apartment-number').length && buildingNum.val()) {
            if (apartmentNum.val()) {
              billingApartment.val(`буд. ${buildingNum.val()}, кв. ${apartmentNum.val()}`);
            } else {
              billingApartment.val(`буд. ${buildingNum.val()}`);
            }
          } else {
            billingApartment.val('');
          }
          if (shipMethParent.attr('id').indexOf('nova_poshta') >= 0) {
            $('#np-logo').show();
          }

          const readyCity = $('.ready__item--city');
          const readyAddress = $('.ready__item--address');
          const payMethOnGetRadio = $('#payment_method_cod');
          if (shipMethParent.attr('id') === 'local_pickup' || shipMethParent.attr('id') === 'nova_poshta_courier') {
            if (shipMethParent.attr('id') === 'local_pickup') {
              billingCityInput.val('Київська, Київ');
              readyCity.text('Самовивіз');
              readyAddress.text(phpData.shopAddress);
            }
            payMethOnGetRadio.prop('checked', false);
            payMethOnGetRadio.parent().hide();
          } else {
            readyCity.text(`${delRegionInput.val()} область, м. ${delCityInput.val()}`);
            readyAddress.text(billingAddress.val() + (billingApartment.val() ? ', ' + billingApartment.val() : ''));
            payMethOnGetRadio.parent().show();
          }

          payNextDisabler();
        }

        if ($(this).parent().hasClass('payment__body')) {
          $('.checkout-page__confirm').fadeIn(300);
          const checkedRadioId = $('.payment_method:checked').attr('id');
          $('.ready__item--payment').html($(`.payment__item-label[for=${checkedRadioId}]`).html());
          $('.comment-title').text('Згорунти').siblings('.comment__body').slideDown(300).parent().addClass('active');
        }

        $(this).parent().slideUp(300);
        $(this).parent().siblings('.checkout-page__section__ready').slideDown(300);

        const nextSection = $(this).closest('.checkout-page__section').nextAll('.checkout-page__section').first();
        nextSection.find('.checkout-change-button').hide();
        nextSection.addClass('active').children('.checkout-page__section__body').slideDown(300);

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

    // check is one of payment method checked after change it
    $('.payment_method').on('change', function() {
      payNextDisabler();
    });

    // activate delivery next button
    const nextButton = $('.delivery__body').find('.checkout-next-button');
    function activateNextButton() {
      const checkedMethod = $('.shipping_method:checked');
      if (
        checkedMethod.parent().siblings('.item__select').find('.checkout-select__chosen-title').text().indexOf('Оберіть') < 0 &&
        (checkedMethod.attr('id') === 'shipping_method_0_nova_poshta_courier7' &&
        buildingNum.val() ||
        checkedMethod.attr('id') !== 'shipping_method_0_nova_poshta_courier7') &&
        $('#delivery_city-input').val()
      ) {
          nextButton.removeAttr('disabled');
      } else {
        nextButton.prop('disabled', true);
      }
    }

    $('.shipping_method').on('change', activateNextButton);
    $('.delivery__type').find('.checkout-select-input').on('change', activateNextButton);
    buildingNum.on('input', activateNextButton);

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
    $('.confirm-button').on('click', function() {
      const countryInput = $('#billing_country');
      if (countryInput.val() !== 'UA') {
        countryInput.val('UA');
      }
    });

    // coupon using
    function showCouponBody() {
      const couponBody = $('.coupon__body');

      if (couponBody.hasClass('active')) {
        couponBody.removeClass('active').slideUp(200);
        $(this).text('Додати');
      } else {
        couponBody.addClass('active').slideDown(200);
        $(this).text('Закрити');
      }
    }

    body.on('click', '.coupon__head-button', showCouponBody);


    body.on('click', '.coupon-button', function() {
      const couponInput = $('.coupon-input');

      if (!couponInput.val()) {
        showInputError(couponInput);
      } else {
        const data = {
          action: 'coupon_check',
          coupon: couponInput.val()
        }
        $.post(ajaxURL, data, function(response) {
          const resp = JSON.parse(response);
          if (!resp.error) {
            $('#discount_value').text(resp.discount + ' грн');
            $('.total__to_pay-value').text(resp.total + ' грн');
            showCouponBody();
          } else {
            showInputError(couponInput);
            $('.coupon-button').siblings('.input__wrapper').find('.input--error-text').text(resp.error);
          }
        });
      }
    });
  }


  // checkout select
  const checkoutSelect = $('.checkout-select');
  if (checkoutSelect.length) {
    const checkoutSelectMenu = $('.checkout-select__menu');
    const checkoutSelectChosen = $('.checkout-select__chosen');
    checkoutSelectChosen.on('click', function() {
      if ($(this).hasClass('active')) {
        $(this).removeClass('active');
        $(this).siblings('.checkout-select__menu').slideUp(300);
      } else {
        checkoutSelectChosen.removeClass('active');
        checkoutSelectMenu.slideUp(300);
        $(this).addClass('active');
        $(this).siblings('.checkout-select__menu').slideDown(300);
        if ($(this).siblings('.checkout-select__menu').has('.select-search-input').length) {
          setTimeout(() => {
            $(this).siblings('.checkout-select__menu').find('.select-search-input').trigger('focus');
          }, 200);
        }
      }
    });

    body.on('click', '.checkout-select__menu__item', function() {
      const billingCityInput = $('#billing_city');
      $(this).siblings().removeClass('active');
      $(this).addClass('active');
      $(this).closest('.checkout-select__menu').siblings().find('.checkout-select__chosen-title').text($(this).children('.checkout-select__menu__item-title').text());
      $(this).closest('.checkout-select__menu').siblings().find('.checkout-select-input').val($(this).data('value')).trigger('change');
      $(this).closest('.checkout-select__menu').siblings().find('.checkout-select-ref').val($(this).data('ref'));
      checkoutSelectMenu.slideUp(300);
      checkoutSelectChosen.removeClass('active');

      if ($(this).closest('.delivery__place__item').attr('id') === 'delivery_region') {
        billingCityInput.val($(this).children('.checkout-select__menu__item-title').text() + ', ');
        $('#delivery_city').find('.checkout-select__chosen-title').text('Оберіть населений пункт');
      } else if ($(this).closest('.delivery__place__item').attr('id') === 'delivery_city') {
        billingCityInput.val($('#delivery_region-input').val() + ', ' + $(this).children('.checkout-select__menu__item-title').text());
      }

      activateNextButton();
    });
    body.on('click', (e) => {
      if (!e.target.closest('.checkout-select')) {
        $('.checkout-select__chosen').removeClass('active');
        checkoutSelectMenu.slideUp(300);
      }
    });
  }

  // edit account in profile
  const editAccountForm = $('#edit-account');
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
          showInputError($(this));
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
          errorsCount = 0;
        });
      });
      if (errorsCount) {
        e.preventDefault();
      }
    });

    // show menu on account page on mobile screen
    const accMenu = $('.account-page__col1');
    const accContent = $('.account-page__col2');
    let hideMenu = false;
    function showAccMenu() {
      if ($(window).width() < 641 && !hideMenu) {
        accMenu.show();
        accContent.hide();
      } else {
        accMenu.removeAttr('style');
        accContent.removeAttr('style');
      }
    }
    showAccMenu();

    $('.menu__item[href*="edit-account"]').on('click', function(e) {
      if ($(window).width() < 641) {
        e.preventDefault();
        accMenu.hide();
        accContent.show();
        hideMenu = true;
        history.pushState(null, null);
      }
    });

    $(window).on('popstate', function() {
      if (hideMenu) {
        location.reload();
      }
    });
    $(window).on('resize', showAccMenu);
  }

  // account orders sort
  const accountOrdersPage = $('.account-page__orders');
  if (accountOrdersPage.length) {
    body.on('click', '.account-page__orders__item__head', function() {
      $(this).parent().toggleClass('active');
      $(this).siblings('.account-page__orders__item__body').slideToggle(300);
    });
  }

  // handle cart item
  body.on('click', '.buy-button--buy', function () {
    const idArr = [];
    idArr.push($(this).data('id'));
    cartItemsAJAX(idArr);
  });

  // buy all on favorites page
  body.on('click', '.favorites__footer-button', function() {
    const idArr = [];
    $('.buy-button--buy').each(function() {
      idArr.push($(this).data('id'));
    });
    cartItemsAJAX(idArr);
  });

  // show changed password message
  if (window.location.search === '?password=changed') {
    $('.login-new-password').removeClass('d-none');
    showMenu($('.user-login'));
    window.history.replaceState(null, '', window.location.origin);
  }

  // show thank you message
  if (window.location.search.includes('success-order=')) {
    showMenu($('.success-message'));
    window.history.replaceState(null, '', window.location.origin);
  }

  // hide thank you message
  body.on('click', '.success-message-button', function() {
    blurBG.trigger('click');
  });

  // user register form height
  const userLoginForm = $('#loginform');
  const userRegisterForm = $('#registerform');
  if (userLoginForm.length && userRegisterForm.length) {
    const height = userLoginForm.height();
    userRegisterForm.height(height);
  }

  // switch log in / registration button
  $('.login__switch-button').on('click', function() {
    $(this).addClass('active').siblings().removeClass('active');
    $('.user-login-form').fadeOut(200);
    setTimeout(() => {
      if ($(this).hasClass('login-signin')) {
        userLoginForm.fadeIn(200);
      } else if ($(this).hasClass('login-signup')) {
        userRegisterForm.fadeIn(200);
      }
    }, 200);
  });

  // show password button
  $('.show-password').on('click', function() {
    const input = $(this).siblings('input');
    if (input.attr('type') === 'password') {
      $(this).addClass('active');
      input.attr('type', 'text');
    } else {
      $(this).removeClass('active');
      input.attr('type', 'password');
    }
  });

  // check existing email
  const regEmail = $('#user_reg_email');
  let emailExists = '';
  if (regEmail.length) {
    regEmail.on('blur', function() {
      const emailInput = $(this);
      const data = {
        action: 'check_email',
        email: emailInput.val()
      }
      $.post(ajaxURL, data, function(response) {
        emailExists = response;
        if (emailExists !== '') {
          showInputError(emailInput);
          emailInput.siblings('.input--error-text').text(response);
        }
      });
    });
  }

  // show shipping method selector
  const shippingMethod = $('.shipping_method');
  if (shippingMethod.length) {
    function showShipSelector() {
      shippingMethod.each(function() {
        $(this).closest('.delivery__type__item').removeClass('active').children('.item__select').slideUp(300);
        if ($(this).is(':checked')) {
          $(this).closest('.delivery__type__item').addClass('active').children('.item__select').slideDown(300);
        }
      });
    }
    showShipSelector();
    shippingMethod.on('change', showShipSelector);
  }

  // reset password form validation
  const resetPassForm = $('#resetpassform');
  if (resetPassForm.length) {
    resetPassForm.on('submit', function(e) {
      const newPass = $('#pass1');
      const repeatPass = $('#pass2');
      if (!newPass.val()) {
        e.preventDefault();
        showInputError(newPass);
      } else if (newPass.val().length < 8) {
        e.preventDefault();
        showInputError(newPass);
        newPass.siblings('.input--error-text').text('Пароль має містити не менше 8 символів');
      }
      if (!repeatPass.val()) {
        e.preventDefault();
        showInputError(repeatPass);
      } else if (repeatPass.val() !== newPass.val()) {
        e.preventDefault();
        showInputError(repeatPass);
        repeatPass.siblings('.input--error-text').text('Паролі не співпадають');
      }
    });
  }

  // show menu on info page
  const infoPageMenuSelect = $('.info-page__menu__select');
  if (infoPageMenuSelect.length) {
    const infoPageMenu = $('.info-page__menu');
    infoPageMenuSelect.on('click', function() {
      if ($(this).hasClass('active')) {
        $(this).removeClass('active');
        infoPageMenu.slideUp(300);
      } else {
        $(this).addClass('active');
        infoPageMenu.slideDown(300);
      }
    });
    $(window).on('resize', function() {
      if ($(window).width() > 900 && infoPageMenu[0].hasAttribute('style')) {
        infoPageMenuSelect.removeClass('active');
        infoPageMenu.removeAttr('style');
      }
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

  if (productFilter.length) {
    productFilter.find('input:checkbox').each(function() {
      const nameAttr = $(this).attr('name');
      if (nameAttr in urlParams) {
        formData[nameAttr] = urlParams[nameAttr];
      }
    });
  }

  const defaultData = {
    action: 'filter',
    category: phpData.category,
    ...searchString,
    page
  }

  function sendAJAX(ajaxData) {
    searchResults.children('.shop4ik-spinner').addClass('active');
    productFilterParent.animate({opacity: .5}, 300);
    const data = {...defaultData, ...ajaxData};
    const getParams = new URLSearchParams(ajaxData);
    const search = searchString.s ? `s=${searchString.s}` : '';
    window.history.pushState(null, '', `?${search}&${decodeURIComponent(getParams.toString())}`);
    $.get(ajaxURL, data, function(response) {
      searchResults.empty().append(response);
    });
    $.get(ajaxURL, {...data, action: 'hide_filters'}, function(response) {
      productFilter.empty().append(response);
      productFilterParent.animate({opacity: 1}, 300);
      spoilFilters();
      $('.product-filter__chosen-item').each(function() {
        const forAttribute = $(this).children('label').attr('for');
        if (!$('#' + forAttribute).length) {
          $(this).remove();
        }
      });
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
      if ($(window).width() < 769) {
        closeFilter();
      }
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

  // AJAX for cart items
  const cartSpinner = $('.cart-menu').children('.shop4ik-spinner');
  function cartItemsAJAX(idArr) {
    cartSpinner.addClass('active');
    const data = {
      action: 'handle_cart_item',
      id: idArr
    }
    $.post(ajaxURL, data, function (response) {
      $.each(idArr, function() {
        $(`button[data-id="${this}"]`).replaceWith(
          `<button data-id="${this}" class="buy-button buy-button--cart std-btn blue-btn font-16-22 fw-600 transition-default d-flex justify-content-center align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                <path d="M21.8327 14.8306L21.8325 14.8315C21.6915 15.6066 21.4445 16.4439 20.8545 17.0873C20.2627 17.7326 19.3325 18.1758 17.84 18.1758H9.00916C7.53241 18.1758 6.26022 17.0732 6.05159 15.6105L4.43839 4.32358C4.34791 3.69431 3.80172 3.22014 3.16641 3.22014H2.88329C2.41338 3.22014 2.03203 2.83879 2.03203 2.36888C2.03203 1.89897 2.41338 1.51763 2.88329 1.51763H3.16746C4.64418 1.51763 5.91635 2.62024 6.12502 4.08285L21.8327 14.8306ZM21.8327 14.8306L22.9157 8.24413C22.9157 8.24398 22.9158 8.24384 22.9158 8.24369C23.0754 7.37027 22.8397 6.47724 22.2715 5.79613L22.2331 5.82816L22.2715 5.79612C21.7022 5.11381 20.8654 4.72265 19.9767 4.72265H6.21705L6.12502 4.08291L21.8327 14.8306ZM6.45895 6.42408H19.9757C20.3582 6.42408 20.717 6.59266 20.9629 6.8859C21.2085 7.17871 21.3095 7.56311 21.2384 7.95265L21.2383 7.95351L20.54 12.1999H13.5667C13.0968 12.1999 12.7154 12.5813 12.7154 13.0512C12.7154 13.5211 13.0968 13.9025 13.5667 13.9025H20.2597L20.1551 14.5412C20.1551 14.5413 20.155 14.5415 20.155 14.5416C20.034 15.2084 19.8715 15.6872 19.5368 16.0014C19.2031 16.3147 18.6884 16.4733 17.84 16.4733H9.00916C8.37386 16.4733 7.82756 15.9992 7.73705 15.3699L6.45895 6.42408ZM6.45895 6.42408L7.73705 15.3699L6.45895 6.42408ZM9.31471 22.9833C10.0795 22.9833 10.7001 22.3627 10.7001 21.5979C10.7001 20.8332 10.0795 20.2125 9.31471 20.2125H9.30402C8.53899 20.2125 7.92394 20.8334 7.92394 21.5979C7.92394 22.363 8.5513 22.9833 9.31471 22.9833ZM17.8614 20.2125H17.8507C17.0857 20.2125 16.4707 20.8334 16.4707 21.5979C16.4707 22.363 17.0969 22.9833 17.8614 22.9833C18.6262 22.9833 19.2469 22.3627 19.2469 21.5979C19.2469 20.8332 18.6262 20.2125 17.8614 20.2125Z" stroke-width="0.1"/>
            </svg>
            Перейти до кошика
          </button>
        `);
      });
      $('.cart-menu__body').empty().html(response);

      cartSpinner.removeClass('active');
    });
  }

  // delete cart item button
  body.on('click', '.delete-cart-item', function() {
    cartSpinner.addClass('active');

    const id = $(this).data('id');
    const data = {
      action: 'handle_cart_item',
      key: $(this).data('key')
    }
    $.post(ajaxURL, data, function(response) {
      $('.cart-menu__body').empty().html(response);
      $(`button[data-id="${id}"]`).replaceWith(
        `<button data-id="${id}" class="buy-button buy-button--buy std-btn purple-btn font-16-22 fw-600 transition-default d-block">Купити</button>`
      );

      cartSpinner.removeClass('active');
    });
  });

  // change cart item quantity
  body.on('click', '.item__qty-button', function () {
    const input = $(this).siblings('.item__qty-num');
    if ($(this).hasClass('qty_minus')) {
      if (input.val() > 1) {
        input.val(+input.val() - 1).trigger('change');
      }
      if (input.val() <= 1) {
        $(this).prop('disabled', true);
      }
    } else {
      input.val(+input.val() + 1).trigger('change');
      $(this).siblings('.qty_minus').removeAttr('disabled');
    }
  });

  let qtyTimer;
  body.on('change', '.item__qty-num', function() {
    const input = $(this);
    clearTimeout(qtyTimer);
    qtyTimer = setTimeout(changeQty, 1000);

    function changeQty() {
      cartSpinner.addClass('active');

      const data = {
        action: 'change_qty',
        key: input.data('key'),
        value: input.val()
      }
      $.post(ajaxURL, data, function (resp) {
        const response = JSON.parse(resp);

        $('.cart-menu__value').text(response.allCount);
        input.val(+response.itemCount);
        $('.cart-menu__order-price > p').html(response.total);

        const cartTotal = +response.total.replace(/\D/g, '');
        const minOrderPrice =  +phpData.minOrderPrice;
        if (cartTotal < minOrderPrice) {
          $('.cart-menu__order').addClass('disabled-check');
          $('.error-min').addClass('show');
          $('.error-free').removeClass('show');
        } else {
          $('.cart-menu__order').removeClass('disabled-check');
          $('.error-min').removeClass('show');
        }
        if (cartTotal >= minOrderPrice) {
          $('.error-free').addClass('show');
        }

        cartSpinner.removeClass('active');
      });
    }
  });

  // change account page tab
  function accPageTabChanger(container, button, data) {
    container.animate({opacity: .5}, 200);
    button.addClass('active').siblings('.account-page__tab-button').removeClass('active');
    $.post(ajaxURL, data, function (response) {
      container.html(response).animate({opacity: 1}, 200);
    });
  }

  // sort orders by status
  body.on('click', '.account-page__tab-button', function() {
    if (this.id === 'sort-all' || this.id === 'sort-processing' || this.id === 'sort-completed') {
      const container = $('.account-page__orders__items');
      const data = {
        action: 'user_orders_sort',
        post_status: this.id,
      }
      accPageTabChanger(container, $(this), data);
    }
    if (this.id === 'review' || this.id === 'question') {
      const container = $('.account-page__reviews__items');
      const data = {
        action: 'rev_q_tabs',
        type: this.id
      }
      accPageTabChanger(container, $(this), data);
    }
  });

  // repeat order
  body.on('click', '.order-repeat', function() {
    const idArr = [];
    $(this).parent().siblings('.item__products').children('.item__product').each(function() {
      idArr.push($(this).data('id').split('-')[1]);
    });
    const data = {
      action: 'order_repeat',
      id: idArr
    }
    $.post(ajaxURL, data, function(response) {
      window.location.href = response;
    });
  });

  // account favorites
  body.on('click', '.add-to-fav', function() {
    const button = $(this);
    if ($(this).data('id') === 'login') {
      showMenu($('.user-login'));
    } else {
      const data = {
        action: 'user_favorites',
        prod_id: $(this).data('id').split('-')[1]
      }
      $.post(ajaxURL, data, function () {
        if (button.hasClass('active')) {
          button.removeClass('active');
        } else {
          button.addClass('active');
        }
      });
    }
  });

  // remove from favorites
  body.on('click', '.favorites__item-delete', function() {
    const container = $('.account-page__col2');
    const data = {
      action: 'remove_user_favorites',
      prod_id: $(this).data('id').split('-')[1]
    }
    container.animate({opacity: .5}, 200)
    $.post(ajaxURL, data, function (response) {
      container.html(response).animate({opacity: 1}, 200);
    });
  });

  // login form
  const userLoginInput = $('#user_login');
  userLoginForm.on('submit', function(e) {
    e.preventDefault();
    const userPasswordInput = $('#user_pass');
    if (!userLoginInput.val()) {
      showInputError(userLoginInput);
    } else if (!userLoginInput.val().toLowerCase().match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)) {
      showInputError(userLoginInput);
      userLoginInput.siblings('.input--error-text').text('Невірний формат email');
    } else {
      const data = {
        action: 'login_user',
        login: userLoginInput.val(),
        password: userPasswordInput.val(),
        remember: $('#rememberme').is(':checked')
      }
      $.post(ajaxURL, data, function (response) {
        switch (response) {
          case 'login_error':
            showInputError(userLoginInput);
            userLoginInput.siblings('.input--error-text').text('Такого користувача не зареєстровано');
            break;
          case 'password_error':
            showInputError(userPasswordInput);
            userPasswordInput.siblings('.input--error-text').text('Невірний пароль');
            break;
          default:
            location.reload();
            break;
        }
      });
    }
  });

  // register form
  userRegisterForm.on('submit', function(e) {
    e.preventDefault();
    let errorsCount = 0;
    $(this).find('.reg_input').each(function() {
      if (
        $(this).hasClass('required') &&
        $(this).val().length < 2
      ) {
        showInputError($(this));
        errorsCount++;
      } else if (
        $(this).is('#user_reg_email') &&
        !$(this).val().toLowerCase().match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)
      ) {
        $(this).addClass('input--error');
        $(this).siblings('.input--error-text').text('Невірний формат адреси електронної пошти');
        $(this).siblings('.input--error-text').fadeIn(300);
        errorsCount++;
      } else if (emailExists !== '') {
        errorsCount++;
      } else if (
        $(this).is('#user_reg_password') &&
        $(this).val().length < 8
      ) {
        $(this).addClass('input--error');
        $(this).siblings('.input--error-text').text('Пароль має містити не менше 8 символів');
        $(this).siblings('.input--error-text').fadeIn(300);
        errorsCount++;
      } else if (
        $(this).is('#user_reg_password_repeat') &&
        $(this).val() !== $('#user_reg_password').val()
      ) {
        $(this).addClass('input--error');
        $(this).siblings('.input--error-text').text('Паролі не співпадають');
        $(this).siblings('.input--error-text').fadeIn(300);
        errorsCount++;
      }
      $(this).on('focus', function() {
        errorsCount = 0;
      });
    });
    if (!errorsCount) {
      $('#user_reg_login').val($('#user_reg_email').val());
      $('#user_reg_display_name').val($('#user_reg_lastname').val() + ' ' + $('#user_reg_firstname').val())
      const data = {
        action: 'register_user',
        reg: $(this).serializeArray()
      }
      $.post(ajaxURL, data, function () {
        location.reload();
      });
    }
  });

  // reset password
  const lostpassUserLogin = $('#lostpass_user_login');
  $('.lost-password').on('click', function() {
    blurBG.trigger('click');
    showMenu($('.lostpassword'));
    if (userLoginInput.val()) {
      lostpassUserLogin.val(userLoginInput.val());
    }
  });

  $('.lostpassword-cancel-button').on('click', function() {
    blurBG.trigger('click');
    showMenu($('.user-login'))
  });

  $('.lostpassword-success-button').on('click', function() {
    blurBG.trigger('click');
  });

  // get more reviews
  let revOffset = 3;
  let qOffset = 3;
  body.on('click', '.reviews__more', function() {
    const button = $(this);
    const data = {
      action: 'get_next_reviews',
      prod_id: button.data('id'),
      offset: button.data('type') === 'review' ? revOffset : qOffset,
      type: button.data('type')
    }
    $.post(ajaxURL, data, function(response) {
      button.replaceWith(response);
      if (button.data('type') === 'review') {
        revOffset += 3;
      } else {
        qOffset += 3;
      }
    });
  });

  // make new review
  if (reviewForm.length) {
    const reviewTextInput = $('#review-text');
    reviewForm.on('submit', function(e) {
      e.preventDefault();
      if (reviewTextInput.val() === '') {
        showInputError(reviewTextInput);
      } else {
        const data = {
          action: 'new_comment',
          rev_form: $(this).serializeArray()
        }
        $.post(ajaxURL, data, function() {
          reviewForm.addClass('d-none');
          reviewSuccessMsg.removeClass('d-none');
        });
      }
    });
  }

  // ask new question
  if (questionForm.length) {
    const questionTextInput = $('#question-text');
    questionForm.on('submit', function(e) {
      e.preventDefault();
      if (questionTextInput.val() === '') {
        showInputError(questionTextInput);
      } else {
        const data = {
          action: 'new_comment',
          ask_form: $(this).serializeArray()
        }
        $.post(ajaxURL, data, function() {
          questionForm.addClass('d-none');
          questionSuccessMsg.removeClass('d-none');
        });
      }
    });
  }
  // hide success message after review/question
  $('.success-button').on('click', () => {
    blurBG.trigger('click');
  });

  // change password
  $('#change-password-form').on('submit', function(e) {
    e.preventDefault();
    let errorsCount = 0;
    $(this).find('.woocommerce-Input').each(function() {
      if ($(this).val() === '') {
        showInputError($(this));
        errorsCount++;
      } else if ($(this).attr('id') === 'password_new' && $(this).val().length < 8) {
        showInputError($(this));
        $(this).siblings('.input--error-text').text('Пароль має містити не менше 8 символів');
        errorsCount++;
      } else if ($(this).attr('id') === 'password_repeat' && $(this).val() !== $('#password_new').val()) {
        showInputError($(this));
        $(this).siblings('.input--error-text').text('Паролі не співпадають');
        errorsCount++;
      }
    });
    if (!errorsCount) {
      const data = {
        action: 'change_password',
        data: $(this).serializeArray()
      }
      $.post(ajaxURL, data, function(response) {
        if (response === 'password-error') {
          const currentPassInput = $('#password_current');
          showInputError(currentPassInput);
          currentPassInput.siblings('.input--error-text').text('Не вірний пароль');
        } else if (response === 'success') {
          $('.security-submit-button')
            .addClass('success')
            .html('<svg xmlns="http://www.w3.org/2000/svg" width="23" height="22" viewBox="0 0 23 22" fill="none"><path d="M2.64014 10.3535L8.97803 16.6914L20.3603 5.30908" stroke="white" stroke-width="2" stroke-linecap="round"/></svg> Пароль змінено');
          setTimeout(() => {
            location.reload();
          }, 1000);
        }
      });
    }
  });

  const lostpasswordForm = $('#lostpasswordform');
  if (lostpasswordForm.length) {
    lostpasswordForm.on('submit', function(e) {
      e.preventDefault();
      if (!lostpassUserLogin.val()) {
        showInputError(lostpassUserLogin);
      } else if (!lostpassUserLogin.val().toLowerCase().match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)) {
        showInputError(lostpassUserLogin);
        lostpassUserLogin.siblings('.input--error-text').text('Невірний формат адреси електронної пошти');
      } else {
        const data = {
          action: 'check_email',
          email: lostpassUserLogin.val()
        }
        $.post(ajaxURL, data, function(response) {
          if (response === 'Користувач з таким Email вже існує') {
            const data = {
              action: 'lost_password_email',
              email: lostpassUserLogin.val()
            }
            $.post(ajaxURL, data, function() {
              lostpasswordForm.slideUp(300);
              $('.lostpassword-success').slideDown(300);
            });
          } else {
            showInputError(lostpassUserLogin);
            lostpassUserLogin.siblings('.input--error-text').text('Цей email не зареєстровано на цьому сайті');
          }
        });
      }
    });
  }

  // wait for finish input
  function inputWaiter(input, respTarget, ajaxAction, strLen, needClear = true) {
    let typingTimer;
    const doneTypingInterval = 500;

    input.on('keyup', function () {
      clearTimeout(typingTimer);
      if (input.val()) {
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
      } else if (needClear) {
        respTarget.empty();
      }
    });

    function doneTyping () {
      input.val(input.val().trimStart());
      if (input.val().length >= strLen) {
        const data = {
          action: ajaxAction,
          search: input.val().trim()
        }
        $.get(ajaxURL, data, function(response) {
          respTarget.html(response);
        });
      } else if (needClear) {
        respTarget.empty();
      }
    }
  }

  // search desktop
  if (searchForm.length) {
    const searchCatItems = $('.search-cat__items');
    const searchProductsList = $('.search-popular__items');
    inputWaiter(searchInput, searchCatItems, 'search_helper_categories', 0, false);
    inputWaiter(searchInput, searchProductsList, 'search_helper_products', 0, false);
  }

  // search on mobile search page
  if ($('.mobile-search').length) {
    const mobSearchInput = $('.mobile-search__form__input');
    const mobSearchContent = $('.mobile-search__content');

    inputWaiter(mobSearchInput, mobSearchContent,  'mobile_search', 3);
  }

  if ($('.banner').length && $('.banner__item').length > 1) {
    body.animate({opacity: 1}, 1000);
  } else {
    body.css({opacity: 1});
  }
});