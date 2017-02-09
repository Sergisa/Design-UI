/**
 * Created by Sergey on 09.02.2017.
 */
$(document).ready(function(){
	$('.selection_box').click(function (e) {
		if ($(e.target).hasClass("list_item")) {

			$(this).find('li.selected').removeClass("selected");
			$(e.target).addClass("selected");
		}
	});
	function CreateListBox() {
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


	$('#nav_prev').click(function () {
		var first_elem = $('.selection_box ul li').first();
		//console.log("first element", first_elem);
		var was_selected = $('.selection_box').find('li.selected');
		//console.log("was selected", was_selected);
		if (was_selected[0] == first_elem[0]) {
			//last item
			$('.selection_box .footer .middle')
				.toggleClass('middle noti')
				.html("Reached first item");
			console.log("reached last item");

		} else {

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
	$('#nav_next').click(function () {
		var last_elem = $('.selection_box ul li').last();
		//console.log("last element", last_elem);
		var was_selected = $('.selection_box').find('li.selected');
		//console.log("was selected", was_selected);
		if (was_selected[0] == last_elem[0]) {
			console.log("reached last item");
			$('.selection_box .footer .middle')
				.toggleClass('middle noti')
				.html("Reached last item");
		} else {
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
		}
	});
});
