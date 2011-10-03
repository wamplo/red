
<?php $data['validation']->getErrors(); ?>
<div class="clearfix" id="red-content">
	<div class="dr" style="width: 450px;">
		<?php $data['forms']->openForm('red-groups-new'); ?>
		 	<div class="wmd-panel">
			<h3>New Post</h3>
			<ul class="clearfix">
				<li><?php $data['forms']->textinput('name',l('group_name'), array( 'data-error' => l('group_name_error'), 'class' => 't', 'id' => 'wmd-name', 'style' => 'width:420px')); ?></li>
				<li><?php $data['forms']->textinput('parent','Parent', array( 'data-error' => l('group_description_html_error'), 'class' => 't', 'id' => 'wmd-tag', 'style' => 'width:420px')); ?></li>
				<div class="clearfix" id="wmd-button-bar"></div>
				<li><?php $data['forms']->textarea('description',l('description'), array( 'data-error' => l('group_description_error'), 'class' => 't', 'id' => 'wmd-input', 'style' => 'width:420px;height:500px')); ?></li>
				<li><?php $data['forms']->textinput('status','Status', array( 'data-error' => l('group_status_error'), 'class' => 't', 'style' => 'width:420px')); ?></li>
				<li><input type="hidden" name="description_html" id="wmd-content-html" value=""/></li>
				<li>
					<p>0 = category</p>
					<p>1 = groups admin post ( trade + posts )</p>
					<p>2 = groups all post ( trade + posts )</p>
					<p>3 = groups all post ( posts )</p>
					<p>4 = groups all post ( trade )</p>
					<p>5 = groups disabled</p>
				</li>
			</ul>
				
			</div> <!-- END WMD -->
			<p style="text-align: center; margin-top: 10px;"><input type="submit" id="button" name="register" value="Post" class="a cupid-green"></p>
		<?php $data['forms']->closeForm('red-groups-new'); ?>
	</div>
	<div class="du" style="width: 450px;">
		<h3>Preview</h3>
		<h1 class="blog-post" id="wmd-tag-preview"></h1>
		<h2 class="blog-post" id="wmd-name-preview"></h2>
		<div class="blog-post" id="wmd-preview"></div>
	</div>
</div>