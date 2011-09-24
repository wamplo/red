<style type="text/css">
#profiles-header{
	border-bottom: 1px solid #DDD;
	padding: 5px 0;
}
.profile-content{
	margin-top: 10px;
}
#profiles-menu li{float:left;margin-right:15px;}
</style>
<?php #var_dump($data); ?>
<div id="red-content">
	<div class="o" id="profiles-header">
		<div class="dz" style="width:700px">
		<ul id="profiles-menu">
		
			<?php if ($data['login']): ?>
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

	<div class="blog-post o profile-content" id="css-<?php echo $data['user']['username']; ?>">
	
	<?php echo $data['user']['information_html']; ?>
	
	</div>
</div>