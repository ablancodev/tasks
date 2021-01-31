jQuery(document).ready( function($) {

	// Time entries table
	jQuery("#tasks_time_entries_button_add_item").click(
		function(event) {
			event.preventDefault();
			
			var row = '<tr>' +
				'<td><input type="text" name="time_entries_desc[]" placeholder="Descripción" /></td>' +
				'<td class="right"><input type="date" name="time_entries_date[]" placeholder="Fecha" /></td>' +
				'<td class="right"><input type="number" name="time_entries_time[]" placeholder="Tiempo" /></td>' +
			'</tr>';
	      
			var newRow = jQuery(row);
			jQuery('.tasks_time_entries_table tbody')
					.append(newRow);

		});
});