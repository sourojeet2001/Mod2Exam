function search(event) {
  event.preventDefault();

  var search = $("#search").val();

  $.ajax({
    url: "/search",
    type: "GET",
    data: {
      'search' : search
    },
    success: function (response) {
      if (response.data.length > 0) {
        var booksHtml = "";
        // Looping through the response received from the controller.
        for (var i = 0; i < response.data.length; i++) {
          var book = response.data[i];
          booksHtml += `<div class="innerlibrary">
          <div>
            <img src="${ book.imagePath }" alt="" height="300px" width="300px">
            <div class="flex">
              <h1>${ book.title }</h1>
            </div>
            <h3>${book.author}</h3>
            <h4>${book.description}</h4>
            <h4>${book.cost}</h4>
          </div>
        </div>`;
        }
        // Replacing the existing html with the new html.
        $(".songlistlibrary").html(booksHtml);
      }
    },
    error: function(xhr, status, error) {
      console.log(xhr);
      console.log(status);
      console.log(error);
    }
  });
}