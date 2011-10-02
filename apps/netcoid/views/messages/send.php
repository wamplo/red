<div class="clearfix" id="red-content">

<div style="width: 475px; border: 1px solid rgb(238, 238, 238); margin: 20px auto 0pt; padding: 10px 15px;" id="form-red-wmd" class="form"><?php $data['forms']->openForm('red-wmd'); ?>
	<ul>
		<li id="form-header"><h3><strong>Kirim Pesan</strong></h3></li>

		<!-- USERNAME -->
		<li class="form-child"><?php $data['forms']->textinput('subject','Subject', 
			array( 
				'data-error' => l('register_username_error'),
				'class' => 't',
				'id' => 'wmd-title',
				'style' => 'width: 450px;'
			)); 
		?></li>

		<!-- MENU -->
		<div class="clearfix" id="wmd-button-bar"></div>

		<!-- TEXTAREA -->
		<li class="form-child"><?php $data['forms']->textarea('message',l('message'), 
			array( 
				'data-error' => l('register_username_error'),
				'id' => 'wmd-input',
				'style' => 'width: 450px; height: 250px;'
			)); 
		?></li>

		<p class="form-button"><input type="submit" id="button" name="register" value="Send"></p>
	</ul>
<?php $data['forms']->closeForm('red-wmd'); ?></div>
</div>