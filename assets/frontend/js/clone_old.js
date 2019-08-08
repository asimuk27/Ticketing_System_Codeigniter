//alert("test");

$('.addFight_free').click(function(e){
	
	if($('.repeatingSection_free').css('display') == 'none'){ 
		$('.repeatingSection_free').show('slow'); 
	} else { 
		var number = $('.repeatingSection_free:last').attr("id");
		var res = number.split("_");
		var num = res[res.length-1];

		newNum  = new Number(parseInt(num) + 1),   
		newElem = $('#entryfree_' + num).clone().attr('id', 'entryfree_' + newNum).fadeIn('slow'); 	
		
		$('#entryfree_' + num).after(newElem).find("input[type='text']").val("");
		$('#ID' + newNum + '_title').focus();	
	
	}
	$("#free_ticket_count").val(parseInt($("#free_ticket_count").val())+1);
});
 
// $('.deleteFight_free').click(function(e){
$("div").delegate(".deleteFight_free", "click", function(e){
        
		e.preventDefault();
	   		
	   var current_fight = $(this).parents('div').eq(1); 
        var other_fights = current_fight.siblings('.repeatingSection_free');

		if (other_fights.length === 0) {
           $('.repeatingSection_free').hide('slow').find("input[type='text']").val("");  
            $("#free_ticket_count").val(0);				
			return;
        } 
        current_fight.slideUp('slow', function() {
            current_fight.remove();
            
            // reset fight indexes
            other_fights.each(function() {
               resetAttributeNames($(this)); 
            })              
        })
		
	
	
    });	

	
$('.addFight_donation').click(function(e){
	
	if($('.repeatingSection_donation').css('display') == 'none'){ 
		$('.repeatingSection_donation').show('slow'); 
	} else { 
		//var num     = $('.repeatingSection_free').length, // Checks to see how many "duplicatable" input fields we currently have
		var number = $('.repeatingSection_donation:last').attr("id");
		var res = number.split("_");
		var num = res[res.length-1];

		newNum  = new Number(parseInt(num) + 1),      // The numeric ID of the new input field being added, increasing by 1 each time
		newElem = $('#entrydonation_' + num).clone().attr('id', 'entrydonation_' + newNum).fadeIn('slow'); // create the new element via clone(), and manipulate it's ID using newNum value
		
	//	newElem.find('.free_name').attr('id', 'ID' + newNum + '_free_name').attr('name', 'ID' + newNum + '_free_name').val('');
		
		$('#entrydonation_' + num).after(newElem).find("input[type='text']").val("");
		$('#ID' + newNum + '_title').focus();
	}

	$("#donation_ticket_count").val(parseInt($("#donation_ticket_count").val())+1);
});
 
// $('.deleteFight_free').click(function(e){
$("div").delegate(".deleteFight_donation", "click", function(e){
        
		e.preventDefault();
	
	   var current_fight = $(this).parents('div').eq(1); 
        var other_fights = current_fight.siblings('.repeatingSection_donation');

		if (other_fights.length === 0) {
           $('.repeatingSection_donation').hide('slow').find("input[type='text']").val("");            
			$("#donation_ticket_count").val(0);	
			return;
        } 
        current_fight.slideUp('slow', function() {
            current_fight.remove();
            
            // reset fight indexes
            other_fights.each(function() {
               resetAttributeNames($(this)); 
            })              
        }) 
			 
    });	

	
$('.addFight_paid').click(function(e){
	
	if($('.repeatingSection_paid').css('display') == 'none'){ 
		$('.repeatingSection_paid').show('slow'); 
	} else { 
		//var num     = $('.repeatingSection_free').length, // Checks to see how many "duplicatable" input fields we currently have
		var number = $('.repeatingSection_paid:last').attr("id");
		var res = number.split("_");
		var num = res[res.length-1];

		newNum  = new Number(parseInt(num) + 1),      // The numeric ID of the new input field being added, increasing by 1 each time
		
		newElem = $('#entrypaid_' + num).clone().attr('id', 'entrypaid_' + newNum).fadeIn('slow'); // create the new 
		$('#entrypaid_' + num).after(newElem).find("input[type='text']").val("");
		$('#ID' + newNum + '_title').focus();		
	}	
	$("#paid_ticket_count").val(parseInt($("#paid_ticket_count").val())+1);
});
 
// $('.deleteFight_free').click(function(e){
$("div").delegate(".deleteFight_paid", "click", function(e){
        
		e.preventDefault();

	   var current_fight = $(this).parents('div').eq(1); 
        var other_fights = current_fight.siblings('.repeatingSection_paid');

		if (other_fights.length === 0) {
           $('.repeatingSection_paid').hide('slow').find("input[type='text']").val(""); 
		   $("#paid_ticket_count").val(0);	
		   return;
        } 
        current_fight.slideUp('slow', function() {
            current_fight.remove();
            
            // reset fight indexes
            other_fights.each(function() {
               resetAttributeNames($(this)); 
            })              
        })  
		
	
    });	
