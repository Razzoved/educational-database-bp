function swing(target) {
    $where = $(target);

     if($where.length) {
         $("html, body").stop().animate({
              "scrollTop": $where.offset().top - 60
         }, 400, "swing", function () {
              // window.location.hash = target;
         });
     }
}

function checkedFilters() {
	var items = $('input:checkbox:checked');
	var input = $('input[name="file"]').val();
	if (items.length > 0 || input != "") {
		$('.reset-filters-btn').show('200');
	}else {
		$('.reset-filters-btn').hide('200');
	}
}

function openModal(target) {
	$(target).fadeIn(400, function() {
      $(this).addClass('open');
    });
}

function closeModal(target) {
	$(target).fadeOut(400, function() {
  		$(this).removeClass('open');
  	});
}

$(document).ready(function($) {
	
	$('.comment-text-stars .star').hover(function() {
		var myIndex =  $(this).index();
		console.log(myIndex);

		$('.comment-text-stars .star').each(function(index, el) {
			if ($(this).index() <= myIndex) {
				$(this).addClass('active');
			}
		});
	}, function() {
		$('.comment-text-stars .star.active').removeClass('active');
	});

	$('.comment-text-stars .star').click(function(event) {
		var myIndex =  $(this).index();
		$('.comment-text-stars .star.pernament-active').removeClass('pernament-active');
		$('.comment-text-stars .star.active').addClass('pernament-active');
		$('input#star_count').val(myIndex+1);
	});

	$('#material-comment-add').submit(function(event) {
		var name = $('input[name="comment_author"]').val();
		var mail = $('input[name="comment_author_mail"]').val();
		var stars = $('input[name="star_count"]').val();
		var text = $('textarea[name="comment_text"]').val();

		if (stars == 0 && text == "") {
			$('#comment_error').text('You must fill number of stars or comment text.');
			event.preventDefault();
		}	
	});

	$('.tax-filter-row').each(function(index, el) {
	   var targets =  $(this).children('p.tax-input.hidden-item');

	   if (targets.length >= 1) {
	   		$(this).addClass('hidden-items');
	   		$(this).append('<div class="show-more-btn" data-index="'+index+'">Show more</div>');
	   }
	});

	$('.show-more-btn').click(function(event) {
		var index = $(this).data('index');

		if ($(this).hasClass('open')) {
			$(this).text('Show more');
			$(this).removeClass('open');
			$('.tax-filter-row:eq('+index+') .showed-item').slideUp().addClass('hidden-item').removeClass('showed-item');
		}else {
			$(this).addClass('open');
			$(this).text('Hide');
			$('.tax-filter-row:eq('+index+') .hidden-item').slideDown().addClass('showed-item').removeClass('hidden-item');
		}
	});

	checkedFilters();

	$('input:checkbox').change(function(event) {
		checkedFilters();
	});

	$('input[name="file"]').change(function(event) {
		checkedFilters();
	});

	$('.reset-filters-btn').click(function(event) {
		event.preventDefault();
		$('input[name="file"]').val('');
		$('input:checkbox').removeAttr('checked');
		$('.reset-filters-btn').hide('300');
	});

	$('a[href="#file-search-form"]').click(function(event) {
		swing('#file-search-form');
	});

  $('.show-filters-btn').click(function(event) {
    openModal('.filters-popup');
  });

  $('.filters-popup .popup-divider').click(function(event) {
  	closeModal('.filters-popup');
  });

  $('.popup-close').click(function(event) {
  	closeModal('.filters-popup');
  });

  $('#fm-filter-btn').click(function(event) {
  	closeModal('.filters-popup');
  });

  $('.edit-filters-btn').click(function(event) {
  	openModal('.filters-popup');
  });

});