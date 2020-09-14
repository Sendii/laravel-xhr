curr_page = pagination.curr_page
last_page = pagination.last_page

function makePaginate(total){
	var paginate = ''
	paginate += '<li class="page-item" id="prev-page">'
	paginate += '<a class="page-link" href="javascript:void(0)" tabindex="-1">Previous</a>'
	paginate += '</li>'
	for (var i = 1; i <= total; i++) {
		paginate += '<li class="page-item" id="page-number"><a class="page-link" href="javascript:void(0)" data-page="'+i+'">'+i+'</a></li>'
	}

	paginate += '<li class="page-item" id="next-page">'
	paginate += '<a class="page-link" href="javascript:void(0)">Next</a>'
	paginate += '</li>'

	$('#custom-paginate').html(paginate)
	activePage(curr_page)
	console.log('current: '+curr_page)
	console.log('last: '+last_page)
	if (curr_page == 1) {			
		disabledButton('first')
	}else if(curr_page == last_page){
		disabledButton('last')
	}
}	

function activePage(page){
	$('.page-link[data-page="'+page+'"]').parent().addClass('active')
}

function disabledButton(param='first'){
	if (param == "first") {
		if (curr_page == 1) {
			$('#prev-page').addClass('disabled')
		}
	}else{
		$('#next-page').addClass('disabled')
	}	
}	