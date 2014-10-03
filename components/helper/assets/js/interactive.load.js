if(pcms2 === undefined) var pcms2 = {};
if(pcms2.interactive === undefined) pcms2.interactive = {};

(function(window, interactive) {

	interactive.load = function() {

		var user_height = $('.user').height();
		var component_box_height = $('.component-box').height();

		var window_height = $(window).height();

		if(window_height > $('.content').height())
		{

			$('.content').height( window_height - user_height - component_box_height  );


		}





	}

})(this, pcms2.interactive)