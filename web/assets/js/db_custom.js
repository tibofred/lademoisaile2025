jQuery(document).ready(function() {
	
	'use strict';

	$('.owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        items:1,
        dots:false
    });

	/************************************ OnScroll Animations **************************************************/
	
	function onScrollInit( items, trigger ) {
	
	  items.each( function() {
		var osElement = $(this),
			osAnimationClass = osElement.attr('data-animation'),
			osAnimationDelay = osElement.attr('data-animation-delay');
		  
			osElement.css({
			  '-webkit-animation-delay':  osAnimationDelay,
			  '-moz-animation-delay':     osAnimationDelay,
			  'animation-delay':          osAnimationDelay
			});
	
			var osTrigger = ( trigger ) ? trigger : osElement;        
	
			osTrigger.waypoint(function() {
			  osElement.addClass('animated').addClass(osAnimationClass);
			  },{
				  triggerOnce: true,
				  offset: '70%'
			});
	  });
	}
	
	/* Trigger OnScroll */
	/* Hompage */
	onScrollInit( $('.grid_band [class^="col-md"] , .entreprise [class^="col-md"] , .col_middle'));	


// external js: isotope.pkgd.js

    // init Isotope


    var iso = new Isotope( '.grid', {
        itemSelector: '.grid-item',
        layoutMode: 'fitRows'
    });


    // filter functions
    var filterFns = {
        // show if number is greater than 50
        numberGreaterThan50: function( itemElem ) {
            var number = itemElem.querySelector('.number').textContent;
            return parseInt( number, 10 ) > 50;
        },
        // show if name ends with -ium
        ium: function( itemElem ) {
            var name = itemElem.querySelector('.name').textContent;
            return name.match( /ium$/ );
        }
    };

    // bind filter button click
    var filtersElem = document.querySelector('.filters-button-group');
    filtersElem.addEventListener( 'click', function( event ) {
        // only work with buttons
        if ( !matchesSelector( event.target, 'button' ) ) {
            return;
        }
        var filterValue = event.target.getAttribute('data-filter');
        // use matching filter function
        filterValue = filterFns[ filterValue ] || filterValue;
        iso.arrange({ filter: filterValue });
    });

    // change is-checked class on buttons
    var buttonGroups = document.querySelectorAll('.button-group');
    for ( var i=0, len = buttonGroups.length; i < len; i++ ) {
        var buttonGroup = buttonGroups[i];
        radioButtonGroup( buttonGroup );
    }

    function radioButtonGroup( buttonGroup ) {
        buttonGroup.addEventListener( 'click', function( event ) {
            // only work with buttons
            if ( !matchesSelector( event.target, 'button' ) ) {
                return;
            }
            buttonGroup.querySelector('.is-checked').classList.remove('is-checked');
            event.target.classList.add('is-checked');
        });
    }


    jQuery('.firstbutton').trigger('click');



        setTimeout(function(){

            $('.filters-button-group').on( 'click', 'button', function() {
                var filterValue = $(this).attr('data-filter');
                $('.grid').isotope({ filter: filterValue });
            });

            var $container = jQuery('.grid');

            $container.imagesLoaded( function() {
                $container.isotope({
                    itemSelector: '.grid-item',
                    percentPosition: true,
                    masonry: {
                        // use outer width of grid-sizer for columnWidth
                        columnWidth: '.grid-sizer'
                    }
                });
            });

        }, 3000);

        $(".grid-item > a").colorbox({rel:'grid-item > a', transition:"fade",maxWidth: "95%",maxHeight: "95%"});
    
});