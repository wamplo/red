<style type="text/css">
#profiles-header{
	border-bottom: 1px solid #DDD;
	padding: 5px 0;
}

#profiles-menu li{float:left;margin-right:15px;}
</style>
<div id="red-content">

	<?php
		$data['pagination']->createHtml();
	?>


	<div class="clearfix" id="profiles-header">
		<div class="l" style="width:700px">
		<ul id="profiles-menu">

			<?php if ($data['login']): ?>
				<li><a class="a" href="/api/social/follow?id=<?php echo $data['user']['uid'];; ?>">Ikuti</a></li>
			<?php endif ?>

			<?php if (!$data['login']): ?>
				<li><a class="a" href="/login">Masuk untuk mengikuti</a></li>
			<?php endif ?>
			
			<li><a class="a" href="/<?php echo $data['user']['username']; ?>/posts">Posts</a></li>
			<li><a class="a" href="/<?php echo $data['user']['username']; ?>/offers">Penawaran</a></li>
			<li><a class="a" href="/<?php echo $data['user']['username']; ?>/requests">Permintaan</a></li>
		</ul>
		</div>
		<div class="r"><a class="u" href="/<?php echo $data['user']['username']; ?>"><?php echo $data['user']['name'];  ?></a></div>
	</div>

	<div>
		<ul>
		<?php foreach ($data['posts'] as $post): ?>
			<?php
			echo '<li class="type-2">';
			echo '<a class="a" href="/post?id='.$post['PID'].'">'.$post['title'].'</a> 
			<i>by</i> <a class="u"href="/'.$post['username'].'">'.$post['name'].'</a>';
			?>
		<?php endforeach ?>
		</ul>
	</div>
</div>

<?php $data['pagination']->creatHtmlInfo(); ?>