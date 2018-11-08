jQuery(document).ready(function($) {
	'use strict';

	$('.listing-manager-dismiss-purchase').on('click', function() {
		Cookies.set('listing-manager-dismiss-purchase', 'yes', { 'expires': 1 });
		$(this).closest('.listing-manager-settings-error').remove();
	});

  	$('.time-picker-field').timepicker({
        hourGrid : 4,
        minuteGrid : 10,
        timeFormat: 'H:i'
    });
});