$(document).ready(function()
{
	$("input").blur(function(){
	 	$('#suggestions').fadeOut();
	 });
	
	$('#loading-not').hide();
	
	$("#loading").bind("ajaxSend", function(){
		$(this).show();
		$('#loading-not').hide();
	 }).bind("ajaxComplete", function(){
	    $(this).hide();
		$('#loading-not').show();	
	 });
}) 

function lookup(inputString,id, order) {
	if(inputString.length < 3) {
		$('#suggestions').fadeOut(); 
		$('#loading-not').hide();
	} else {
		$.post("index.php?task=ajax&option=com_search&tmpl=component&type=raw&id="+id+"&ordering="+order , {queryString: ""+inputString+""}, function(data) { 																									
			$('#suggestions').fadeIn(); // Show the suggestions box
			$('#suggestions').html(data); // Fill the suggestions box
		});
	}
}

function hide() {
	$('#loading-not').hide();
}

