$(document).ready(function(){
	$(".like").click(function()
	{
		var id=$(this).attr("videoId");
		var name=$(this).attr("name");
		var dataString = 'id='+ id + '&name='+ name;
		$("#votebox").slideDown("slow");
//		$("#flash").fadeIn("slow");

		$.ajax
		({
			type: "POST",
			url: ratingUrl,
			data: dataString,
			cache: false,
			success: function(html)
			{
//				$("#flash").fadeOut("slow");
				$("#ratingBars").html(html);
			}
		});
	});

	// Close button action
	$(".close").click(function()
	{
		$("#votebox").slideUp("slow");
	});
});