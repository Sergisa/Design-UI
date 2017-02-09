<html>
	<head>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
	  	<link href="css/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
		<meta charset="utf-8"/>
	 	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<!--<script src="js/scripts.js" type="text/javascript" language="javascript"></script>-->
		<script src="js/device.js" type="text/javascript" language="javascript"></script>
		<script src="js/classie.js" type="text/javascript" language="javascript"></script>
		<script src="js/jquery.js" type="text/javascript" language="javascript"></script> 
		<script src="js/draggabilly-master/dist/draggabilly.pkgd.js" type="text/javascript" language="javascript"></script>
		<link rel="stylesheet" type="text/css" href="js/DataTables-1.10.12/css/dataTables.bootstrap.css"/>
		<script type="text/javascript" src="js/DataTables-1.10.12/js/jquery.dataTables.js"></script>
		
	  	<!--<script src="//vk.com/js/api/openapi.js" type="text/javascript"></script>-->
		<script src="js/jquery-ui.js"></script>
		<script>
		    function button1_Click(){  
				$.getJSON("file.json",function(data){
					document.title = data.title;
					$("#test").text(data.test);
				});
		    }
			function Drop(e){
				$(e.target).removeClass("dragIn"); 
				var dt = e.dataTransfer;
				if(!dt && !dt.files) { return false ; }
			 
				// Получить список загружаемых файлов
				var files = dt.files;
			 
				// Fix для Internet Explorer
				dt.dropEffect="copy";
			 
				// Загрузить файлы по очереди, проверив их размер
				for (var i = 0; i < files.length; i++) {
					if (files[i].size<15000000) { 
						// Отправить файл в AJAX-загрузчик
						ajax_upload(files[i]);
					}
					else {
						alert('Размер файла превышает допустимое значение');
					}
				} 
				e.stopPropagation();
				e.preventDefault(); 
				console.log("dropped", e.dataTransfer);
				
				return false;
			}
			
			function dragIn(e){
				$(e.target).addClass("dragIn");
				e.stopPropagation();
				e.preventDefault(); 
				console.log("dragged");
			}
			function dragLeave(e){
				$(e.target).removeClass("dragIn"); 
			}
			function getUrlVars()
			{
					var vars = [], hash;
					var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
					for(var i = 0; i < hashes.length; i++)
					{
							hash = hashes[i].split('=');
							vars.push(hash[0]);
							vars[hash[0]] = hash[1];
					}
					return vars;
			}
			$(document).ready(function(){
				if(getUrlVars()["tab"]!=undefined){
					$(".tabs").find('input#tab'+getUrlVars()["tab"]).attr("checked", "true");
				}
				$("#dialog").dialog({
					resizable: true,
					//grid: [30,15],
					autoOpen:false,
					modal: true,
					buttons: {
						"Delete all items": function() {
							$( this ).dialog( "close" );
						},
						Cancel: function() {
							$( this ).dialog( "close" );
						}
					}
				});
			
				//$('#drag_in').on('dragover', dragIn);
				//$('#drag_in').on('dragenter', dragIn);
				//$('#drag_in').on('drop', Drop);
				$("#dialog_opener").click(function(){
					$("#dialog").dialog("open");
				});
				$('#jqdt').DataTable();
				$('#datepicker').datepicker();
				$("#dialog_opener").button();
				
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
				function getCaret(el) { 
				  	if (el.selectionStart) { 
				    	return el.selectionStart; 
				  	} else if (document.selection) { 
				    	el.focus(); 
				 
				    	var r = document.selection.createRange(); 
				    	if (r == null) { 
				      		return 0; 
				    	} 
				 
				    	var re = el.createTextRange(), 
					    rc = re.duplicate(); 
					    re.moveToBookmark(r.getBookmark()); 
					    rc.setEndPoint('EndToStart', re); 
				 
				    	return rc.text.length; 
				  	}  
				  	return 0; 
				}
				//Вставка текста на место курсора 
				function insertTextAtCursor(el, text, offset) {
				    var val = el.value, endIndex, range, doc = el.ownerDocument;
				    if (typeof el.selectionStart == "number"
				            && typeof el.selectionEnd == "number") {
				        endIndex = el.selectionEnd;
				        el.value = val.slice(0, endIndex) + text + val.slice(endIndex);
				        el.selectionStart = el.selectionEnd = endIndex + text.length+(offset?offset:0);
				    } else if (doc.selection != "undefined" && doc.selection.createRange) {
				        el.focus();
				        range = doc.selection.createRange();
				        range.collapse(false);
				        range.text = text;
				        range.select();
				    }
				}
				function setSelectionRange(input, selectionStart, selectionEnd) {
				  if (input.setSelectionRange) {
				    input.focus();
				    input.setSelectionRange(selectionStart, selectionEnd);
				  }
				  else if (input.createTextRange) {
				    var range = input.createTextRange();
				    range.collapse(true);
				    range.moveEnd('character', selectionEnd);
				    range.moveStart('character', selectionStart);
				    range.select();
				  }
				}
				//Установка курса на определённую позицию
				function setCaret(input, pos) {
				  	setSelectionRange(input, pos, pos);
				}
				$('#move').click(function(){

					setCaret(document.getElementById("txtar"), getCaret(document.getElementById("txtar"))+2);
				});
				$('#clear').click(function(){
					//console.log("sdfsdf");
					$('#txtar').val("");
				});
				$('.funcInsert').click(function(){
					var targetField = $(this).attr("target");
					console.log(getCaret(document.getElementById(targetField)));
					//console.log($(this).attr("target"));
					insertTextAtCursor(document.getElementById(targetField), $(this).attr('value'));
					$('#'+targetField).focus();
					setCaret(document.getElementById(targetField), getCaret(document.getElementById(targetField))-1);
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
		<div id="dialog" title="jquery dialog">
			<p>These items will be permanently deleted and cannot be recovered. Are you sure?</p>
		</div>
		<p>
			<input type="submit" class="material darkbrown" style="" value="Click Me" onClick="button1_Click()" />
		</p>
		<div id="test"></div>
		<div id="demo"></div>
		<input type="button" class="roundmaterial cyanbutton" value="CLICK" onClick="readClick(this)" />
		<br/>
		<div class="tabs"> 
			<input id="tab1" type="radio" name="tabs" checked>
		 	<label for="tab1" title="Вкладка 1">Linux Buttons</label>  
		 	<input id="tab2" type="radio" name="tabs">
		 	<label for="tab2" title="Вкладка 2">DataTables</label>  
		 	<input id="tab3" type="radio" name="tabs">
		 	<label for="tab3" title="Вкладка 3">Вкладка 3</label>  
		 	<input id="tab4" type="radio" name="tabs">
		 	<label for="tab4" title="Вкладка 4">Вкладка 4</label>  
		 	<section id="content1">
		 	<?php
		 		function getResult($function, $vars, $control_point){
		 			if(count($vars)!==count($control_point)){
			 			return "Amount of values is not like arguments";
			 		}
			 		//foreach ($vars as $var) {
			 		for($i=0; $i<=count($vars); $i++){
			 			$var=$vars[$i];
			 			if(strpos($function, $var)!=false){
			 				$function = str_replace($var, "*".$var, $function);
							$function = str_replace($var, "$".$var, $function);
							$function = str_replace(")(", ")*(".$var, $function);
			 				//foreach ($control_point as $control_value) {
			 				eval('$'.$var. '='. $control_point[$i].';');
			 				//}
			 				echo $function.'<br>';
		 				}
		 			}
			 		//$res_given = 
			 		return eval('return '.$function.';');
		 		}
			 	function tester($answer, $t_result, $vars, $control_point){
			 		$res_given=getResult($answer,$vars,$control_point);
			 		if($res_given != $t_result){
			 			return "false";
			 		}else{
			 			return "true";
			 		}			 			
			 	}
		 		$vars = array("x","y");
		 		$values =[2,3];
		 		print tester('3x+2y', 12 , $vars, $values);
		 	?><br>
				<input type="button" class="funcInsert" target="txtar" id="square" value="Корень()">
				<input type="button" class="funcInsert" target="txtar" id="sin" value="синус()">
				<input type="button" class="funcInsert" target="txtar" id="cos" value="косинус()">
				<input type="button" id="clear" target="txtar" value="Clear"><br>
				<textarea id="txtar" class="materialfield"></textarea>
				
			
				<table id="jqdt">
					<thead>
						<tr>
							<th>Title</th>
							<th>Author</th>
							<th>Year</th>
						</tr>
					</thead>
					<tbody>

						<tr>
							<td>Content 1</td>
							<td>Content 2</td>
							<td>Content 3</td>
						</tr>
						<tr>
							<td>Content 4</td>
							<td>Content 5</td>
							<td>Content 6</td>
						</tr>
					</tbody>
				</table>
		 	</section>
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
			<section id="content3"> 
				<div id="datepicker"></div><br>
				
				<button id="dialog_opener"> jquery button</button>
			</section> 
			<section id="content4"> 
				<div id="drag_in" ondragenter="dragIn(event)" ondragover="dragIn(event)" ondragleave="dragLeave(event)" ondrop="return Drop(event);"></div>
				<div id="upload_overall"></div>
				<p>
				   <input type="button" class="roundmaterial blue" value="Показать" id="button3"/>
				</p>
				<div class="dropdown_menu">
					<ul>
						<li class="list_head">
							Drop Down Menu
						</li>
						<li class="list_item">
							Katty Perry
						</li>
						<li class="list_item">
							New line 
						</li>
						<li class="list_item">
							line3line3line3
						</li>
					</ul>
				</div>
			</section> 
		</div>
	</body>
</html>
