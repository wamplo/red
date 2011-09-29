<div id="red-header">
	<div class="m" id="red-menu">
		<ul class="dz">

		<?php if ($data['sessions']->get('uid')): ?>
			<li id="be"><a data-pjax='#red-content' href="/dashboard"><?php $this->getIMG('netcoid','img/site/logo2.png'); ?></a></li>
			<li class="dt"><a data-pjax='#red-content' href="/mentions">Mentions</a></li>
			<li class="dt"><a data-pjax='#red-content' href="/messages">Pesan</a></li>
		<?php endif ?>

		<?php if (!$data['sessions']->get('uid')): ?>
			<li id="be"><a data-pjax='#red-content' href="/"><?php $this->getIMG('netcoid','img/site/logo2.png'); ?></a></li>
		<?php endif ?>
			
			<li class="dt"><a data-pjax='#red-content' href="/search">search</a></li>
		</ul>
		<ul class="ec">
			
			<?php if ($data['sessions']->get('uid')): ?>
			<li class="dt"><a data-pjax='#red-content' href="<?php echo '/'.$data['sessions']->get('username') ?>"><?php echo $data['sessions']->get('name') ?></a></li>
				<li class="dt"><a data-pjax='#red-content' href="/logout"><?php echo l('logout'); ?></a></li>
			<?php endif ?>

			<?php if (!$data['sessions']->get('uid')): ?>
				<li class="dt"><a data-pjax='#red-content' href="/login"><?php echo l('login'); ?></a></li>
			<?php endif ?>
		</ul>
	</div>
</div>