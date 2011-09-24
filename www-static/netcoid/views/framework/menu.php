<div id="red-header">
	<div class="o" id="red-menu">
		<ul class="dz">

		<?php if ($data['sessions']->get('uid')): ?>
			<li id="bf"><a href="/dashboard"><?php $this->getIMG('netcoid','img/site/logo2.png'); ?></a></li>
			<li class="dt"><?php $this->href('/mentions','Mentions'); ?></li>
		<?php endif ?>

		<?php if (!$data['sessions']->get('uid')): ?>
			<li id="bf"><a href="/"><?php $this->getIMG('netcoid','img/site/logo2.png'); ?></a></li>
		<?php endif ?>
			
			<li class="dt"><?php $this->href('/search',l('search')); ?></li>
		</ul>
		<ul class="ec">
			
			<?php if ($data['sessions']->get('uid')): ?>
				<li class="dt"><?php $this->href('/'.$data['sessions']->get('username'),$data['sessions']->get('name')); ?></li>
				<li class="dt"><?php $this->href('/logout',l('logout')); ?></li>
			<?php endif ?>

			<?php if (!$data['sessions']->get('uid')): ?>
				<li class="dt"><?php $this->href('/login',l('login')); ?></li>
			<?php endif ?>
		</ul>
	</div>
</div>