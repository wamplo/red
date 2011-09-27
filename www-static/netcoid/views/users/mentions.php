<div class="m" id="red-content">
	<?php foreach ($data['mentions'] as $mention): ?>
		<li class="k">
			<span>@<?php echo $mention['name']; ?></span> 
			<?php echo $mention['comment']; ?>
			<?php echo "<span id='l'><a href='/post?id=".$mention['comment_PID']."#comment-".$mention['CID']."'>see</a></span>"; ?>
			<?php echo "<span id='d'><a href='/api/m/open?id=".$mention['CID']."'>x</a></span>"; ?>
		</li>
	<?php endforeach ?>
</div>