<html>
	<head>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
	  	<link href="css/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
		<meta charset="utf-8"/>
	 	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<script src="js/jquery.js" type="text/javascript" language="javascript"></script>

	  	<!--<script src="//vk.com/js/api/openapi.js" type="text/javascript"></script>-->
		<script src="js/jquery-ui.js"></script>
		<script>

			$(document).ready(function(){

				$('.selection_box').click(function(e){
					if($(e.target).hasClass("list_item")){

						$(this).find('li.selected').removeClass("selected");
						$(e.target).addClass("selected");
                    }
				});
				function CreateListBox(){
                    $('.selection_box')
                        .append('<div></div>')
                        .children('div')
                        .addClass('footer')
                        .append("<div id='nav_prev'>Previous</div>")
                        .children('div').last()
                        .addClass('nav left unselectable')
                        .parent()
                        .append('<div>•••</div>')
                        .children('div').last()//надо взять последний
                        .addClass('middle unselectable')
                        .parent()
                        .append("<div id='nav_next'>Next</div>")
                        .children('div').last()
                        .addClass('nav right unselectable');
				}

                CreateListBox();
				$('#nav_prev').click(function(){
					var first_elem = $('.selection_box ul li').first();
					//console.log("first element", first_elem);
					var was_selected = $('.selection_box').find('li.selected');
					//console.log("was selected", was_selected);
					if(was_selected[0]==first_elem[0]){
							//last item
							$('.selection_box .footer .middle')
								.toggleClass('middle noti')
								.html("Reached first item");
							console.log("reached last item");
							
					}else{
						
						$('.selection_box .footer .noti')
							.toggleClass('noti middle')
							.html("•••");
						
						//deselect
						was_selected
							.removeClass("selected");

						//select next
						was_selected
							.prev()
							.addClass("selected");
							//.append("<span></span>");
					}
				});
				$('#nav_next').click(function(){
					var last_elem = $('.selection_box ul li').last();
					//console.log("last element", last_elem);
					var was_selected = $('.selection_box').find('li.selected');
					//console.log("was selected", was_selected);
					if(was_selected[0]==last_elem[0]){
							console.log("reached last item");
							$('.selection_box .footer .middle')
								.toggleClass('middle noti')
								.html("Reached last item");
					}else{
					
						$('.selection_box .footer .noti')
							.toggleClass('noti middle')
							.html("•••");
					
						//deselect
						was_selected
							.removeClass("selected");
						//select next
						was_selected
							.next()
							.addClass("selected");
							//.append("<span></span>");
					}
				});
			});
		</script>
		<title>проверка работы с JSON и XML</title>
		<meta charset="utf-8" />

	</head> 
	<body class="materialTheme">
		<h1>Trying Page</h1>

		<div class="tabs"> 

		 	<input id="tab2" type="radio" name="tabs">
		 	<label for="tab2" title="Вкладка 2">DataTables</label>  


			<section id="content2">
				<div class="selection_box">
					<ul>
                        <?php
                            $sxml = simplexml_load_file("playlist.xml");
                            foreach($sxml->track as $track){
                                echo "<li class='list_item ".$track["option"]."'>".$track."</li>";
                            }
                        ?>
					</ul>

				</div>
			</section>  

		</div>
	</body>
</html>
