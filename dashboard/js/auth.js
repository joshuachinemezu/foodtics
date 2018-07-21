var cat = localStorage.getItem("user_hash");
if (cat == null) {
  toastr.warning("Unauthorized Access");
  window.location = "https://joshuachinemezu.github.io/foodtics/login.html";
}
$.ajax({
  url: "https://foodtics.000webhostapp.com/getUserinfo",
  // http://foodtics.local/getUserinfo

  type: "POST",

  data: {
    userHash: cat
  },

  dataType: "JSON",

  cache: false,

  beforeSend: function() {
    // $("#btn").hide();
  },

  success: function(jsonStr) {
    // $("#loader").hide();

    // $("#btn").show();

    if (jsonStr.status == "error") {
      if (jsonStr.code == 0) {
        toastr.warning("Sorry fields cannot be null");
      } else {
        toastr.error("Error in operation, Please try again");
      }
    }

    if (jsonStr.status == "success") {
      if (jsonStr.code == 1) {
        // toastr.success("Welcome " + jsonStr.fullname);
        var username = localStorage.getItem("user_name");
        document.getElementById("fullname").innerHTML = username;

        // window.location =
        //     "https://joshuachinemezu.github.io/foodtics/analytics.html"
      } else {
        toastr.warning("Invalid login details, Please try again");
      }
    }

    // $("#result").text(JSON.stringify(jsonStr));
  }
});
