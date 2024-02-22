// login tab switch
document.addEventListener('DOMContentLoaded', function () {
    var tabLinks = document.querySelectorAll('.nav-link');
    tabLinks.forEach(function (tabLink) {
      tabLink.addEventListener('click', function (event) {
        event.preventDefault();
        var tab = new bootstrap.Tab(tabLink);
        tab.show();
      });
    });
  });
  //calendar input
  document.addEventListener('DOMContentLoaded', function () {
    flatpickr(".birthdate-input", {
      dateFormat: "Y-m-d",
      // You can add more options if needed
    });
  });
  // Initialize Dropzone
  Dropzone.autoDiscover = false; // Disable auto-discover to manually initialize
  var myDropzone = new Dropzone("#dropzone-basic", { /* your options here */ });
  //fix radio form class in register
  
