<div id="red-content">

<div class="di" id="red-x"><?php $data['forms']->openForm('red-x'); ?>
	<ul>
		<li id="form-header"><h3><strong>Kirim Pesan</strong></h3></li>

		<!-- USERNAME -->
		<li class="form-child"><?php $data['forms']->textinput('title',l('title'), 
			array( 
				'data-error' => l('register_username_error'),
				'class' => 't',
				'id' => 'input-title',
				'style' => 'width: 450px;'
			)); 
		?></li>

		<!-- TEXTAREA -->
		<li class="form-child"><?php $data['forms']->textarea('message',l('message'), 
			array( 
				'data-error' => l('register_username_error'),
				'class' => 't',
				'id' => 'input-title',
				'style' => 'width: 450px; height: 250px;'
			)); 
		?></li>

		<p class="form-button"><input type="submit" id="button" name="register" value="Send"></p>
	</ul>
<?php $data['forms']->closeForm('red-x'); ?></div>


</div>