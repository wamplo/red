<?php
$data['post']['fulltitle'] = $data['post']['title'];
if (strlen($data['post']['title']) > 60) {
	#var_dump(strlen($post['title']));
	$data['post']['title'] = substr($data['post']['title'], 0, 60) . '(...)';
}

?>
<div class="clearfix" id="red-content">
	<div class="clearfix" id="post-header">
		<div class="l" style="width:700px">
			<ul>
				<li><b><?php echo $data['post']['title']; ?></b></li>
			</ul>
		</div>
		<div class="r"><a data-pjax="#rr-2" href="<?php echo $data['post']['username']; ?>" class="u"><?php echo $data['post']['name']; ?></a></div>
	</div>

	<?php if ($data['login'] == $data['post']['post_UID']) : ?>
		<div class="clearfix" id="post-menu">
			<ul class="l clearfix">
				<li class="l"><a href="/post/edit?id=<?php echo $_GET['id']; ?>">Edit</a></li>
			</ul>
			<ul class="r">
				
				<?php if (strtotime($data['post']['time_bump']) < strtotime('-1 Hour')): ?>
					<li class="l"><a href="/post/bump?id=<?php echo $_GET['id']; ?>">Bump</a></li>
				<?php endif ?>
				<li class="l"><a href="/post/delete?id=<?php echo $_GET['id']; ?>">x</a></li>
			</ul>
		</div>
	<?php endif ?>

	<!-- START CONTENT -->
	<div class="clearfix blog-post">
		<h1 style="word-wrap: break-word;text-align: center;margin-bottom: 10px;"><a href="/post?id=<?php echo $_GET['id']; ?>"><?php echo $data['post']['fulltitle']; ?></a></h1>
		<?php echo $data['post']['content_html']; ?>
	</div>

	<!-- START CONTENT INFO -->
	<div id="content-meta">
		<?php if ($data['post']['time_create'] !== $data['post']['time_update']): ?>
			<?php echo 'Last edited on ' . $data['post']['time_update']; ?>
		<?php endif ?>

	</div>

	<!-- START COMMENT -->
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


		<?php if ($data['login']): ?>
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
		<?php endif ?>
		
		<ul>
		<?php foreach ($data['comments'] as $comment): ?>
			<?php 
			echo "<li class='comments clearfix' id='comment-".$comment['CID']."'>";
			echo "<div id='comment'>".$comment['comment_html']."</div>";
			echo "<div id='comment-meta'>";
			echo "<span id='comment-meta-name'><a class='u' href='/".$comment['username']."'>".$comment['name']."</a></span>";
			echo '<time datetime="'.$comment['timecreate'].'">July 17, 2008</time>';

			# DELETE LINK
			if ($data['login'] == $comment['comment_UID']) {
				echo "<span id='d'><a href='/api/c/del?id=".$comment['CID']."'>x</a></span>";
			}
			echo "</div>";
			echo "</li>";
			?>
		<?php endforeach ?>
		</ul>

	</div>
<!-- 
<style type="text/css">
#oracle-social-comments .comments {
    border-bottom: 1px solid #EEEEEE;
    padding: 2.5px 0;
}
</style>
	<div id="oracle-social-comments">
		<div id="tweet-boastful">

		</div>
	</div>
-->
	<!-- END COMMENT -->
</div>