$(document).ready(function() {
	$('a[data-pjax]').pjax()
		$('body')
		  .bind('pjax:start', function() { /* $('#loading').html('<div style="position: absolute;margin: 0 50%;background: #fff;padding: 2px 10px;">loading...</div>'); */ })
		  .bind('pjax:end',   function() { /* $('#loading').hide() */ })
	});