$(document).ready(function(){
            $(window).scroll(function() { 
                if ($(document).scrollTop() > 50) { 
                    $(".navbar-fixed-top").css("background-color", "#2dc997"); 
                } else {
                $(".navbar-fixed-top").css("background-color", "#ffffff");
            }
            });
        });