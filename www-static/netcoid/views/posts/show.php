<?php #var_dump($data); ?>
<div class="m" id="red-content">
	<div class="m" id="post-header">
		<div class="dv" style="width:700px">
			<ul>
				<li><b><?php echo $data['post']['title']; ?></b></li>
			</ul>
		</div>
		<div class="dy"><a href="<?php echo $data['post']['username']; ?>" class="dp"><?php echo $data['post']['name']; ?></a></div>
	</div>

	<?php if ($data['login'] == $data['post']['post_UID']) : ?>
		<div class="m" id="post-menu">
			<ul class="dv m">
				<li class="dv"><a href="/post/edit?id=<?php echo $_GET['id']; ?>">Edit</a></li>
			</ul>
			<ul class="dy">
				
				<?php if (strtotime($data['post']['time_bump']) < strtotime('-1 Hour')): ?>
					<li class="dv"><a href="/post/bump?id=<?php echo $_GET['id']; ?>">Bump</a></li>
				<?php endif ?>
				<li class="dv"><a href="/post/delete?id=<?php echo $_GET['id']; ?>">x</a></li>
			</ul>
		</div>
	<?php endif ?>

	<!-- START CONTENT -->
	<div class="m blog-post">
		<h1 style="text-align: center;margin-bottom: 10px;"><a href="/post?id=<?php echo $_GET['id']; ?>"><?php echo $data['post']['title']; ?></a></h1>
		<?php echo $data['post']['content_html']; ?>
	</div>

	<!-- START CONTENT INFO -->
	<div id="content-meta">
		<?php if ($data['post']['time_create'] !== $data['post']['time_update']): ?>
			<?php echo 'Last edited on ' . $data['post']['time_update']; ?>
		<?php endif ?>

	</div>

	<!-- START COMMENT -->
	<div id="a">
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
			echo "<li class='f m' id='comment-".$comment['CID']."'>";
			echo "<div id='comment'>".$comment['comment_html']."</div>";
			echo "<div id='comment-meta'>";
			echo "<span id='comment-meta-name'><a class='dp' href='/".$comment['username']."'>".$comment['name']."</a></span>";
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
#oracle-social-comments .f {
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