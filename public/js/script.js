
var root_folder = '/we_project2';

$(document).ready(function(){
	$('.searchfield').keyup(function(){
		$('#searchpanel').show();
		$('#loader').show();
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
			$('#loader').hide();
		});

	});

	$('#addLabel input').keyup(function(){
		$.get( root_folder + '/search/ajax/true/renderonly/labels/text/' + $(this).val(), function( data ) {
			$('#searchlabels').html(data);
			$('#searchlabels a').unbind('click').click(function(e){
				e.preventDefault();
				var link = $(this);
				$('.labels').prepend($('<div class="label"><a href="#">' + link.text() + '</a> <a href="delete">-</a><input type="hidden" value="' + link.attr('label-id') +'" name="labels[]"></div>'));
				rebindLabelsDelete();
			});

			$('#searchlabels').append('<div class="clearfix"></div>');
		});
	});

	rebindLabelsDelete();

	var addressForm = $('#address_form_container');

	$('a[href=change_address]').click(function(e){
		e.preventDefault();
		$('#address_show').hide();
		addressForm.show();
	});


});

function rebindLabelsDelete(){
	$('.labels a[href=delete]').unbind('click').click(function(e){
		e.preventDefault();
		$(this).parent().remove();
	});
}

function imgError(image) {
	image.onerror = "";
	image.src = root_folder + "/public/img/no_image.jpg";
	$(image).parent().css('background-color', '#CCC');
	$(image).css('opacity', 0.5);
	return true;
}