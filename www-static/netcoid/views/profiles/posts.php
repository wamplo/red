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


	<div class="m" id="profiles-header">
		<div class="dz" style="width:700px">
		<ul id="profiles-menu">

			<?php if ($data['login'] == $data['user']['uid']): ?>
				<li><a class="dj" href="/edit/profile">Edit Profil Anda</a></li>	
			<?php endif ?>

			<?php if ($data['login'] && $data['login'] != $data['user']['uid']): ?>
				<?php if (empty($data['follow'])): ?>
					<li><a class="di" href="/api/s/u/follow?id=<?php echo $data['user']['uid']; ?>">Ikuti</a></li>
				<?php endif ?>

				<?php if (!empty($data['follow'])): ?>
					<li><a class="di" href="/api/s/u/unfollow?id=<?php echo $data['user']['uid']; ?>">Tidak Ikuti</a></li>
				<?php endif ?>
			<?php endif ?>

			<?php if (!$data['login']): ?>
				<li><a class="di" href="/login">Masuk untuk mengikuti</a></li>
			<?php endif ?>

			
			<li><a class="di" href="/<?php echo $data['user']['username']; ?>/posts">Posts</a></li>
			<li><a class="di" href="/<?php echo $data['user']['username']; ?>/offers">Penawaran</a></li>
			<li><a class="di" href="/<?php echo $data['user']['username']; ?>/requests">Permintaan</a></li>
		</ul>
		</div>
		<div class="ec"><a class="dj" href="/<?php echo $data['user']['username']; ?>"><?php echo $data['user']['name'];  ?></a></div>
	</div>

	<div>
		<ul>
		<?php foreach ($data['posts'] as $post): ?>
			<?php
			echo '<li class="type-0">';
			echo '<a class="di" href="/post?id='.$post['PID'].'">'.$post['title'].'</a> 
			<i>by</i> <a class="dj"href="/'.$post['username'].'">'.$post['name'].'</a>';
			?>
		<?php endforeach ?>
		</ul>
	</div>
</div>

<?php $data['pagination']->creatHtmlInfo(); ?>