<style type="text/css">
#mention-count {
    color: #820000;
    padding: 2px 5px;
    text-shadow: none;
}

#messages-count {
    color: #820000;
    padding: 2px 5px;
    text-shadow: none;
}
</style>

<div id="red-header">
	<div class="clearfix" id="red-menu">
		<ul class="dq">

		<?php if ($data['sessions']->get('uid')): ?>
			<li id="bb"><a data-pjax='#rr-2' href="/dashboard"><?php $this->getIMG('netcoid','img/site/logo2.png'); ?></a></li>
			<?php #var_dump($data); ?>
				<li class="dk"><a data-pjax='#rr-2' href="/admin/accounts">Accounts</a></li>
				<li class="dk"><a data-pjax='#rr-2' href="/search">Search</a></li>
		<?php endif ?>

		<?php if (!$data['sessions']->get('uid')): ?>
			<li id="bb"><a data-pjax='#rr-2' href="/"><?php $this->getIMG('netcoid','img/site/logo2.png'); ?></a></li>
		<?php endif ?>
		</ul>
		<ul class="dt">
			
			<?php if ($data['sessions']->get('uid')): ?>
			<li class="dk"><a data-pjax='#rr-2' href="<?php echo '/'.$data['sessions']->get('username') ?>"><?php echo $data['sessions']->get('name') ?></a></li>
				<li class="dk"><a href="/logout"><?php echo l('logout'); ?></a></li>
			<?php endif ?>

			<?php if (!$data['sessions']->get('uid')): ?>
				<li class="dk"><a data-pjax='#rr-2' href="/login"><?php echo l('login'); ?></a></li>
			<?php endif ?>
		</ul>
	</div>
</div>