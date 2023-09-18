jQuery(function ($) {
  if ($('.checkout-page').length) {
    const server = 'https://api.novaposhta.ua/v2.0/json/';
    const apiKey = '37b86cd843c0ba98180a0e05c6c3e87b';
    const regionInput = $('#delivery_region-input');
    const citySearch = $('#cty-srch');
    const cityInput = $('#delivery_city-input');
    const departsSearch = $('#nova_poshta_depart-search');
    const regions = [regionInput.val()];
    const cities = [];
    const departs = [];

    function serverError(parent) {
      parent.find('.custom-select__menu__items').html('Сервер тимчасово недоступний. Вибачте за незручності')
    }

    // NP regions
    const requestRegions = JSON.stringify({
      "apiKey": apiKey,
      "modelName": "Address",
      "calledMethod": "getAreas"
    });
    $.post(server, requestRegions, function (response) {
      response.data.forEach(item => {
        const regionName = item.Description;
        if ($.inArray(regionName, regions)) {
          regions.push(regionName);
          $('#delivery_region').find('.custom-select__menu__items').append(
            `<div class="custom-select__menu__item transition-default d-flex justify-content-between align-items-center" data-value="${regionName}">
              <p class="custom-select__menu__item-title font-13-16 fw-400">${regionName}</p>
              <svg class="custom-select__menu__item-check transition-default" xmlns="http://www.w3.org/2000/svg" width="14" height="10" fill="none"><path stroke-width="2" d="M1.686 4.516 5.55 8.382l6.764-6.765"/></svg>
            </div>`
          );
        }
      });
    }).fail(() => serverError($('#delivery_region')));

    // NP cities
    citySearch.on('input', function() {
      const request = JSON.stringify({
        "apiKey": apiKey,
        "modelName": "Address",
        "calledMethod": "searchSettlements",
        "methodProperties": {
          "CityName" : $(this).val(),
          "Limit" : "20",
          "Page": 1
        }
      });
      $.post(server, request, function (response) {
        response.data.forEach((item) => {
          item.Addresses.forEach((item) => {
            const cityName = item.MainDescription;
            if (item.Area === regionInput.val() && !cities.includes(cityName)) {
              cities.push(cityName);
            }
          });
        });
        $('#delivery_city').find('.custom-select__menu__items').empty();
        cities.forEach(cityName => {
          $('#delivery_city').find('.custom-select__menu__items').append(
            `<div class="custom-select__menu__item transition-default d-flex justify-content-between align-items-center" data-value="${cityName}">
              <p class="custom-select__menu__item-title font-13-16 fw-400">${cityName}</p>
              <svg class="custom-select__menu__item-check transition-default" xmlns="http://www.w3.org/2000/svg" width="14" height="10" fill="none"><path stroke-width="2" d="M1.686 4.516 5.55 8.382l6.764-6.765"/></svg>
            </div>`
          );
        });
        cities.length = 0;
      }).fail(() => serverError($('#delivery_city')));
    });

    // NP departments
    departsSearch.on('input', function () {
      if (cityInput.val()) {
        const thisInput = $(this);
        const request = JSON.stringify({
          "apiKey": apiKey,
          "modelName": "Address",
          "calledMethod": "getWarehouses",
          "methodProperties": {
            "CityName": cityInput.val(),
            "Limit": "20"
          }
        });
        $.post(server, request, function (response) {
          response.data.forEach((item) => {
            if (cityInput.val() && !departs.includes(item.Description)) {
              departs.push(item.Description);
            }
          });
          thisInput.siblings('.custom-select__menu__items').empty();
          departs.forEach(cityName => {
            thisInput.siblings('.custom-select__menu__items').append(
              `<div class="custom-select__menu__item transition-default d-flex justify-content-between align-items-center" data-value="${cityName}">
              <p class="custom-select__menu__item-title font-13-16 fw-400">${cityName}</p>
              <svg class="custom-select__menu__item-check transition-default" xmlns="http://www.w3.org/2000/svg" width="14" height="10" fill="none"><path stroke-width="2" d="M1.686 4.516 5.55 8.382l6.764-6.765"/></svg>
            </div>`
            );
          });
          console.log(departs);
          departs.length = 0;
        });
      }
    });

    $('.select-search-input').on('input', function() {
      if ($(this).attr('id') !== 'cty-srch' && !cityInput.val()) {
        $(this).siblings('.custom-select__menu__items').html('<p class="font-13-16 fw-500">Спочатку оберіть місто</p>')
      }
    });
  }
});