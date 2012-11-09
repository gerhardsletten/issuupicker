$(function() {
	var issuu_template = '<div class="issuu-item" data-document-id="<%= documentId %>"><img src="http://image.issuu.com/<%= documentId %>/jpg/page_1_thumb_medium.jpg" /><strong><%= title %></strong><br />By <%= username %> <%= views %> views, <%= pagecount %> pages <input type="button" class="issuu-remove-link button" value="Remove" /></div>'
	,template = _.template(issuu_template);

	$('.issuu-preview').each(function(){
		var me = $(this)
		, preview_el = me.find('.current-issuu')
		, ez_input_el = me.find('.issuupicker')
		, current_document_id = preview_el.attr('data-document-id')
		, search_input = me.find('.issuu-search')
		, search_results = me.find('.issuu-search-preview')
		, current_search = "";

		if(current_document_id && current_document_id.length > 10) {
			$.getJSON('http://search.issuu.com/api/2_0/document?documentId='+encodeURI(current_document_id)+'&responseParams=title,pagecount,username,views&jsonCallback=?', function(data) {
					preview_el.empty();
					$.each(data.response.docs, function(key, val) {
					    //console.log(val);
					    preview_el.append(template(val));
					});
			});
		}

		search_input.bind("keyup",function(e){
	    	var searchString = $(this).val();
	    	if(searchString.length > 3 && searchString !== current_search) {
	    		$.getJSON('http://search.issuu.com/api/2_0/document?q='+encodeURI(searchString)+'&responseParams=title,pagecount,username,views&jsonCallback=?', function(data) {
	    				search_results.empty();
	    				$.each(data.response.docs, function(key, val) {
	    				    search_results.append(template(val))
	    				});
	    		});
	    		current_search = searchString;
	    	}
	    });

	    search_results.on("click", ".issuu-item", function(event){
	    	var me = $(this),
	    	choosen_document_id = me.attr('data-document-id');
	    	ez_input_el.val(choosen_document_id);
	    	preview_el.html(me.clone());
	    	search_results.empty();
	    	search_input.val("");
	    });

	    preview_el.on("click", ".issuu-item .issuu-remove-link", function(event){
	    	event.preventDefault();
	    	ez_input_el.val("");
	    	preview_el.html("");
	    });
	});
});


