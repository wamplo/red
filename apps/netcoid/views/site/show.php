
<div id="red-content">
<h1><?php echo $data['posts']['title']; ?></h1>
<div class="blog-post">
<?php echo $data['posts']['content_html']; ?>
</div>

	<div id="comments">
		<?php if ($data['count']['COUNT(CID)'] == 0): ?>
		<div id="meta-comments">
			<h4><?php echo l('nocomments'); ?></h4>
		</div>
		<?php endif ?>

		<?php if ($data['count']['COUNT(CID)'] != 0): ?>		
		<div id="meta-comments">
			<h4>(<?php echo $data['count']['COUNT(CID)']; ?>) <?php echo l('comments') ?></h4>
		</div>
		<?php endif ?>

		<div id="post-comment">
			<?php $data['forms']->openForm('red-comment',array(
					'action' => '/api/c/set'
				)); ?>
				<ul>
					<li><?php $data['forms']->textarea('comment', l('addcomment'), array( 
							  'cols' => '135',
							  'rows' => '3')); ?></li>
				</ul>
				<p><input type="submit" value="Kirim" name="insert" id="button"></p>

			<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>"/>
			<?php $data['forms']->closeForm('red-comment'); ?>					
		</div>

		<?php foreach ($data['comments'] as $comment): ?>
			<?php 
			echo "<li class='comments' id='comment-".$comment['CID']."'>";
			echo "<span id='comment'>".$comment['comment']."</span>";
			echo "<span id='name'><span id='says'>says</span> <a href='/".$comment['username']."'>".$comment['name']."</a></span>";
			echo "</li>";
			?>
		<?php endforeach ?>

</div>