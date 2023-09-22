// jQuery(function ($) {
//   if ($('.checkout-page').length) {
//     const upServer = 'https://ukrposhta.ua/address-classifier-ws/get_postoffices_by_postindex?pi=01001';
//     const request = {
//       pc: '40000'
//     }
//     $.get(upServer, request, function (response) {
//       console.log(response);
//     });
//     $.ajax({
//       type: 'GET',
//       url: upServer,
//       headers: {
//         "Authorization":'Bearer 15747227214599808511',
//         "Accept":" application/json"
//       },
//       success: function(data) {
//         console.log(data);
//       }
//     });
//   }
// })