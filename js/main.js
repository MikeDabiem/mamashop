jQuery(function($) {
  $.expr[":"].contains = $.expr.createPseudo(function(arg) {
    return function( elem ) {
      return $(elem).text().toLowerCase().indexOf(arg.toLowerCase()) >= 0;
    };
  });
  const body = $('body');

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
  function heartHandler() {
    const heart = $('.product-item__heart');
    if (heart.length) {
      heart.on('click', function() {
        $(this).toggleClass('active');
      });
    }
  }
  heartHandler();

  // random product rating
  const rating = $('.rating__stars-val');
  rating.each(function() {
    $(this).css('width', Math.floor(Math.random() * (100 - 10 + 1) + 10) + "%");
  });

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
      priceInputMin.on('input', function () {
        if (+$(this).val() > +priceRangeMinValue && +$(this).val() < +priceRangeMax.val() - minGap) {
          priceRangeMin.val($(this).val());
        } else if (+$(this).val() <= +priceRangeMinValue) {
          priceRangeMin.val(priceRangeMinValue);
        } else {
          priceRangeMin.val(+priceRangeMax.val() - minGap);
        }
        priceRangeMin.trigger('input');
      });
      priceInputMax.on('input', function () {
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

  // filters spoilers handler
  function filterGroupsSpoiler() {
    const filterSpoiler = $('.product-filter__spoiler');
    const checkedBox = $('.product-filter__check-checkbox:checked');
    checkedBox.each(function() {
      $(`.product-filter__spoiler[data-name="${$(this).attr('name')}"]`).removeClass('hide');
      $(`.product-filter__spoiler__content[data-name="${$(this).attr('name')}"]`).show();
    });
    if (filterSpoiler.length) {
      filterSpoiler.on('click', function () {
        $(this).toggleClass('hide');
        $(`.product-filter__spoiler__content[data-name="${$(this).data('name')}"]`).slideToggle(300);
      })
    }
  }

  // filters filter brands names
  function filterBrandsFilter() {
    const brandFilter = $('.brand-filter__input');
    if (brandFilter.length) {
      brandFilter.on('input', function() {
        const brandsParent = $(`.product-filter__spoiler__content[data-name="pa_brend"]`);
        if (brandFilter.val() === ' ') {
          brandFilter.val('');
        }
        if (brandFilter.val().length) {
          brandsParent.addClass('showall');
          brandsParent.children('.product-filter__check').hide();
          $(`.product-filter__check-label-title:contains(${brandFilter.val().toLowerCase()})`).parent().parent('.product-filter__check').show();
        } else {
          brandsParent.removeClass('showall');
          brandsParent.children('.product-filter__check').show();
        }
      });
    }
  }
  filterBrandsFilter();

  // spoil too many filters
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
      });
      moreFiltersButton.on('click', function() {
        $(this).toggleClass('active');
        if ($(this).hasClass('active')) {
          $(this).children('.product-filter__spoiler__content__more-text').text('Згорнути');
          $(this).parent('.product-filter__spoiler__content').animate({maxHeight: notSpoiledFilterItemHeight * $(this).siblings('.product-filter__check').length + 13 + brandInputHeight($(this)) + 'px'});
        } else {
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
  const filterArr = [];

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

  function chosenItemsHandler(checkbox) {
    const id = checkbox.attr('id');
    const name = $(`.product-filter__check-label[for="${id}"] > .product-filter__check-label-title`).text();
    if (checkbox.is(':checked')) {
      filterArr.push({name, id});
      filterItems.append(
        `<div class="product-filter__chosen-item d-flex align-items-center" data-name="${id}">
            <p class="font-12-16 fw-400">${name}</p>
            <label for="${id}" class="product-filter__chosen-item-close transition-default d-flex">
              <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="cross"><rect width="16" height="16" rx="8" fill="#494558"/><g id="Group 2088"><path id="Vector 73" d="M4.80078 4.80078L11.2007 11.2013" stroke="#F5E4E7" stroke-width="1.5"/><path id="Vector 74" d="M11.1992 4.80078L4.79928 11.2012" stroke="#F5E4E7" stroke-width="1.5"/></g></g></svg>
            </label>
          </div>`
      )
    } else {
      const filterId = filterItems.children(`[data-name="${id}"]`).data('name');
      if (filterArr.length) {
        filterItems.children()[filterArr.findIndex(el => el.id === filterId)].remove();
        filterArr.splice(filterArr.findIndex(el => el.id === filterId), 1);
      } else {
        filterItems.children().remove();
      }
    }
    hideChosenFiltersTitle();
  }

  function checkActiveFilters() {
    if (filterItems.length) {
      filterItems.children().each(function() {
        const checkbox = $(`#${$(this).data('name')}`);
        checkbox.prop('checked', true);
      });
    }
  }

  const filterSiblings = [];
  function filterCheckboxListener() {
    const filterCheckbox = $('.product-filter__check-checkbox');
    if (filterCheckbox.length) {
      filterCheckbox.on('change', function() {
        chosenItemsHandler($(this));
        if ($(this).is(':checked') || filterSiblings.length > 1) {
          filterSiblings.length = 0;
          if ($(this).parent().siblings('.product-filter__brand-filter').length) {
            filterSiblings.push($('.product-filter__brand-filter'));
          }
          filterSiblings.push($(this).parent());
          $(this).closest('.product-filter__check').siblings('.product-filter__check').each(function() {
            if (!filterSiblings.includes($(this))) {
              filterSiblings.push($(this));
            }
          });
          if ($(this).closest('.product-filter__check').siblings('.product-filter__spoiler__content__more').length) {
            filterSiblings.push($('.product-filter__spoiler__content__more--pad'));
            filterSiblings.push($('.product-filter__spoiler__content__more'));
          }
        }
      });
    }
  }
  filterCheckboxListener();

  function notHideFilters() {
    if (filterSiblings.length > 1) {
      $(`.product-filter__spoiler__content[data-name="${filterSiblings[1].children('.product-filter__check-checkbox').attr('name')}"]`).empty().append(filterSiblings);
    }
  }

  // clear filter form
  const clearFilters = $('.product-filter-clear');
  if (clearFilters.length) {
    clearFilters.on('click', function () {
      window.location.search = `s=${Object.fromEntries(new URLSearchParams(window.location.search)).s}`;
    });
  }

  // sort menu handler
  const sortSelect = $('.sort__select');
  const sortMenu = $('.sort__menu');
  if (sortSelect.length) {
    sortSelect.on('click', function () {
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
  const gallery = $('.single-product__image');
  if (gallery.length) {
    const mainImage = $('.single-product__image-main > img');
    const galleryImage = $('.single-product__image__gallery > img');
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
      tabButton.removeClass('active');
      $(this).addClass('active');
      tabButtonBorder.width($(this).outerWidth()).css({left: $(this).position().left - 2})
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

  const defaultData = {
    action: 'filter',
    s: urlParams.s,
    page
  }

  function sendAJAX(ajaxData) {
    searchResults.animate({opacity: .5}, 300);
    productFilterParent.animate({opacity: .5}, 300);
    const data = {...defaultData, ...ajaxData};
    const getParams = new URLSearchParams({...urlParams, ...ajaxData});
    getParams.delete('s');
    getParams.delete('page');
    const pageNum = page ? `&page=${page}` : null;
    window.history.pushState(null, '', `?s=${defaultData.s + pageNum}&${decodeURIComponent(getParams.toString())}`);
    $.get(ajaxurl.url, data, function(response) {
      searchResults.empty().append(response).animate({opacity: 1}, 300);
      heartHandler();
    });
    $.get(ajaxurl.url, {...data, action: 'hide_filters'}, function(response) {
      productFilter.empty().append(response);
      productFilterParent.animate({opacity: 1}, 300);
      notHideFilters();
      checkActiveFilters();
      filterCheckboxListener();
      spoilFilters();
      filterGroupsSpoiler();
      filterBrandsFilter();
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

  if (Object.keys(urlParams).length === 1 && !'s' in urlParams || Object.keys(urlParams).length > 1) {
    Object.values(urlParams).forEach(item => {
      item.split(',').forEach(item => {
        $(`input[value="${item}"]`).prop('checked', true);
      })
    });
    if (urlParams.price) {
      const price = urlParams.price.split('-');
      priceRangeMin.val(price[0]);
      priceRangeMax.val(price[1]);
      slideMin();
      slideMax();
    }
    if (urlParams.sort) {
      const sortMenuVal = $(`.sort__menu__item[data-value="${urlParams.sort}"]`);
      $('.sort__select-chosen').text(sortMenuVal.children('.sort__menu__item-title').text());
      $('.sort__menu__item').removeClass('active');
      sortMenuVal.addClass('active');
      $('.sort__select-input').val(urlParams.sort);
    }
    const data = {
      ...urlParams,
    }
    const checkedBox = $('.product-filter__check-checkbox:checked');
    if (checkedBox.length) {
      productFilter.trigger('change');
      checkedBox.each(function() {
        chosenItemsHandler($(this));
      })
    } else {
      sendAJAX(data);
    }
  }
  checkActiveFilters();
  filterGroupsSpoiler();
});

// script to function, ajax returns filters, run script function
// ajax for filters posts_per_page = -1