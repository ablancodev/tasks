jQuery(document).ready(function(){
	jQuery("#taskSearchInput").on("keyup", function() {
	    var value = jQuery(this).val().toLowerCase();
	    jQuery("#tasksTable tr").filter(function() {
	    	jQuery(this).toggle(jQuery(this).text().toLowerCase().indexOf(value) > -1)
	    });
	});
});
