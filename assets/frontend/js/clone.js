//alert("test");

// $('.deleteFight_free').click(function(e){
$("div").delegate(".delete_ticket", "click", function(e){
	e.preventDefault();
    var current_fight = $(this).parents('div').eq(1); 
    var other_fights = current_fight.siblings('.repeatingSection_donation');
    current_fight.slideUp('fast', function() {
		current_fight.remove();
        // reset fight indexes
        other_fights.each(function() {
            resetAttributeNames($(this)); 
        })              
    }) 

	var sub_event_size = document.querySelectorAll('.repeatingSection').length;
	document.getElementById('ticket_count_1').value = parseInt(sub_event_size-1);
	 $('.number_of_tickets_err').text('');
});	
