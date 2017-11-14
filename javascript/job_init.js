$(document).ready(function(){
	$('.open-job').click(function(){
		var id = $(this).attr('alt');
		//alert(id);
		var job = "#job-"+id;
		var link = ".read-more-"+id;
		var image1 = ".open-"+id;
		var image2 = ".close-"+id;
		$(job).slideToggle(500);
		$(link).fadeIn(500);
		$(image1).fadeOut(500);
		$(image2).fadeIn(500);
	});
	
	$('.close-job').click(function(){
		var id = $(this).attr('alt');
		//alert(id);
		var job = "#job-"+id;
		var link = ".read-more-"+id;
		var image1 = ".open-"+id;
		var image2 = ".close-"+id;
		$(job).slideToggle(500);
		$(link).fadeOut(500);
		$(image2).fadeOut(500);
		$(image1).fadeIn(500);
	});
});