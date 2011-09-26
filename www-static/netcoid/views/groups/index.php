<style type="text/css">
#groups-header{
	border-bottom: 1px solid #DDD;
	padding: 5px 0;
}

#groups-menu li{float:left;margin-right:15px;}
li.type-1 a.di{color:#1EA7E7;}
li.type-2 a.di{    color: #47C937;}
</style>
<?php #var_dump($data); ?>
<div id="red-content">

	<div class="m" id="groups-header">
		<div class="dz" style="width:700px">
		<ul id="groups-menu">
			<?php if ($data['status']['permission']['post'] && $data['login'] && 
			in_array($data['user']['role'], $data['status']['permission']['users'])): ?>
				<li><a class="di" href="/post/any?id=<?php echo $_GET['id'] ?>">Post</a></li>
			<?php endif ?>

			<?php if ($data['status']['permission']['request'] && $data['login'] && 
			in_array($data['user']['role'], $data['status']['permission']['users'])): ?>
				<li><a class="di" href="/post/request?id=<?php echo $_GET['id'] ?>">Permintaan</a></li>
			<?php endif ?>

			<?php if ($data['status']['permission']['offer'] && $data['login'] && 
			in_array($data['user']['role'], $data['status']['permission']['users'])): ?>
				<li><a class="di" href="/post/offer?id=<?php echo $_GET['id'] ?>">Penawaran</a></li>
			<?php endif ?>

			<?php if (!$data['login']): ?>
				<li><a class="di" href="/login">Masuk untuk posting</a></li>
			<?php endif ?>
		</ul>

		</div>
		<div class="ec"><?php echo $data['info']['name']; ?></div>
	</div>

	<div class="m" id="groups-content">

		<?php
			$data['pagination']->createHtml();
		?>

		<div style="padding: 5px 0pt 0pt; width: 700px;" class="dz">

		<?php if ($data['status']['status'] === 1): ?>
			<ul>
			<?php foreach ($data['posts'] as $post): ?>
				<?php
				echo '<li class="type-'.$post['status'].'">';

				echo '<a class="di" href="post?id='.$post['PID'].'">'.$post['title'].'</a> 
				<i>by</i> <a class="dj"href="'.$post['username'].'">'.$post['name'].'</a>';
				echo "</li>";

				?>
			<?php endforeach ?>
			</ul>
		<?php endif ?>

		</div>
		<div style="width: 250px; padding: 5px;" class="ec">
			<div style="padding-bottom: 5px;"><?php echo $data['info']['description']; ?></div>

			<?php if (!$data['login']): ?>
				<div><a class="di" href="/login">Masuk untuk Mengikuti <?php echo $data['info']['name']; ?></a></div>
			<?php endif ?>

			<?php if ($data['login']): ?>
					<?php if (!$data['follow']): ?>
						<div><a class="di" href="/api/s/g/follow?id=<?php echo $_GET['id'] ?>">Ikuti <?php echo $data['info']['name']; ?></a></div>
					<?php endif ?>

					<?php if ($data['follow']): ?>
						<div><a class="di" href="/api/s/g/unfollow?id=<?php echo $_GET['id'] ?>">Tidak ikuti <?php echo $data['info']['name']; ?></a></div>
					<?php endif ?>				
			<?php endif ?>
		</div>
	</div>

</div>
<?php $data['pagination']->creatHtmlInfo(); ?>