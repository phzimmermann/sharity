
var root_folder = '/we_project';

$(document).ready(function(){
	$('.searchfield').keyup(function(){
		$('#searchpanel').html('Wird geladen...');
		$.get( root_folder + '/search/ajax/true/text/' + $(this).val(), function( data ) {
		  
		  
		  
	/*	  
		  $(data.products).each(function(){
			products += this.name;
		  });
		  
		  $(data.labels).each(function(){
			labels += this.name;
		  });
*/		  
		  $('#searchpanel').html(data);
		});
		
	});
});