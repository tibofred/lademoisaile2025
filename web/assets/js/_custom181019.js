jQuery( document ).ready(function($) {
  if (document.cookie.indexOf('visited=true') == -1 && $('#modalInfoletter').length){
    // load the overlay
    $('#modalInfoletter').modal({show:true});
    
    var year = 1000*60*60*24*365;
    var expires = new Date((new Date()).valueOf() + year);
    document.cookie = "visited=true;expires=" + expires.toUTCString();





  }

	if ($('.list_posts').length){
	  	size_li = $(".list_posts .lp_element").length;
	    x=15;
	    $('.list_posts .lp_element:lt('+x+')').show();
	    $('#loadMore').click(function () {
	        x= (x+15 <= size_li) ? x+15 : size_li;
	        $('.list_posts .lp_element:lt('+x+')').show();
	        if(x >= size_li) {
	        	$(this).hide();
	        }
	    });
	}



	function init() {
		var vidDefer = document.getElementsByTagName('iframe');
		for (var i=0; i<vidDefer.length; i++) {
			if(vidDefer[i].getAttribute('data-src')) {
				vidDefer[i].setAttribute('src',vidDefer[i].getAttribute('data-src'));
			} 
		} 
	}
	window.onload = init;
});