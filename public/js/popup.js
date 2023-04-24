/**
 * This function is used to show and hide a popup.
 */
$(document).ready(function () {

  $("#uploadsong").click(function () {
    $(".uploadpop").toggle();
  });
  $(".uploadclose").click(function () {
    $(".uploadpop").toggle();
  });
});
