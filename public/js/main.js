/* fonction pour ajout input enfant */
function myFunction() {
    document.getElementById("cible").style.display="block";
  }
            
            
$(document).ready(function () {
    $(window).scroll(function(){
        var ScrollTop = parseInt($(window).scrollTop());

        if (ScrollTop > 1) {
            $("header").css("backgroundColor","rgba(219, 243, 245, .9)");
        }
        else {
            $("header").css("backgroundColor","rgba(219, 243, 245, 1)");
        }
    });

    /* Defile to -> ancre */
    $('.nav-link').on('click', function(evt){
        evt.preventDefault();
         var target = $(this).attr('href');
     $('html, body').stop().animate({scrollTop: $(target).offset().top}, 1000 );
    });
});

/* Au chargement de la page */
if ($(window).width() < 500) {
    /* Fonction pour le menu */
    function openNav() {
        $("#sideNavigation").css("width","100%");
    }
    /* Footer */
    $("footer").addClass( "text-center" );
    $("footer .fab").removeClass("mr-4");
    $("footer .fab").addClass("mx-auto");
    $("footer #eura").addClass("pt-3");
    /* Timeline */
    $(".right").removeClass("timeline-inverted");
    $(".arrow-right").removeClass("fa-arrow-right");
    $(".arrow-right").addClass("fa-arrow-left");
    /* Galerie */
    $(".galery-phone").show();
    $(".galery-desk").hide();
    /* Texte Top */
    $("#text-phone").show();
    $("#text-desk").hide();
}
else if ($(window).width() < 720) {
    /* Fonction pour le menu */
    function openNav() {
        $("#sideNavigation").css("width","250px");
    }
    /* Footer */
    $("footer").addClass( "text-center" );
    $("footer .fab").removeClass("mr-4");
    $("footer .fab").addClass("mx-auto");
    $("footer #eura").addClass("pt-3");
    /* Timeline */
    $(".right").removeClass("timeline-inverted");
    $(".arrow-right").removeClass("fa-arrow-right");
    $(".arrow-right").addClass("fa-arrow-left");
    /* Galerie */
    $(".galery-phone").show();
    $(".galery-desk").hide();
    /* Texte Top*/
    $("#text-phone").show();
    $("#text-desk").hide();
}
else {
    /* Fonction pour le menu */
    function openNav() {
        $("#sideNavigation").css("width","250px");
    }
    /* Footer */
    $("footer").removeClass( "text-center" );
    $("footer .fab").addClass("mr-4");
    $("footer .fab").removeClass("mx-auto");
    $("footer #eura").removeClass("pt-3");
    /* Timeline */
    $(".right").addClass("timeline-inverted");
    $(".arrow-right").removeClass("fa-arrow-left");
    $(".arrow-right").addClass("fa-arrow-right");
    /* Galerie */
    $(".galery-phone").hide();
    $(".galery-desk").show();
    /* Texte Top */
    $("#text-phone").hide();
    $("#text-desk").show();
}

/* Au redimensionnement de la page */
$(window).resize(function() {
    if ($(window).width() < 500) {
        /* Fonction pour le menu */
        function openNav() {
            $("#sideNavigation").css("width","100%");
        }
        /* Footer */
        $("footer").addClass( "text-center" );
        $("footer .fab").removeClass("mr-4");
        $("footer .fab").addClass("mx-auto");
        $("footer #eura").addClass("pt-3");
        /* Timeline */
        $(".right").removeClass("timeline-inverted");
        $(".arrow-right").removeClass("fa-arrow-right");
        $(".arrow-right").addClass("fa-arrow-left");
        /* Galerie */
        $(".galery-phone").show();
        $(".galery-desk").hide();
        $("#text-phone").show();
        $("#text-desk").hide();
    }
    else if ($(window).width() < 720) {
        /* Fonction pour le menu */
        function openNav() {
            $("#sideNavigation").css("width","250px");
        }
        /* Footer */
        $("footer").addClass( "text-center" );
        $("footer .fab").removeClass("mr-4");
        $("footer .fab").addClass("mx-auto");
        $("footer #eura").addClass("pt-3");
        /* Timeline */
        $(".right").removeClass("timeline-inverted");
        $(".arrow-right").removeClass("fa-arrow-right");
        $(".arrow-right").addClass("fa-arrow-left");
        /* Galerie */
        $(".galery-phone").show();
        $(".galery-desk").hide();
        $("#text-phone").show();
        $("#text-desk").hide();
    }
   else {
       /* Fonction pour le menu */
        function openNav() {
            $("#sideNavigation").css("width","250px");
        }
       /* Footer */
        $("footer").removeClass( "text-center" );
        $("footer .fab").addClass("mr-4");
        $("footer .fab").removeClass("mx-auto");
        $("footer #eura").removeClass("pt-3");
        /* Timeline */
        $(".right").addClass("timeline-inverted");
        $(".arrow-right").removeClass("fa-arrow-left");
        $(".arrow-right").addClass("fa-arrow-right");
        /* Galerie */
        $(".galery-phone").hide();
        $(".galery-desk").show();
        /* Texte Top */
        $("#text-phone").hide();
        $("#text-desk").show();
    }
});

/* Fonction menu */
function openNav() {
    document.getElementById("main").style.marginLeft = "250px";
}

function closeNav() {
    document.getElementById("sideNavigation").style.width = "0";
    document.getElementById("main").style.marginLeft = "0";
}

/* Formulaire Message */
$("#sendM").on("click", function(e){
     e.preventDefault();
     $("#ok").on("click", function(){
        $("#messageSend").submit();
     });
});

/* Formulaire connexion */
$("#mdp").focus(function(){
	$("#roulette").css({
		"-webkit-animation-name": "rotationMdp", 
    	"-webkit-animation-duration": "2s",
    	"transform": "rotate(180deg)"
	});
});

$("#mdp").blur(function(){
	$("#roulette").css({
		"-webkit-animation-name": "rotationMdpBlur", 
    	"-webkit-animation-duration": "2s",
    	"transform": "rotate(360deg)"
	});
});

$("input[type=checkbox]").on( "click", function(){
  if (this.checked == true){
    $("#mdp").attr("type","text");
  } else {
     $("#mdp").attr("type","password");
  }
});

