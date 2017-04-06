<? include 'connect.php';
session_start();?>

<? include 'home.php'; ?>
 <script>         
 //var i = 0;
                  setInterval(page_refresh, 5000);
				function page_refresh()
				{
					//alert(i);
					if($("#sel_view option:selected").text()=='Map'){
						//if(i==0){
							$.ajax({
								 type: "POST",
								 url: "alexa_zoom.php",
								 data: 'dowhat=zoom',
								 cache: false,
								 success: function(data){
									//alert(data);
									if(data.trim()!=''){
									zoom_eqp_type(data.trim(),20);
									
									 }
								 }
							});
						/*	i++;
						}
						else if(i==1){*/
							$.ajax({
								 type: "POST",
								 url: "alexa_open_ts.php",
								 data: 'dowhat=opents',
								 cache: false,
								 success: function(data){
									//alert(data);
									if(data.trim()!=''){
									 var win = window.open(data, '_blank');
									 win.focus();
									}
							   
								 }
							});
							/*i--;
						}*/
					}//if map end
                }

  </script>