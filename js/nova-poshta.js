jQuery(function ($) {
  if ($('.checkout-page').length) {
    const server = 'https://api.novaposhta.ua/v2.0/json/';
    const apiKey = '37b86cd843c0ba98180a0e05c6c3e87b';
    const citiesInput = $('#order-city');
    const departsInput = $('#order-depart');
    const regions = [$('#delivery_region-input').val()];
    const cities = [];
    const departs = [];

    // NP regions
    const requestRegions = JSON.stringify({
      "apiKey": apiKey,
      "modelName": "Address",
      "calledMethod": "getAreas"
    });
    $.post(server, requestRegions, function (response) {
      // console.log(response.data)
      response.data.forEach(item => {
        const regionName = item.Description;
        if ($.inArray(regionName, regions)) {
          regions.push(regionName);
          $('#delivery_region').find('.custom-select__menu').append(
            `<div class="custom-select__menu__item transition-default d-flex justify-content-between align-items-center" data-value="${regionName}">
              <p class="custom-select__menu__item-title font-13-16 fw-400">${regionName}</p>
              <svg class="custom-select__menu__item-check transition-default" xmlns="http://www.w3.org/2000/svg" width="14" height="10" fill="none"><path stroke-width="2" d="M1.686 4.516 5.55 8.382l6.764-6.765"/></svg>
            </div>`
          );
        } else {
          // const requestCities = JSON.stringify({
          //   "apiKey": apiKey,
          //   "modelName": "Address",
          //   // "calledMethod": "getSettlements",
          //   // "methodProperties": {
          //   //   "AreaRef": '71508131-9b87-11de-822f-000c2965ae0e'
          //   // }
          // });
          // $.post(server, requestCities, function (cities) {
          //   console.log(cities);
          // });
        }
      });
    });

    // NP cities
    const requestCities = JSON.stringify({
      "apiKey": apiKey,
      "modelName": "Address",
      "calledMethod": "getCities",
    });
    // $.post(server, requestCities, function (response) {
    //   console.log(response);
      // response.data.forEach((item) => {
      //   item.Addresses.forEach((item) => {
      //     if (item.Area === regionInput.val() && !cities.includes(item.MainDescription)) {
      //       cities.push(item.MainDescription);
      //     }
      //   });
      // });
    // });

    // NP departments
    departsInput.on('input', function () {
      const request = JSON.stringify({
        "apiKey": apiKey,
        "modelName": "Address",
        "calledMethod": "getWarehouses",
        "methodProperties": {
          "CityName": citiesInput.val(),
          "Limit": "20"
        }
      });
      $.post(server, request, function (response) {
        response.data.forEach((item) => {
          if (citiesInput.val() && !departs.includes(item.Description)) {
            departs.push(item.Description);
          }
        });
      });
    });
  }
});