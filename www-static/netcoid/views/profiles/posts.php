<style type="text/css">
#icon-post {
    bottom: -3px;
    padding-right: 10px;
    position: relative;
}
</style>

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
			#var_dump($post);
			if (strlen($post['title']) > 60) {
				$post['title'] = substr($post['title'], 0, 60) . '(...)';
			}
			echo '<li class="type-'.$post['status'].'">';

			echo '<span id="icon-post">';
			$this->getIMG('netcoid','img/icons/post.png');
			echo "</span>";
			echo '<a data-pjax="#rr-2" href="/post?id='.$post['PID'].'" class="a">'.$post['title'].'</a> 
			<i>in</i> <a class="" href="/group?id='.$post['post_GID'].'">'.$post['groups_name'].'</a>';
			?>
		<?php endforeach ?>
		</ul>
	</div>
</div>

<?php $data['pagination']->creatHtmlInfo(); ?>