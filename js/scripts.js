jQuery.noConflict();
jQuery(document).ready(function($) {
	var form_wrap = $('.form-filters-wrapper'),
		prg_wrap = $('.progress-wrapper'),
		prg_lines = $('.prg-line'),
		prg_notifier_line = $('.prg-line.notifier'),
		prg_circles_wrap = $('.prg-circles-wrapper'),
		prg_circles = $('.prg-circle'),
		Nav = SearchApp.Nav,
		Template = SearchApp.Template,
		Progress = SearchApp.Progress;

	Progress.init({
		prg_lines : $('.prg-line'),
		prg_notifier_line :$('.prg-line.notifier'),
		prg_circles_wrap : $('.prg-circles-wrapper'),
		prg_circles : $('.prg-circle')
	});

	Template.populate_box(form_wrap.children('.centered'));

	prg_lines.css({
		'top': ( (prg_wrap.height()/2) - (prg_lines.height()/2) ) 
	});

	prg_circles_wrap.css({
		'top': ( (prg_wrap.height() / 2) - (prg_circles_wrap.height()/2) ) 
	});

	prg_circles.append('<canvas></canvas>');

	prg_notifier_line.animate({
		'width' : prg_circles.first().offset().left - form_wrap.offset().left
	}, 1000);


	form_wrap.on('click', '.nav-arrow', function(e){
		e.preventDefault();
		var $this = $(this),
			choice = $this.data('has-choice');

		if (choice == 'yes') {
			$this.siblings('.nav-btns').show();
		}else if(choice == 'no'){
			var next_filter = $this.data('to');
			Nav.goto(next_filter);
		}
	});


	form_wrap.on('click', '.nav-btn', function(e){
		e.preventDefault();
		var $this = $(this),
			filter = $this.data('to');

		Nav.goto(filter);
	});

	form_wrap.on('click', '#submit_search', function(e){
		e.preventDefault();
		var params = {};

		$('.form-filter.on-left').each(function(i, obj){
			var item = $(obj).data('item');

			if(typeof(item) != 'undefined' && item.length>0){
				params[item] = GatherChecks(item);
			}
		});

		var save_search = $.ajax({
				url: SEARCH_AJAX.ajaxurl,
				dataType: 'json',
				type: 'POST',
				data: {
					action: 'save_custom_search',
					search_query: params,
					nome: $('#nome').val(),
					cognome: $('#cognome').val(),
					email: $('#email').val(),
					telefono: $('#telefono').val()
				}
			});
	});
});

(function() {
  var requestAnimationFrame = window.requestAnimationFrame || window.mozRequestAnimationFrame ||
                              window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;
  window.requestAnimationFrame = requestAnimationFrame;
})();


var SearchApp = {};

SearchApp.Actions = jQuery({});
SearchApp.Selected = {};

SearchApp.Progress = {
	elems: {},
	init: function(elems){
		var Actions = SearchApp.Actions;
		this.current = 1;
		Actions.on('progress', this.update_progress);

		jQuery.extend(this.elems, elems);

		return this;
	},
	update_progress: function(e, params){
		var $this = SearchApp.Progress,
			circle = $this.elems.prg_circles.filter('[data-level="' +params.level+ '"]');

		$this.update_progress_bar(circle, params.level);
		$this.update_progress_circle(circle, params.level);
	},
	update_progress_bar: function(circle, level){
		var elems = this.elems;

		elems.prg_notifier_line.animate({
			'width' : circle.offset().left
		}, 1000);
	},
	update_progress_circle: function(circle, level){
		//dir = (level == 2) ? ;
		//this.drawCircle(circle.find('canvas'), 'up');
	},
	drawCircle : function(el, dir){
		var canvas = el[0];
		var context = canvas.getContext('2d');
		console.log(canvas.width);
		var x = canvas.width / 2;
		var y = canvas.height / 2;
		var radius = 65;
		var endPercent = 25;
		var curPerc = 0;
		var counterClockwise = false;
		var circ = Math.PI * 2;
		var quart = Math.PI;

		context.lineWidth = 10;
		context.strokeStyle = '#ad2323';
		context.shadowOffsetX = 0;
		context.shadowOffsetY = 0;
		context.shadowBlur = 10;
		context.shadowColor = '#656565';


		function animate(current) {
			if(dir=="up"){
				start1 = -(quart);
				end1 = ((circ) * current) - quart;
				clock1 = false;

				start2 = start1;
				end2 = -end1;
				clock2 = true;
			}else{
				start1 = -(quart)/2;
				end1 = ((circ) * current) - quart/2;
				clock1 = false;

				start2 = -start1;
				end2 = -end1;
				clock2 = true;
			}
			context.clearRect(0, 0, canvas.width, canvas.height);
			context.beginPath();
			context.arc(x, y, radius, start1, end1, clock1);
			context.stroke();

			context.beginPath();
			context.arc(x, y, radius, start2, end2, clock2);
			context.stroke();
			curPerc++;
			if (curPerc < endPercent) {
				requestAnimationFrame(function () {
				 animate(curPerc / 100)
				});
			}
		}

		animate();
	}
};

SearchApp.Template = {
	populate_box: function(box){
		var $this = this,
			name = box.data('item'),
			loading_screen = jQuery('<i class="loading icon-3x icon-spinner icon-spin"></i>');

		box.append(loading_screen);

		var get_tpl = $this.get_tpl(name);

		get_tpl.fail(function() {
			console.log('template not found!');
		});

		get_tpl.done(function(ret) {
			var tpl = ret,
				get_skeleton = $this.get_tpl_data(name);

			get_skeleton.done(function(ret){
				var flesh = Handlebars.compile(tpl),
					skeleton = ret;

				box.addClass(name+'-filter-box').html(flesh(skeleton));
				$this.re_initialize_nano();
				$this.init_instant_search(box);

				//loading_screen.remove();
			});
		});

	},
	get_tpl: function(name){
		var req = jQuery.ajax({
			url: SEARCH_AJAX.tplurl+ name + ".hb",
			dataType: 'html'
		});

		return req;
	},
	get_tpl_data: function(name){
		var params = params || {},
			action = 'get_'+name+'_skeleton';

		if(name == 'subcategories'){
			params.cats = [];
			jQuery('.categories-filter-box .result-wrapper')
				.find('input[type="checkbox"]:checked')
				.each(function(i, obj){
					params.cats.push(obj.value);
					//console.log(obj);
				});
		}

		var req = jQuery.ajax({
			url: SEARCH_AJAX.ajaxurl,
			dataType: 'json',
			type: 'POST',
			data: {
				action: action,
				params: params
			}
		});

		return req;
	},
	re_initialize_nano: function(){
		jQuery('.nano').nanoScroller();
	},
	init_instant_search: function(box){
		var search_input = box.find('.search-input'),
			$this = this;

		search_input.fastLiveFilter(
			box.find('.content'), 
			{ 
				timeout: 20, 
				callback: $this.re_initialize_nano
			}
		);
		
		box.on('click', '.icon-search', function(e){
			e.preventDefault();
			if(!search_input.hasClass('opened')){
				search_input.addClass('opened');
				search_input.removeClass('closed');
			}else{
				search_input.removeClass('opened');
				search_input.addClass('closed');
			}
		});
	}
};
		
SearchApp.Nav = {
	goto: function(item){
		var $this = this,
			Template = SearchApp.Template,
			Actions = SearchApp.Actions,
			box = jQuery('.'+ item +'-filter-box');

		$this.trigger_progress(item);

		if (box.length > 0 && box.hasClass('on-left')) {
			//already exists and the box is on the left
			//which implies that that section has already been filled out
			//so we don't need to render the template again
			//Move form towards where the matched section
			$this.move_form_to('left');
		}else{
			//doesn't exist
			//move the form towards RIGHT
			new_box = $this.move_form_to('right');

			//compile the section template with data
			new_box.attr('data-item', item);
			Template.populate_box(new_box);
		}
	},
	move_form_to: function(dir){
		var centered = jQuery('.form-filter.centered'),
			next = centered.next(),
			prev = centered.prev();

		if(dir == 'right'){
			centered
				.addClass('on-left')
				.removeClass('centered');
			
			next
				.addClass('centered')
				.removeClass('on-right');

			jQuery('<div/>', { class: 'form-filter on-right'}).insertAfter(next);
			return next;
		}else if(dir == 'left'){
			centered
				.addClass('on-right')
				.removeClass('centered');
			
			prev
				.addClass('centered')
				.removeClass('on-left');

			return prev;
		}
	},
	trigger_progress: function(box){
		switch(box){
			case 'start':
				level = 1;
				break;
			case 'categories':
				level = 2;
				break;
			case 'geolocation':
				level = 2;
				break;
			case 'personal':
				level = 3;
				break;
			default:
				level = 1;
				break;
		}

		SearchApp.Actions.trigger('progress', {level : level});
	}
};


Handlebars.registerHelper('total', function(json_array, options) {
	return new Handlebars.SafeString(json_array.length);
});


var GatherChecks = function (from){
	var box = jQuery('.'+ from +'-filter-box .result-wrapper'),
		storage = [];

	box.find('input[type="checkbox"]:checked')
		.each(function(i, obj){
			storage.push(obj.value);
		});
	
	if(from == 'zones'){
		return storage.join(', ');
	}else{
		return storage;
	}
}