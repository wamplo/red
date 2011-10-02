<div class="clearfix" id="red-content">
	<?php foreach ($data['mentions'] as $mention): ?>
		<li class="clearfix mentions">
			<span>@<?php echo $mention['name']; ?></span> 
			<?php echo $mention['comment']; ?>
			<?php echo "<span id='link'><a href='/post?id=".$mention['comment_PID']."#comment-".$mention['CID']."'>see</a></span>"; ?>
			<?php echo "<span id='delete'><a href='/api/m/open?id=".$mention['CID']."'>x</a></span>"; ?>
		</li>
	<?php endforeach ?>
</div>