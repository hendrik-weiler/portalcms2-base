if(pcms2 === undefined) var pcms2 = {};
if(pcms2.interactive === undefined) pcms2.interactive = {};

(function(window, interactive) {

	interactive.contextmenu = function(element, contextmenuelement) {

		$(document).bind("contextmenu",function(e){
			return false;
		}).click(function(e) {
			e.stopPropagation();
			$(contextmenuelement).hide();
		});

		$(element).mousedown(function(event) {
		    if (event.which == 3) {

				$(contextmenuelement).css({
					position : 'absolute',
					top : event.pageY,
					left : event.pageX
				}).show();
		    }
		});

		$(contextmenuelement).find('li').hover(function() {

			if($(this).find('ul').length != 0)
			{
				$(this).find('ul').show();


			}

		}, function() {

			if($(this).find('ul').length != 0)
			{
				$(this).find('ul').hide();


			}


		});





	}

})(this, pcms2.interactive)