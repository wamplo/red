<style type="text/css">
#groups-header{
	border-bottom: 1px solid #DDD;
	padding: 5px 0;
}

#groups-menu li{float:left;margin-right:15px;}
li.type-1 a.df{color:#1EA7E7;}
li.type-2 a.df{    color: #47C937;}
</style>
<?php #var_dump($data); ?>
<div id="red-content">

	<div class="m" id="groups-header">
		<div class="dv" style="width:700px">
		<ul id="groups-menu">
			<?php if ($data['status']['permission']['post'] && $data['login'] && 
			in_array($data['user']['role'], $data['status']['permission']['users'])): ?>
				<li><a class="df" href="/post/any?id=<?php echo $_GET['id'] ?>">Post</a></li>
			<?php endif ?>

			<?php if ($data['status']['permission']['request'] && $data['login'] && 
			in_array($data['user']['role'], $data['status']['permission']['users'])): ?>
				<li><a class="df" href="/post/request?id=<?php echo $_GET['id'] ?>">Permintaan</a></li>
			<?php endif ?>

			<?php if ($data['status']['permission']['offer'] && $data['login'] && 
			in_array($data['user']['role'], $data['status']['permission']['users'])): ?>
				<li><a class="df" href="/post/offer?id=<?php echo $_GET['id'] ?>">Penawaran</a></li>
			<?php endif ?>

			<?php if (!$data['login']): ?>
				<li><a class="df" href="/login">Masuk untuk posting</a></li>
			<?php endif ?>
		</ul>

		</div>
		<div class="dy"><?php echo $data['info']['name']; ?></div>
	</div>

	<div class="m" id="groups-content">

		<?php
			$data['pagination']->createHtml();
		?>

		<div style="padding: 5px 0pt 0pt; width: 700px;" class="dv">

		<?php if ($data['status']['status'] === 1): ?>
			<ul>
			<?php foreach ($data['posts'] as $post): ?>
				<?php
				echo '<li class="type-'.$post['status'].'">';

				echo '<a class="df" href="post?id='.$post['PID'].'">'.$post['title'].'</a> 
				<i>by</i> <a class="dp"href="'.$post['username'].'">'.$post['name'].'</a>';
				echo "</li>";

				?>
			<?php endforeach ?>
			</ul>
		<?php endif ?>

		</div>
		<div style="width: 250px; padding: 5px;" class="dy">
			<div style="padding-bottom: 5px;"><?php echo $data['info']['description']; ?></div>

			<?php if (!$data['login']): ?>
				<div><a class="df" href="/login">Masuk untuk Mengikuti <?php echo $data['info']['name']; ?></a></div>
			<?php endif ?>

			<?php if ($data['login']): ?>
					<?php if (!$data['follow']): ?>
						<div><a class="df" href="/api/s/g/follow?id=<?php echo $_GET['id'] ?>">Ikuti <?php echo $data['info']['name']; ?></a></div>
					<?php endif ?>

					<?php if ($data['follow']): ?>
						<div><a class="df" href="/api/s/g/unfollow?id=<?php echo $_GET['id'] ?>">Tidak ikuti <?php echo $data['info']['name']; ?></a></div>
					<?php endif ?>				
			<?php endif ?>
		</div>
	</div>

</div>
<?php $data['pagination']->creatHtmlInfo(); ?>