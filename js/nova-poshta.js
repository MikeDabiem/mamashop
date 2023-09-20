jQuery(function ($) {
  if ($('.checkout-page').length) {
    const ajaxUrl = ajaxurl.url;
    const npServer = 'https://api.novaposhta.ua/v2.0/json/';
    const apiKey = '37b86cd843c0ba98180a0e05c6c3e87b';
    const regionName = $('#delivery_region-input');
    const regionRef = $('#delivery_region-input-ref');
    const citySearch = $('#cty-srch');
    const cityName = $('#delivery_city-input');
    const cityRef = $('#delivery_city-input-ref');
    const departsSearch = $('#nova_poshta_depart-search');
    const postomatSearch = $('#nova_poshta_postomat-search');
    const streetSearch = $('#nova_poshta_courier-search');

    function serverError(parent) {
      parent.find('.checkout-select__menu__items').html('Цей варіант тимчасово недоступний. Вибачте за незручності')
    }

    regionName.on('change', function() {
      citySearch.siblings('.checkout-select__menu__items').empty();
      cityName.val('');
      $('#delivery_city-input-ref').val('');
    });

    function ajaxSearch(input, action, ref, type = '') {
      if (input.attr('id') !== 'cty-srch' && !cityName.val()) {
        input.siblings('.checkout-select__menu__items').html('<p id="no-city-error" class="font-13-16 fw-500">Спочатку оберіть місто</p>');
        input.on('blur', function() {
          $('#no-city-error').remove();
        });
      } else {
        if (input.val() === '') {
          input.siblings('.checkout-select__menu__items').empty();
        } else {
          const data = {
            action,
            search: input.val(),
            ref,
            type
          }
          $.post(ajaxUrl, data, function(response) {
            if (input.val() !== '') {
              input.siblings('.checkout-select__menu__items').html(response);
            }
          });
        }
      }
    }

    citySearch.on('input', function() {
      ajaxSearch($(this), 'db_city_search', regionRef.val());
    });

    departsSearch.on('input', function() {
      ajaxSearch($(this), 'db_np_depart_search', cityRef.val(), 'department');
    });

    postomatSearch.on('input', function() {
      ajaxSearch($(this), 'db_np_depart_search', cityRef.val(), 'postomat');
    });

    // NP streets
    const streets = [];
    streetSearch.on('input', function() {
      const requestRegions = JSON.stringify({
        "apiKey": apiKey,
        "modelName": "Address",
        "calledMethod": "getStreet",
        "methodProperties": {
          "CityRef": cityRef.val(),
          "FindByString" : $(this).val(),
          "Page" : "1",
          "Limit" : "20"
        }
      });
      $.post(npServer, requestRegions, function (response) {
        const container = $('#nova_poshta_courier').find('.checkout-select__menu__items');
        container.empty();
        response.data.forEach(item => {
          const regionName = item.Description;
          if ($.inArray(regionName, streets)) {
            streets.push(regionName);
            container.append(
              `<div class="checkout-select__menu__item transition-default d-flex justify-content-between align-items-center" data-value="${regionName}">
                <p class="checkout-select__menu__item-title font-13-16 fw-400">${regionName}</p>
                <svg class="checkout-select__menu__item-check transition-default" xmlns="http://www.w3.org/2000/svg" width="14" height="10" fill="none"><path stroke-width="2" d="M1.686 4.516 5.55 8.382l6.764-6.765"/></svg>
              </div>`
            );
          }
        });
      }).fail(() => serverError($('#delivery_region')));
    });

    // NP regions
    // const requestRegions = JSON.stringify({
    //   "apiKey": apiKey,
    //   "modelName": "Address",
    //   "calledMethod": "getAreas"
    // });
    // $.post(server, requestRegions, function (response) {
    //   response.data.forEach(item => {
    //     const regionName = item.Description;
    //     if ($.inArray(regionName, regions)) {
    //       regions.push(regionName);
    //       $('#delivery_region').find('.checkout-select__menu__items').append(
    //         `<div class="checkout-select__menu__item transition-default d-flex justify-content-between align-items-center" data-value="${regionName}">
    //           <p class="checkout-select__menu__item-title font-13-16 fw-400">${regionName}</p>
    //           <svg class="checkout-select__menu__item-check transition-default" xmlns="http://www.w3.org/2000/svg" width="14" height="10" fill="none"><path stroke-width="2" d="M1.686 4.516 5.55 8.382l6.764-6.765"/></svg>
    //         </div>`
    //       );
    //     }
    //   });
    // }).fail(() => serverError($('#delivery_region')));

    // NP cities
    // citySearch.on('input', function() {
    //   const request = JSON.stringify({
    //     "apiKey": apiKey,
    //     "modelName": "Address",
    //     "calledMethod": "searchSettlements",
    //     "methodProperties": {
    //       "CityName" : $(this).val(),
    //       "Limit" : "20",
    //       "Page": 1
    //     }
    //   });
    //   $.post(server, request, function (response) {
    //     response.data.forEach((item) => {
    //       item.Addresses.forEach((item) => {
    //         const cityName = item.MainDescription;
    //         if (item.Area === regionInput.val() && !cities.includes(cityName)) {
    //           cities.push(cityName);
    //         }
    //       });
    //     });
    //     $('#delivery_city').find('.checkout-select__menu__items').empty();
    //     cities.forEach(cityName => {
    //       $('#delivery_city').find('.checkout-select__menu__items').append(
    //         `<div class="checkout-select__menu__item transition-default d-flex justify-content-between align-items-center" data-value="${cityName}">
    //           <p class="checkout-select__menu__item-title font-13-16 fw-400">${cityName}</p>
    //           <svg class="checkout-select__menu__item-check transition-default" xmlns="http://www.w3.org/2000/svg" width="14" height="10" fill="none"><path stroke-width="2" d="M1.686 4.516 5.55 8.382l6.764-6.765"/></svg>
    //         </div>`
    //       );
    //     });
    //     cities.length = 0;
    //   }).fail(() => serverError($('#delivery_city')));
    // });

    // NP departments
    // departsSearch.on('input', function () {
    //   if (cityInput.val()) {
    //     const thisInput = $(this);
    //     const request = JSON.stringify({
    //       "apiKey": apiKey,
    //       "modelName": "Address",
    //       "calledMethod": "getWarehouses",
    //       "methodProperties": {
    //         "CityName": cityInput.val(),
    //         "Limit": "20"
    //       }
    //     });
    //     $.post(server, request, function (response) {
    //       response.data.forEach((item) => {
    //         if (cityInput.val() && !departs.includes(item.Description)) {
    //           departs.push(item.Description);
    //         }
    //       });
    //       thisInput.siblings('.checkout-select__menu__items').empty();
    //       departs.forEach(cityName => {
    //         thisInput.siblings('.checkout-select__menu__items').append(
    //           `<div class="checkout-select__menu__item transition-default d-flex justify-content-between align-items-center" data-value="${cityName}">
    //           <p class="checkout-select__menu__item-title font-13-16 fw-400">${cityName}</p>
    //           <svg class="checkout-select__menu__item-check transition-default" xmlns="http://www.w3.org/2000/svg" width="14" height="10" fill="none"><path stroke-width="2" d="M1.686 4.516 5.55 8.382l6.764-6.765"/></svg>
    //         </div>`
    //         );
    //       });
    //       console.log(departs);
    //       departs.length = 0;
    //     });
    //   }
    // });
  }
});