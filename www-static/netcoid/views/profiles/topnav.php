	<div class="m" id="profiles-header">
		<div class="dw" style="width:700px">
		<ul id="profiles-menu">

			<?php if ($data['login'] == $data['user']['uid']): ?>
				<li><a data-pjax="#rr-2" class="dq" href="/edit/profile">Edit Profil Anda</a></li>	
			<?php endif ?>


			<?php if ($data['login'] && $data['login'] != $data['user']['uid']): ?>
				<?php if (empty($data['follow'])): ?>
					<li><a class="dg" href="/api/s/u/follow?id=<?php echo $data['user']['uid']; ?>">Ikuti</a></li>
				<?php endif ?>

				<?php if (!empty($data['follow'])): ?>
					<li><a class="dg" href="/api/s/u/unfollow?id=<?php echo $data['user']['uid']; ?>">Tidak Ikuti</a></li>
				<?php endif ?>
			<?php endif ?>


			<?php if ($data['login']): ?>
				<?php if ($data['login'] != $data['user']['uid']): ?>
					<li><a data-pjax="#rr-2" class="dg" href="/send/message?id=<?php echo $data['user']['uid']; ?>">Kirim pesan</a></li>	
				<?php endif ?>				
			<?php endif ?>


			<?php if (!$data['login']): ?>
				<li><a data-pjax="#rr-2" class="dg" href="/login">Masuk untuk mengikuti</a></li>
			<?php endif ?>

			<li><a data-pjax="#rr-2-1" class="dg" href="/<?php echo $data['user']['username']; ?>/posts">Posts</a></li>
			<li><a data-pjax="#rr-2-1" class="dg" href="/<?php echo $data['user']['username']; ?>/offers">Penawaran</a></li>
			<li><a data-pjax="#rr-2-1" class="dg" href="/<?php echo $data['user']['username']; ?>/requests">Permintaan</a></li>
			
		</ul>
		</div>
		<div class="dz"><a data-pjax="#rr-2-1" class="dq" href="/<?php echo $data['user']['username']; ?>"><?php echo $data['user']['name'];  ?></a></div>
	</div>