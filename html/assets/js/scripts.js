function masnoryGrid() {
  $(".masnory-grid").isotope({
    itemSelector: ".masnory-grid__item",
    percentPosition: true,
    masonry: {
      columnWidth: ".masnory-grid__item",
    },
  });
}

function searchSticky(){
	var scroll = $(window).scrollTop();
	var bannerHeight = $(window).height();

	if(scroll >= bannerHeight){
		$('.search-hero__content').addClass('sticky');
	}else{
		$('.search-hero__content').removeClass('sticky');
	}
}
function justifyGallery(){
    $('.justified-gallery').justifiedGallery({
      rowHeight : 300,
      lastRow : 'nojustify',
      margins : 3,
      captions: false
  });




}
function infiniteScroll(){
    if($(window).scrollTop() + $(window).height() == $(document).height()) {
      for (var i = 0; i < 5; i++) {
        $('.infiniteScroll-gallery').append(
            '<div class="discover-photos__grid-item">' +
              '<img src="assets/images/1.jpg" />' + 
              '<figcaption>' +
              '<div class="figure-tools">' +
                '<div class="figure-icons">' +
                  '<a href="#" data-toggle="modal" data-target="#exampleModal"> <span class="icon-heart-o"></span></a>' + 
                  '<a href="#"> <span class="icon-stack"></span></a>' +
                '</div>' +
              '</div>' +
              '<div class="figure-info ">' +
                '<h6 class="font-weight-light mb-0">Bhatapur</h6>' +
                '<a href="#" class="btn btn-primary btn-sm"  data-toggle="modal" data-target="#exampleModal">Buy</a>' +
              '</div>' +
            '</figcaption>' +
            '<a href="single-product.html" class="stretched-link"></a>' +
            '</div>');
      }
      $('.infiniteScroll-gallery').justifiedGallery('norewind');
    }
}
function init(){
  $('[data-toggle="tooltip"]').tooltip(); 
}
function mobileMenu(){
  $('.btn-nav-toggle').on('click', function(){
    $('.header__nav').addClass('mobile-nav-open');
  })
  $('.btn-toggle-close').on('click', function(){
    $('.header__nav').removeClass('mobile-nav-open');
  })
  
}
function slideMenu(){
  $('.btn-usernav-toggle').on('click', function(){
    $('#user-slidemenu').addClass('is-open');
    $('body').css({
      'overflow': 'hidden',
      'padding-right' : 17,
    })
  });
  $('#usernav-close').on('click', function(){
    $('#user-slidemenu').removeClass('is-open');
    $('body').css({
      'overflow': '',
      'padding-right' : '',
    })
  })
}


$(document).ready(function () {
  justifyGallery();
  mobileMenu();
  slideMenu();
  
});


$(window).scroll(function(){
    searchSticky();
    infiniteScroll();

})
$(window).resize(function(){
  justifyGallery();
  infiniteScroll();

  
})


/* ===================================     header appear on scroll up     ====================================== */
const searchBar = $(".sticky-search-bar");
const headerHeight = searchBar.outerHeight();
let lastScroll = 0;
$(window).on("scroll", function () {
  let st = $(this).scrollTop();

  if (st > lastScroll) {
    searchBar.removeClass("is-sticky");
  } else {
    searchBar.addClass("is-sticky");
  }

  lastScroll = st;

  if (lastScroll <= headerHeight) {
    searchBar.removeClass("is-sticky");
  }
});
