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
		<ul class="l">

		<?php if ($data['sessions']->get('uid')): ?>
			<li id="logo"><a data-pjax='#rr-2' href="/dashboard"><?php $this->getIMG('netcoid','img/site/logo2.png'); ?></a></li>
			<?php #var_dump($data); ?>
			<?php if ($data['countmentions']['countmention'] > 0): ?>
				<li class="t"><a data-pjax='#rr-2' href="/mentions">Mentions *</a></li>
			<?php else: ?>
				<li class="t"><a data-pjax='#rr-2' href="/mentions">Mentions</a></li>
			<?php endif ?>
			<?php if ($data['countmessages']['countmessage'] > 0): ?>	
				<li class="t"><a data-pjax='#rr-2' href="/messages">Pesan *</a></a></li>
			<?php else: ?>		
				<li class="t"><a data-pjax='#rr-2' href="/messages">Pesan</a></a></li>
			<?php endif ?>
		<?php endif ?>

		<?php if (!$data['sessions']->get('uid')): ?>
			<li id="logo"><a data-pjax='#rr-2' href="/"><?php $this->getIMG('netcoid','img/site/logo2.png'); ?></a></li>
		<?php endif ?>
			
			<li class="t"><a data-pjax='#rr-2' href="/search">Search</a></li>
		</ul>
		<ul class="r">
			
			<?php if ($data['sessions']->get('uid')): ?>
			<li class="t"><a data-pjax='#rr-2' href="<?php echo '/'.$data['sessions']->get('username') ?>"><?php echo $data['sessions']->get('name') ?></a></li>
				<li class="t"><a href="/logout"><?php echo l('logout'); ?></a></li>
			<?php endif ?>

			<?php if (!$data['sessions']->get('uid')): ?>
				<li class="t"><a data-pjax='#rr-2' href="/login"><?php echo l('login'); ?></a></li>
			<?php endif ?>
		</ul>
	</div>
</div>

<?php if ($data['sessions']->get('uid')): ?>
<div style="height: 30px; background: none repeat scroll 0pt 0pt rgb(255, 255, 255); border-bottom: 1px solid rgb(231, 231, 231); color: rgb(68, 68, 68);"><p style="margin: 0pt auto; width: 960px; text-align: center; line-height: 29px;">
Situs netcoid.com masih dalam <i>perkembangan</i>, <b>data dapat hilang tampa sepengetahuan</b>, silahkan ke situs lama di <a class="a" title="Netcoid - Jejaring Bisnis Indonesia" href="https://www.networks.co.id">www.networks.co.id</a>
</p></div>
<?php endif ?>
