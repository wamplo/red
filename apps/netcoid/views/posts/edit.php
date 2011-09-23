
<style type="text/css">
.introduction{}
#red-menu-dashboard {
    background: none repeat scroll 0 0 #EEEEEE;
    height: 50px;
}
.users-right50{width:480px;}
.users-left50{width:480px;}
#howto-informationbox{    background: none repeat scroll 0 0 #8DD7E4;
    border: 1px solid #70BFCD;
    margin: 5px;
    padding: 5px;}
</style>
<div id="red-menu-dashboard">
</div>

<?php $data['validation']->getErrors(); ?>

<div class="clearfix" id="red-content">

	<div class="users-left50 l form" id="red-wmd"><?php $data['forms']->openForm('red-wmd'); ?>
		<ul>
			<li id="form-header"><h3><strong>Edit</strong> <a style="font-size:12px;margin-left:10px" class="s" href="/<?php echo $data['username']; ?>">See rules</a></h3></li>

			<!-- TITLE -->
			<li class="form-child"><?php $data['forms']->textinput('title',l('title'), 
				array( 
					'data-error' => 'title Error',
					'class' => 't',
					'id'	=> 'wmd-title',
					'style' => 'width: 450px;',
					'value'	=> $data['post']['title']
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
					'style' => 'width: 450px; height: 500px;',
					'value' => $data['post']['content']
				)); 
			?></li>

			<li><input type="hidden" name="content_html" id="wmd-content-html" value=""/></li>
			<li class="form-button"><input type="submit" id="button" value="Edit"></li>
		</ul>
	<?php $data['forms']->closeForm('red-wmd'); ?></div>	

	<div class="r users-right50">
		<h1 class="blog-post" id="wmd-title-preview"><?php echo $data['post']['title']; ?></h1>
		<div class="blog-post" id="wmd-preview"></div>
	</div>
</div>