	<?php $data['validation']->getErrors(); ?>
	<div id="red-error-box"></div>
	<!-- CONTENT START -->
	<div class="m bz" id="red-content">
		<div id="red-login">
		<?php $data['forms']->openForm('red-login'); ?>
			<h3><strong>Masuk</strong></h3>
			<ul class="m">
				<li><?php $data['forms']->textinput('username',l('username'), array( 'data-error' => l('register_username_error'), 'class' => 't', 'id' => 'input-username')); ?></li>
				<li><?php $data['forms']->password('password',l('password'), array( 'data-error' => l('register_password_empty'), 'class' => 't', 'id' => 'input-password')); ?></li>
			</ul>
			<p style="margin-top: 5px;padding:5px"><?php $this->getIMG('netcoid','img/site/godaddy-ssl.gif') ?></p>
			<p style="text-align: center; margin-top: 10px;"><input type="submit" id="button" name="register" value="Login" class="b cupid-green"></p>
		<?php $data['forms']->closeForm('red-login'); ?>
		</div>
	</div>
	<!-- CONTENT END -->