	<div class="clearfix" id="profiles-header">
		<div class="ds" style="width:700px">
		<ul id="profiles-menu">

			<?php if ($data['login'] == $data['user']['uid']): ?>
				<li><a data-pjax="#rr-2" class="u" href="/edit/profile">Edit Profil Anda</a></li>	
			<?php endif ?>


			<?php if ($data['login'] && $data['login'] != $data['user']['uid']): ?>
				<?php if (empty($data['follow'])): ?>
					<li><a class="dc" href="/api/s/u/follow?id=<?php echo $data['user']['uid']; ?>">Ikuti</a></li>
				<?php endif ?>

				<?php if (!empty($data['follow'])): ?>
					<li><a class="dc" href="/api/s/u/unfollow?id=<?php echo $data['user']['uid']; ?>">Tidak Ikuti</a></li>
				<?php endif ?>
			<?php endif ?>


			<?php if ($data['login']): ?>
				<?php if ($data['login'] != $data['user']['uid']): ?>
					<li><a data-pjax="#rr-2" class="dc" href="/messages/send?id=<?php echo $data['user']['uid']; ?>">Kirim pesan</a></li>	
				<?php endif ?>				
			<?php endif ?>


			<?php if (!$data['login']): ?>
				<li><a data-pjax="#rr-2" class="dc" href="/login">Masuk untuk mengikuti</a></li>
			<?php endif ?>

			<li><a data-pjax="#rr-2-1" class="dc" href="/<?php echo $data['user']['username']; ?>/posts">Posts</a></li>
			<li><a data-pjax="#rr-2-1" class="dc" href="/<?php echo $data['user']['username']; ?>/offers">Penawaran</a></li>
			<li><a data-pjax="#rr-2-1" class="dc" href="/<?php echo $data['user']['username']; ?>/requests">Permintaan</a></li>
			
		</ul>
		</div>
		<div class="dv"><a data-pjax="#rr-2-1" class="u" href="/<?php echo $data['user']['username']; ?>"><?php echo $data['user']['name'];  ?></a></div>
	</div>