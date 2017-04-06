
<script src="js/jquery.min.js"></script>
<script>
$(document).ready(function()
{
			$.ajax({

						type: "POST",
						url: "ajaxtest.php",
						data: "fromajax=true",
						cache: false,
	              	    error: function()
					    {
					        alert('file not exists');
					    },
				success: function(data)
				{
							alert("done");
				}});
});


</script>

				