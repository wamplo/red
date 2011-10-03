<div id="red-side-menu">
	<ul>
		<ul>
			<li class="cn"><?php $this->href('/dashboard',l('home')); ?></li>
			<li class="cj"><?php $this->href('/edit/profile',l('Profiledata')); ?></li>
			<li class="bo"><?php $this->href('/edit/frontbox',l('informationbox')); ?></li>
			<li class="bw"><?php $this->href('/edit/connections',l('connectioncenter')); ?></li>
			<li class="cp"><?php $this->href('/edit/products',l('productlist')); ?></li>
			<li class="cp"><?php $this->href('/edit/products','List Post'); ?></li>
			<li class="br"><?php $this->href('/beta/insights',l('insights')); ?>
			<sup style="font-size: 10px;">beta</sup></li>
		</ul>
		<li><p id="users-menu-information">Beta*, status beta menunjukan bahwa fitur tersebut masih dalam tahap uji coba.</p></li>
		<li><p id="users-menu-information">
			<h4 style="margin-bottom: 6px;">Iklan</h4>
			<?php $this->getIMG('netcoid','img/Partners/live-positively.png'); ?>
			<span style="font-size: 10px;">Ayo buruan follow akun <a style="color: #5E96E3;" href="/cocacola">Coca Cola Indonesia</a> sekarang juga! dan dapatkan PROMOnya</span>
			</p>
		</li>
	</ul>
</div>