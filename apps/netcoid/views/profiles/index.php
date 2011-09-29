<div id="red-content">

	<?php 
		echo $this->getView('netcoid','profiles/topnav.php', $data);
	?>

	<div id="rr-2-1">
		<div class="blog-post clearfix profile-content" id="css-<?php echo $data['user']['username']; ?>">
			<?php echo $data['user']['information_html']; ?>
		</div>
	</div>
</div>