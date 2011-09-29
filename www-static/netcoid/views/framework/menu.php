<div id="red-header">
	<div class="m" id="red-menu">
		<ul class="dz">

		<?php if ($data['sessions']->get('uid')): ?>
			<li id="be"><a data-pjax='#rr-2' href="/dashboard"><?php $this->getIMG('netcoid','img/site/logo2.png'); ?></a></li>
			<li class="dt"><a data-pjax='#rr-2' href="/mentions">Mentions</a></li>
			<li class="dt"><a data-pjax='#rr-2' href="/messages">Pesan</a></li>
		<?php endif ?>

		<?php if (!$data['sessions']->get('uid')): ?>
			<li id="be"><a data-pjax='#rr-2' href="/"><?php $this->getIMG('netcoid','img/site/logo2.png'); ?></a></li>
		<?php endif ?>
			
			<li class="dt"><a data-pjax='#rr-2' href="/search">search</a></li>
		</ul>
		<ul class="ec">
			
			<?php if ($data['sessions']->get('uid')): ?>
			<li class="dt"><a data-pjax='#rr-2' href="<?php echo '/'.$data['sessions']->get('username') ?>"><?php echo $data['sessions']->get('name') ?></a></li>
				<li class="dt"><a data-pjax='#rr-2' href="/logout"><?php echo l('logout'); ?></a></li>
			<?php endif ?>

			<?php if (!$data['sessions']->get('uid')): ?>
				<li class="dt"><a data-pjax='#rr-2' href="/login"><?php echo l('login'); ?></a></li>
			<?php endif ?>
		</ul>
	</div>
</div>