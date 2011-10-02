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

			if (strlen($post['title']) > 60) {
				$post['title'] = substr($post['title'], 0, 60) . '(...)';
			}

			echo '<li class="type-0">';
			echo '<a data-pjax="#rr-2" href="/post?id='.$post['PID'].'" class="dc">'.$post['title'].'</a> 
			<i>by</i> <a class="u"href="/'.$post['username'].'">'.$post['name'].'</a>';
			?>
		<?php endforeach ?>
		</ul>
	</div>
</div>

<?php $data['pagination']->creatHtmlInfo(); ?>