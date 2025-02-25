// Sticky Header 
$(document).ready(function() {
  var lastScrollTop = 0;
  var headerHeight = $('.header').outerHeight();

  $(window).scroll(function() {
      var st = $(this).scrollTop();

      // Scroll down and past the header's height
      if (st > lastScrollTop && st > headerHeight) {
          $('.header').addClass('sticky').css('top', -42);
      } else {
          // Scroll up or at the top
          if (st + $(window).height() < $(document).height()) {
              $('.header').removeClass('sticky').css('top', -100); // Slide up to hide
          }
      }
      lastScrollTop = st;
  });
});

// Hero Slider 
$('.hero-slider').owlCarousel({
  loop:true,
  dots:true,
  autoplay: true,
  autoplaySpeed: 4000,
  responsive:{
      0:{
          items:1
      },
      600:{
          items:1
      },
      1000:{
          items:1
      }
  }
})

// Number Count 
$(document).ready(function() {
  $('.count-number').each(function() {
    $(this).prop('Counter', 0).animate({
      Counter: $(this).data('count')
    }, {
      duration: 3000,
      easing: 'swing',
      step: function(now) {
        $(this).text(Math.ceil(now));
      }
    });
  });
});

// Client Slider 
$('.members-logo').owlCarousel({
  loop:true,
  responsiveClass:true,
  nav: false,
  dots: false,
  autoplay: true,
  autoplayTimeout: 3000,
  animateIn: true,
  animateOut: true,
  responsive:{
      0:{
          items:2,
      },
      600:{
          items:3,
      },
      1000:{
          items:5,
          loop:true
      }
  }
});

// Video Slider 
$('.video-slider').slick({
    centerMode: true,
    centerPadding: '60px',
    slidesToShow: 3,
    autoplay: true,
    autoplaySpeed: 4000,
    responsive: [
      {
        breakpoint: 768,
        settings: {
          arrows: false,
          centerMode: true,
          centerPadding: '60px',
          slidesToShow: 3
        }
      },
      {
        breakpoint: 480,
        settings: {
          arrows: false,
          autoplay: true,
          centerMode: true,
          centerPadding: '40px',
          slidesToShow: 1
        }
      }
    ]
  });

// Function to update the class of the last pagination item based on the state of the second-to-last item
function updateLastItem() {
  var lastIndex = $('.pagination li').length - 1;
  if ($('.pagination li').eq(lastIndex - 1).find('a').hasClass('active')) {
    $('.pagination li').eq(lastIndex).find('a').addClass('text-gray');
  } else {
    $('.pagination li').eq(lastIndex).find('a').removeClass('text-gray');
  }

  // New check to add 'text-gray' class to the first item when the second item is active
  if ($('.pagination li').eq(1).find('a').hasClass('active')) {
    $('.pagination li').eq(0).find('a').addClass('text-gray');
  } else {
    $('.pagination li').eq(0).find('a').removeClass('text-gray');
  }
}

// Event handler for pagination link clicks
$('.pagination a').click(function(event) {
  event.preventDefault(); // Prevent the default anchor behavior

  var $this = $(this);
  var lastIndex = $('.pagination li').length - 1;

  // Check if the clicked item is the first item
  if ($this.parent().index() === 0) {
    // If the second item is active, do nothing
    if ($('.pagination li').eq(1).find('a').hasClass('active')) {
      $('.pagination li').eq(0).find('a').addClass('text-gray');
      return;
    } else {
      $('.pagination li').eq(0).find('a').removeClass('text-gray');
    }
  }

  // Check if the clicked item is the last item and if the second-to-last item is active
  if ($this.parent().index() === lastIndex && $('.pagination li').eq(lastIndex - 1).find('a').hasClass('active')) {
    return; // Prevent the last item from becoming active
  }

  // Remove the 'active' class from the currently active link
  $('.pagination a.active').removeClass('active');
  // Add the 'active' class to the clicked link
  $this.addClass('active');

  updateLastItem();
});
updateLastItem();

// Scroll To Top 
$(document).ready(function() {
    // Show or hide the scroll-to-top button based on scroll position
    $(window).scroll(function() {
        if ($(this).scrollTop() > 400) {
            $('.scroll-to-top').fadeIn();
        } else {
            $('.scroll-to-top').fadeOut();
        }
    });
    // Scroll to the top when the button is clicked
    $('#scroll-top').click(function() {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        return false;
    });
});
//Gallery
$(document).ready(function() {
  $("#gallery").unitegallery({
      gallery_theme: "tiles",
      tile_enable_textpanel: true,
      tile_textpanel_always_on: true,
      tile_textpanel_position: "bottom"
  });
});
//Preview Image in Profile edit file
$(document).ready(function(){
  $("#upload-icon").click(function(){
    $("#profile-input").click();
  });
  $("#profile-input").change(function(){
    const file = this.files[0];
    if(file){
      let reader = new FileReader();
      reader.onload = function(e){
        $("#preview-img").attr("src", e.target.result);
      }
      reader.readAsDataURL(file);
    }
  });
});



// Advance Filter toggle start here
$(document).ready(function(){
  $('[data-bs-toggle="tooltip"]').tooltip();

  $('.filter-toggle1').click(function(){
    $('.filter-box').slideToggle();
  });
  

  $('.filter-toggle2').click(function() {
    // Toggle visibility of the filter-box
    $('.filter-box').slideToggle(function() {
        // Check if .filter-box is visible after the slideToggle animation
        if ($('.filter-box').is(':visible')) {
            // If .filter-box is visible, show the 'fa-xmark' icon and hide 'fa-angle-down'
            $('.filter-toggle2 .fa-angle-down').hide();
            $('.filter-toggle2 .fa-xmark').show();
        } else {
            // If .filter-box is hidden, show the 'fa-angle-down' icon and hide 'fa-xmark'
            $('.filter-toggle2 .fa-angle-down').show();
            $('.filter-toggle2 .fa-xmark').hide();
        }
    });
    
    // Ensure initial icon state matches the visibility of .filter-box
    if ($('.filter-box').is(':visible')) {
        $('.filter-toggle2 .fa-angle-down').hide();
        $('.filter-toggle2 .fa-xmark').show();
    } else {
        $('.filter-toggle2 .fa-angle-down').show();
        $('.filter-toggle2 .fa-xmark').hide();
    }
});
  
});

// Advance Filter toggle start end