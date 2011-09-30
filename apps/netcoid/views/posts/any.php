<div id="red-menu-dashboard">
</div>

<?php $data['validation']->getErrors(); ?>

<div class="clearfix" id="red-content">

	<div class="users-left50 l form" id="red-wmd"><?php $data['forms']->openForm('red-wmd'); ?>
		<ul>
			<li id="form-header"><h3><strong>Post</strong> <a style="font-size:12px;margin-left:10px" class="s" href="/<?php echo $data['username']; ?>">See rules</a></h3></li>

			<!-- TITLE -->
			<li class="form-child"><?php $data['forms']->textinput('title',l('title'), 
				array( 
					'data-error' => 'title Error',
					'class' => 't',
					'id'	=> 'wmd-title',
					'style' => 'width: 450px;'
				)); 
			?></li>

			<!-- MENU -->
			<div class="clearfix" id="wmd-button-bar"></div>
						
			<!-- INFORMATIONBOX -->
			<li class="form-child"><?php $data['forms']->textarea('content','Post', 
				array( 
					'data-error' => 'post error',
					'class' => 't',
					'id' => 'wmd-input',
					'style' => 'width: 450px; height: 500px;'
				)); 
			?></li>

			<li><input type="hidden" name="content_html" id="wmd-content-html" value=""/></li>
			<li class="form-button"><input type="submit" id="button" value="Post"></li>
		</ul>
	<?php $data['forms']->closeForm('red-wmd'); ?></div>	

	<div class="r users-right50">
		<h1 class="blog-post" id="wmd-title-preview"></h1>
		<p><i id="wmd-title-readmore-preview"></i></p>
		<div class="blog-post" id="wmd-preview"></div>
	</div>
</div>