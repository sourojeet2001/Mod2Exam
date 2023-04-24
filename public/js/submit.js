function submit(event) {
  event.preventDefault();

  let item;

  let radio1 = document.getElementById('cost');
  if (radio1.checked) {
    item = radio1.value;
  }
  let radio2 = document.getElementById('author');
  if (radio2.checked) {
    item = radio2.value;
  }
  if (!radio1.checked && !radio2.checked) {
    return;
  }

  $.ajax({
    url: "/sort",
    type: "GET",
    dataType: "json",
    data: {
      'item' : item
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
    }
  });
}
