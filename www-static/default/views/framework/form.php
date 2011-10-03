<div class="dr" id="red-x"><?php $data['forms']->openForm('red-x'); ?>
	<ul>
		<li id="form-header"><h3><strong>Masuk</strong></h3></li>

		<!-- USERNAME -->
		<li class="form-child"><?php $data['forms']->textinput('username',l('informationbox'), 
			array( 
				'data-error' => l('register_username_error'),
				'class' => 't',
				'id' => 'input-username'
			)); 
		?></li>

		<p class="form-button"><input type="submit" id="button" name="register" value="Login"></p>
	</ul>
<?php $data['forms']->closeForm('red-x'); ?></div>
