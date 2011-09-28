<div id="red-header">
	<div class="clearfix" id="red-menu">
		<ul class="l">

		<?php if ($data['sessions']->get('uid')): ?>
			<li id="logo"><a href="/dashboard"><?php $this->getIMG('netcoid','img/site/logo2.png'); ?></a></li>
			<li class="t"><?php $this->href('/mentions','Mentions'); ?></li>
			<li class="t"><?php $this->href('/messages','Pesan'); ?></li>
		<?php endif ?>

		<?php if (!$data['sessions']->get('uid')): ?>
			<li id="logo"><a href="/"><?php $this->getIMG('netcoid','img/site/logo2.png'); ?></a></li>
		<?php endif ?>
			
			<li class="t"><?php $this->href('/search',l('search')); ?></li>
		</ul>
		<ul class="r">
			
			<?php if ($data['sessions']->get('uid')): ?>
				<li class="t"><?php $this->href('/'.$data['sessions']->get('username'),$data['sessions']->get('name')); ?></li>
				<li class="t"><?php $this->href('/logout',l('logout')); ?></li>
			<?php endif ?>

			<?php if (!$data['sessions']->get('uid')): ?>
				<li class="t"><?php $this->href('/login',l('login')); ?></li>
			<?php endif ?>
		</ul>
	</div>
</div>