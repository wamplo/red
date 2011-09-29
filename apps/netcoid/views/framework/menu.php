<div id="red-header">
	<div class="clearfix" id="red-menu">
		<ul class="l">

		<?php if ($data['sessions']->get('uid')): ?>
			<li id="logo"><a data-pjax='#rr-2' href="/dashboard"><?php $this->getIMG('netcoid','img/site/logo2.png'); ?></a></li>
			<li class="t"><a data-pjax='#rr-2' href="/mentions">Mentions</a></li>
			<li class="t"><a data-pjax='#rr-2' href="/messages">Pesan</a></li>
		<?php endif ?>

		<?php if (!$data['sessions']->get('uid')): ?>
			<li id="logo"><a data-pjax='#rr-2' href="/"><?php $this->getIMG('netcoid','img/site/logo2.png'); ?></a></li>
		<?php endif ?>
			
			<li class="t"><a data-pjax='#rr-2' href="/search">search</a></li>
		</ul>
		<ul class="r">
			
			<?php if ($data['sessions']->get('uid')): ?>
			<li class="t"><a data-pjax='#rr-2' href="<?php echo '/'.$data['sessions']->get('username') ?>"><?php echo $data['sessions']->get('name') ?></a></li>
				<li class="t"><a data-pjax='#rr-2' href="/logout"><?php echo l('logout'); ?></a></li>
			<?php endif ?>

			<?php if (!$data['sessions']->get('uid')): ?>
				<li class="t"><a data-pjax='#rr-2' href="/login"><?php echo l('login'); ?></a></li>
			<?php endif ?>
		</ul>
	</div>
</div>