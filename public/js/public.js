jQuery(document).ready(function ($) {
  $("#business-form").on("submit", function (event) {
    event.preventDefault(); // Prevent the default form submission
    // Get form data
    const data = {
      name: $("#business-name").val(),
      address: $("#business-address").val(),
      website: $("#business-url").val(),
    };

    // Send POST request using jQuery AJAX
    $.ajax({
      url: srfApiSettings.root + "business/v1/cards/",
      type: "POST",
      contentType: "application/json",
      beforeSend: function (xhr) {
        xhr.setRequestHeader("X-WP-Nonce", srfApiSettings.nonce);
      },
      dataType: "json",
      data: JSON.stringify(data),
      success: function (response) {
        console.log("Success:", response);
        // Handle success - you can update the UI or alert the user
      },
      error: function (xhr, status, error) {
        console.error("Error:", error);
        // Handle error - you can update the UI or alert the user
      },
    });
  });

  $("#srf-search").on("click", function (event) {
    event.preventDefault(); // Prevent the default form submission
    // Get form data
    const search = $("#srf_search_key").val();
    const url = srfApiSettings.root + "business/v1/cards/?search=" + search;
    $.getJSON(url, function (data) {
      $(".widefat").html(
        "<thead><tr><th>Id </th><th>Name </th><th>Address </th><th>Website </th><th>Register Date </th></tr></thead><tbody>"
      );
      data.forEach((item) => {
        let row =
          "<tr><td>" +
          item.id +
          "</td><td>" +
          item.business_name +
          "</td><td>" +
          item.business_address +
          "</td><td>" +
          item.website_url +
          "</td><td>" +
          item.time +
          "</td><tr>";
        $(".widefat").append(row);
      });
      $(".widefat").append("</tbody>");
    });
  });
});
