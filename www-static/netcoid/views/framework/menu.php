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
		<ul class="dr">

		<?php if ($data['sessions']->get('uid')): ?>
			<li id="az"><a data-pjax='#rr-2' href="/dashboard"><?php $this->getIMG('netcoid','img/site/logo2.png'); ?></a></li>
			<?php #var_dump($data); ?>
			<?php if ($data['countmentions']['countmention'] > 0): ?>
				<li class="dl"><a data-pjax='#rr-2' href="/mentions">Mentions *</a></li>
			<?php else: ?>
				<li class="dl"><a data-pjax='#rr-2' href="/mentions">Mentions</a></li>
			<?php endif ?>
			<?php if ($data['countmessages']['countmessage'] > 0): ?>	
				<li class="dl"><a data-pjax='#rr-2' href="/messages">Pesan *</a></a></li>
			<?php else: ?>		
				<li class="dl"><a data-pjax='#rr-2' href="/messages">Pesan</a></a></li>
			<?php endif ?>
		<?php endif ?>

		<?php if (!$data['sessions']->get('uid')): ?>
			<li id="az"><a data-pjax='#rr-2' href="/"><?php $this->getIMG('netcoid','img/site/logo2.png'); ?></a></li>
		<?php endif ?>
			
			<li class="dl"><a data-pjax='#rr-2' href="/search">Search</a></li>
		</ul>
		<ul class="du">
			
			<?php if ($data['sessions']->get('uid')): ?>
			<li class="dl"><a data-pjax='#rr-2' href="<?php echo '/'.$data['sessions']->get('username') ?>"><?php echo $data['sessions']->get('name') ?></a></li>
				<li class="dl"><a href="/logout"><?php echo l('logout'); ?></a></li>
			<?php endif ?>

			<?php if (!$data['sessions']->get('uid')): ?>
				<li class="dl"><a data-pjax='#rr-2' href="/login"><?php echo l('login'); ?></a></li>
			<?php endif ?>
		</ul>
	</div>
</div>