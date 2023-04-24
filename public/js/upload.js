/**
 * This function is used for making an ajax call on uploading songs.
 */
$(document).ready(function () {
  $(".upload-btn").click(function () {
    // Initializing object of FormData.
    var formData = new FormData();
    imageData = $('input[type="file"]')[0].files[0];
    // Appending in the object of FormData.
    formData.append("title", $("#title").val());
    formData.append("cost", $("#cost").val());
    formData.append("description", $("#description").val());
    formData.append("author", $("#author").val());
    formData.append("imagePath", imageData);
    $.ajax({
      url: "/bookupload",
      type: "POST",
      dataType: "json",
      data: formData,
      processData: false,
      contentType: false,
      success: function (uploadResponse) {
        if (uploadResponse) {
          $(".uploadpop").toggle();
        }
      },
    });
  });
});
