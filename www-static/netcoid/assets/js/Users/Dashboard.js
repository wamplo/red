function getNewFeed(){$("#posts-from-following li.from-follow-uid:first").data("id");$("#posts-from-following li.from-follow-gid:first").data("id");var a=$("#posts-from-following li:first").data("id");a&&$.ajax({type:"GET",url:"/api/p/refresh",data:{f:a},success:function(a){console.log(a);a&&($("#ajax-update-following").html('<a id="ajax-refresh" href="#">Something is changing!</a>'),$("#ajax-refresh").click(function(a){$("#posts-from-following").fadeIn().load("/dashboard");$("#ajax-refresh").fadeOut();
a.preventDefault()}))}})}jQuery(document).ready(function(){setInterval(function(){getNewFeed()},7E3)});
