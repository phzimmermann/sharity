
var root_folder = '/we_project2';

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

	$('#addLabel input').keyup(function(){
		$.get( root_folder + '/search/ajax/true/renderonly/labels/text/' + $(this).val(), function( data ) {
			$('#searchlabels').html(data);
			$('#searchlabels a').unbind('click').click(function(e){
				e.preventDefault();
				var link = $(this);
				$('.labels').prepend($('<div class="label"><a href="#">' + link.text() + '</a><input type="hidden" value="' + link.attr('label-id') +'" name="labels[]"></div>'));

			});
			$('#searchlabels').append('<div class="clearfix"></div>');
		});
	});
});