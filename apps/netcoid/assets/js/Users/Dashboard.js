

function getNewFeed(){
	var datafromlastuid = $('#posts-from-following li.from-follow-uid:first').data('id');
	var datafromlastgid = $('#posts-from-following li.from-follow-gid:first').data('id');
	var datalastid = $('#posts-from-following li:first').data('id');

	if (datalastid){
        $.ajax({
            type: 'GET',
            url: '/api/p/refresh',
            data: { f: datalastid },
            success: function(data) {
            	//console.log(data);
            	if (data == 'true') {
            		// LOAD SOMETHING
            		$('#ajax-update-following').html('<a id="ajax-refresh" href="#">Something is changing!</a>');

            		// IF CLICK
                    $('#ajax-refresh').click(function(e) {
                        //I commented the following line because (as i understand)    
                        //getNewFeed() makes the ajax call
                        $('#posts-from-following').fadeIn().load('/dashboard');
                        //$('#posts-from-following').fadeIn().load('/dashboard #posts-from-following');
                        $('#ajax-refresh').fadeOut();
                        e.preventDefault();
                    });
            	};
            }
        });
	}
	// IF EXIST DATA UID
	// SEARCH DIFFRENCE

	// IF EXIST DATA GID
	// SEARCH DIFFRENCE

	//console.log(datalastid);
	//alert('awdawd');	
}

jQuery(document).ready(function(){

	setInterval(function() {
		getNewFeed();            
	}, 7000);       
});