<div class="clearfix" id="red-content">
	<div class="dr" style="width: 715px;">

	<style type="text/css">
	#type-news{
    font-weight: bold;
	}
#type-sell {
    font-weight: bold;
}
#type-buy {
    font-weight: bold;
}
	#as li {
	    margin-bottom: 5px;
	}
	#ab{text-decoration:italic;}
	</style>
	<ul id="as">
	<?php 

	foreach ($data['posts'] as $posts) {
		echo '<li class="clearfix">';

		if ($posts['status'] == 0) {
			echo '<div class="dr" style="margin-right: 10px;"><span id="type-news">Artikel</span></div>';
		}

		if ($posts['status'] == 1) {
			echo '<div class="dr" style="margin-right: 10px;"><span id="type-sell">Penawaran</span></div>';
		}

		if ($posts['status'] == 2) {
			echo '<div class="dr" style="margin-right: 10px;"><span id="type-buy">Permintaan</span></div>';
		}

		echo '<div class="dr" style="width: 610px;"><a class="a" href="post?id='.$posts['PID'].'">'.$posts['title'].'</a> oleh <a href="'.$posts['username'].'" class="u">@'.$posts['name'].'</a> di <i><span id="ab" class="gid-'.$posts['post_GID'].'">'.$posts['group'].'</span></i></div></li>';
	}
	
	?>
	</ul>
	</div>
	<div class="du" style="width: 245px;">
		<?php $data['forms']->openForm('red-register',array('action' => '/register')); ?>
			<h3><strong>Pendaftaran</strong></h3>
			<i>Hello!, are you registered?</i>
			<ul class="clearfix">
				<li><?php $data['forms']->textinput('username',l('username'), array( 'data-error' => l('register_username_error'), 'class' => 't', 'id' => 'input-username')); ?><p id="red-register-information">http://networks.co.id/<span id="url-suffix" style="word-wrap: break-word;" /></span></p></li>
				<li><?php $data['forms']->password('password',l('password'), array( 'data-error' => l('register_password_empty'), 'class' => 't','id' => 'input-password')); ?><p id="red-register-information">"Kata Sandi Yang Kuat"</p></li>
				<hr>
				<li><?php $data['forms']->textinput('name',l('name'), array( 'data-error' => l('register_name_error'), 'class' => 't','id' => 'input-name')); ?><p id="red-register-information">Jika berawalan PT atau CV akan kami kontak paling lambat 2x24 untuk verifikasi</p></li>
				<li><?php $data['forms']->textinput('phone',l('phone'), array( 'data-error' => l('register_phone_error'), 'class' => 't','id' => 'input-phone')); ?><p id="red-register-information">format: <code style="background: none repeat scroll 0pt 0pt rgb(254, 255, 203);">0123-1234567</code> atau <code style="background: none repeat scroll 0pt 0pt rgb(254, 255, 203);">08123456789</code></p></li>
			</ul>
			<hr>
			<p style="padding: 5px;">Anda Menyetujui <a target="_blank" href="/terms" style="color: rgb(211, 46, 46);">Kebijakan Layanan</a> dan <a target="_blank" href="/privacy" style="color: rgb(211, 46, 46);">Kebijakan Privasi</a> Netcoid.</p>
			<hr>
			<p style="text-align: center;"><input class="a cupid-green" type="submit" value="Setuju &amp; Registrasi" name="register" id="button"></p>
		<?php $data['forms']->closeForm('red-register'); ?>
	</div>
</div>