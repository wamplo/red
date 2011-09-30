<div id="red-content">

	<?php
		$data['pagination']->createHtml(array(
			'data-pjax' => '#rr-2-1'
		));
	?>

	<?php 
		echo $this->getView('netcoid','profiles/topnav.php', $data);
	?>

	<div id="rr-2-1">
		<ul>
		<?php foreach ($data['posts'] as $post): ?>
			<?php
			echo '<li class="type-0">';
			echo '<a class="dg" href="/post?id='.$post['PID'].'">'.$post['title'].'</a> 
			<i>by</i> <a class="dq"href="/'.$post['username'].'">'.$post['name'].'</a>';
			?>
		<?php endforeach ?>
		</ul>
	</div>
</div>

<?php $data['pagination']->creatHtmlInfo(); ?>