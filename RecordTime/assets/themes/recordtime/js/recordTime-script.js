equalheight = function(container){

var currentTallest = 0,
     currentRowStart = 0,
     rowDivs = new Array(),
     $el,
     topPosition = 0;
 $(container).each(function() {

   $el = $(this);
   $($el).height('auto')
   topPostion = $el.position().top;

   if (currentRowStart != topPostion) {
     for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
       rowDivs[currentDiv].height(currentTallest);
     }
     rowDivs.length = 0; // empty the array
     currentRowStart = topPostion;
     currentTallest = $el.height();
     rowDivs.push($el);
   } else {
     rowDivs.push($el);
     currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
  }
   for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
     rowDivs[currentDiv].height(currentTallest);
   }
 });
}

$(window).on('load', function(){
  equalheight('.artist-record-section p');
  console.log("hi");
});


$(window).resize(function(){
  equalheight('.artist-record-section p');
});
$(document).ready(function(){
	/* Mobile Menu */
	
	$(".navbar-nav .menu-items-has-childrens > a").after(' <div class="child-trigger"><i class="fas fa-chevron-right"></i></div>');
	$(".child-trigger").click(function(){
		if($(this).hasClass("child-open")){
			$(this).removeClass("child-open");
			$(this).next().slideUp();
		}else {
			$(".child-trigger").removeClass("child-open");
			$(".menu-items-has-childrens ul").slideUp();
			$(this).toggleClass("child-open");
			$(this).next().slideToggle();
		}
		
	})
	$(".chat-section").click(function(){
		$(".chat-section").removeClass("active");
		$(this).addClass("active");
	})
	$(".account-block").click(function(){
		$(this).find(".round-white-border").toggleClass("active");
		if($(".round-white-border").hasClass("active")){
			$(".recording-btn-container").show();
		}
		else {
			$(".recording-btn-container").hide();
		}
	})
	$(".menu-icon").click(function(){
		$(".hamburger-container").slideToggle();
	})
	
	/* rating Script */
	$(".creatinv-rating").click(function(){
		$(".creatinv-rating").removeClass("active");
		$(this).addClass("active");
	})
	$(".candor-rating").click(function(){
		$(".candor-rating").removeClass("active");
		$(this).addClass("active");
	})
	$(".workload-rating").click(function(){
		$(".workload-rating").removeClass("active");
		$(this).addClass("active");
	})
	$(".flexibility-rating").click(function(){
		$(".flexibility-rating").removeClass("active");
		$(this).addClass("active");
	})
	
	/* Slick Slider JS */
	$('.responsive').slick({
		dots: true,
		infinite: false,
		speed: 300,
		slidesToShow: 3,
		slidesToScroll: 1,
		responsive: [
		{
		  breakpoint: 1024,
		  settings: {
			slidesToShow: 2,
			slidesToScroll: 1,
			infinite: true,
			dots: true
		  }
		},
		{
		  breakpoint: 600,
		  settings: {
			slidesToShow: 1,
			slidesToScroll: 1
		  }
		}
		// You can unslick at a given breakpoint now by adding:
		// settings: "unslick"
		// instead of a settings object
		]
	});
})
