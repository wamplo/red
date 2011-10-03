<?php $data['validation']->getErrors(); ?>
<div class="clearfix" id="red-content">
	<div class="ef" style="width: 450px;">
		<?php $data['forms']->openForm('red-post-new'); ?>
		 	<div class="wmd-panel">
			<h3>Permintaan Baru</h3>
			<ul class="clearfix">
				<li><?php $data['forms']->textinput('title',l('title'), array( 'data-error' => l('news_title_error'), 'class' => 't', 'id' => 'wmd-title', 'style' => 'width:420px')); ?></li>
				<li>
				<label for="tag">Group</label>
				<div style="margin-left: 5px;">
				<select style="width:443px;" class="red-ajax-select" name="tag" >
				<?php foreach ($data['groups'] as $group): ?>
				<?php 
					$tags = explode(",", $group['tags']);
					echo '<optgroup label="'.$group['name'].'">';
					foreach ($tags as $tag) {
						if ($tag != 'Others') {
							echo '<option value="'.$tag.'">'.$tag.'</option>';
						}
						if ($tag == 'Others') {
							echo '<option selected value="'.$tag.'">'.$tag.'</option>';
						}
					}
				?>
				<?php endforeach ?>
				</select>
				</div>
				</li>
				<div class="clearfix" id="wmd-button-bar"></div>
				<li><?php $data['forms']->textarea('content',l('article'), array( 'data-error' => l('news_content_empty'), 'class' => 't', 'id' => 'wmd-input', 'style' => 'width:420px;height:500px')); ?></li>
				<li><input type="hidden" name="content_html" id="wmd-content-html" value=""/></li>
			</ul>
			</div> <!-- END WMD -->
			<p style="text-align: center; margin-top: 10px;"><input type="submit" id="button" name="register" value="Post" class="a cupid-green"></p>
		<?php $data['forms']->closeForm('red-post-new'); ?>
	</div>
	<div class="ei" style="width: 450px;">
		<h3>Preview</h3>
		<h1 class="blog-post" id="wmd-title-preview"></h1>
		<div class="blog-post" id="wmd-preview"></div>
	</div>
</div>