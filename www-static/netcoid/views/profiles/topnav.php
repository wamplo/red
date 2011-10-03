<?php #var_dump($data); ?>

	<div class="clearfix" id="profiles-header">
		<div class="ef" style="width:700px">
		<ul id="profiles-menu">

			<?php if ($data['login'] == $data['user']['uid']): ?>
				<li><a data-pjax="#rr-2" class="u" href="/edit/profile">Edit Profil Anda</a></li>	
			<?php endif ?>


			<?php if ($data['login'] && $data['login'] != $data['user']['uid']): ?>
				<?php if (empty($data['follow'])): ?>
					<li><a class="a" href="/api/s/u/follow?id=<?php echo $data['user']['uid']; ?>">Ikuti</a></li>
				<?php endif ?>

				<?php if (!empty($data['follow'])): ?>
					<li><a class="a" href="/api/s/u/unfollow?id=<?php echo $data['user']['uid']; ?>">Tidak Ikuti</a></li>
				<?php endif ?>
			<?php endif ?>


			<?php if ($data['login']): ?>
				<?php if ($data['login'] != $data['user']['uid']): ?>
					<li><a data-pjax="#rr-2" class="a" href="/messages/send?id=<?php echo $data['user']['uid']; ?>">Kirim pesan</a></li>	
				<?php endif ?>				
			<?php endif ?>


			<?php if (!$data['login']): ?>
				<li><a data-pjax="#rr-2" class="a" href="/login">Masuk untuk mengikuti</a></li>
			<?php endif ?>

			<?php if (!empty($data['ispost0'])): ?>
				<li><a data-pjax="#rr-2-1" class="a" href="/<?php echo $data['user']['username']; ?>/posts">Posts</a></li>
			<?php endif ?>

			<?php if (!empty($data['ispost1'])): ?>
				<li><a data-pjax="#rr-2-1" class="a" href="/<?php echo $data['user']['username']; ?>/offers">Penawaran</a></li>
			<?php endif ?>

			<?php if (!empty($data['ispost2'])): ?>
				<li><a data-pjax="#rr-2-1" class="a" href="/<?php echo $data['user']['username']; ?>/requests">Permintaan</a></li>
			<?php endif ?>

		</ul>
		</div>
		<div class="ei"><a data-pjax="#rr-2-1" class="u" href="/<?php echo $data['user']['username']; ?>"><?php echo $data['user']['name'];  ?></a></div>
	</div>