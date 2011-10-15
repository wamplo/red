<style type="text/css">
#groups-header{
	border-bottom: 1px solid #DDD;
	padding: 5px 0;
}

#groups-menu li{float:left;margin-right:15px;}
li.type-1 a.a{color:#1EA7E7;}
li.type-2 a.a{    color: #47C937;}

#count-views {
	background: #EEE;
	padding: 1px 5px;
	color: #444;
	border: 1px solid #AAA;
	font-size: 8px;
	position: relative;
	top: -2.7px;
}
</style>
<?php #var_dump($data); ?>
<div id="red-content">

	<div class="clearfix" id="groups-header">
		<div class="l" style="width:700px">
		<ul id="groups-menu">
			<?php if ($data['status']['permission']['post'] && $data['login'] && 
			in_array($data['user']['role'], $data['status']['permission']['users'])): ?>
				<li><a class="a" href="/post/any?id=<?php echo $_GET['id'] ?>">Post</a></li>
			<?php endif ?>

			<?php if ($data['status']['permission']['request'] && $data['login'] && 
			in_array($data['user']['role'], $data['status']['permission']['users'])): ?>
				<li><a class="a" href="/post/request?id=<?php echo $_GET['id'] ?>">Permintaan</a></li>
			<?php endif ?>

			<?php if ($data['status']['permission']['offer'] && $data['login'] && 
			in_array($data['user']['role'], $data['status']['permission']['users'])): ?>
				<li><a class="a" href="/post/offer?id=<?php echo $_GET['id'] ?>">Penawaran</a></li>
			<?php endif ?>

			<?php if (!$data['login']): ?>
				<li><a class="a" href="/login">Masuk untuk posting</a></li>
			<?php endif ?>
		</ul>

		</div>
		<div class="r"><?php echo $data['info']['name']; ?></div>
	</div>

	<div class="clearfix" id="groups-content">

		<?php
			$data['pagination']->createHtml(array(
				'data-pjax' => '#groups-content'
			));
		?>

		<div style="padding: 5px 0pt 0pt; width: 700px;" class="l">

		<?php if ($data['status']['status'] === 1): ?>
			<ul>
			<?php foreach ($data['posts'] as $post): ?>
				<?php

				if (strlen($post['title']) > 60) {
					#var_dump(strlen($post['title']));
					$post['title'] = substr($post['title'], 0, 60) . '(...)';
				}			

				echo '<li class="type-'.$post['status'].' clearfix">';
				#var_dump($post['count_reply']);

				echo '<div class="l" style="margin-right: 5px;">';
				echo '<span class="c" id="count-views">'.$post['count_views'].'</span> ';

				if ($post['status'] == 2) {
					echo "<span>offer</span> ";
				}

				echo '</div><div style="word-wrap: break-word; width: 630px;" class="l">';

				echo '<a data-pjax="#rr-2" class="a" title="'.$post['title'].'" href="post?id='.$post['PID'].'">'.$post['title'].'</a> 
				<i>by</i> <a class="u"href="'.$post['username'].'">'.$post['name'].'</a>';

				echo "</div>";

				echo "</li>";


				?>
			<?php endforeach ?>
			</ul>
		<?php endif ?>

		</div>
		<div style="width: 250px; padding: 5px;" class="r">
			<div style="padding-bottom: 5px;"><?php echo $data['info']['description']; ?></div>

			<?php if (!$data['login']): ?>
				<div><a class="a" href="/login">Masuk untuk Mengikuti <?php echo $data['info']['name']; ?></a></div>
			<?php endif ?>

			<?php if ($data['login']): ?>
					<?php if (!$data['follow']): ?>
						<div><a class="a" href="/api/s/g/follow?id=<?php echo $_GET['id'] ?>">Ikuti <?php echo $data['info']['name']; ?></a></div>
					<?php endif ?>

					<?php if ($data['follow']): ?>
						<div><a class="a" href="/api/s/g/unfollow?id=<?php echo $_GET['id'] ?>">Tidak ikuti <?php echo $data['info']['name']; ?></a></div>
					<?php endif ?>				
			<?php endif ?>
		</div>
	</div>

</div>
<?php $data['pagination']->creatHtmlInfo(); ?>