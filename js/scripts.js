/**
 * Created by Sergey on 09.02.2017.
 */

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