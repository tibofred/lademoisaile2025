
jQuery( document ).ready(function($) {
	$(".link_ecole").click(function(){
		$(this).parent().find('table').slideToggle();
	});
	$(".link_ecole2").click(function(){
		$(this).parent().find('.card-body').slideToggle();
	});
});