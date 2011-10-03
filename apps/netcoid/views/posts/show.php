<?php
$data['post']['fulltitle'] = $data['post']['title'];
if (strlen($data['post']['title']) > 60) {
	#var_dump(strlen($post['title']));
	$data['post']['title'] = substr($data['post']['title'], 0, 60) . '(...)';
}

?>
<div class="clearfix" id="red-content">

	<!-- START POST HEADER -->
	<div class="clearfix" id="post-header">
		<div class="l" style="width:700px">
			<ul>
				<li><b><?php echo $data['post']['title']; ?></b></li>
			</ul>
		</div>
		<div class="r"><a data-pjax="#rr-2" href="<?php echo $data['post']['username']; ?>" class="u"><?php echo $data['post']['name']; ?></a></div>
	</div>

	<!-- START CONTENT -->
	<div class="clearfix blog-post">
		<h1 style="word-wrap: break-word;text-align: center;margin-bottom: 10px;"><a data-pjax="rr-2" href="/post?id=<?php echo $_GET['id']; ?>"><?php echo $data['post']['fulltitle']; ?></a></h1>
		<?php echo $data['post']['content_html']; ?>
	</div>

	<!-- START CONTENT INFO -->
	<div id="content-meta">
		<?php if ($data['post']['time_create'] !== $data['post']['time_update']): ?>
			<?php echo 'Last edited on ' . $data['post']['time_update']; ?>
		<?php endif ?>

	</div>

	<!-- START MENU FOR THREAD STARTER -->
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

	<!-- START COMMENT -->
	<div id="comments">
		<?php if ($data['count']['COUNT(CID)'] == 0): ?>
		<div id="meta-comments">
			<h4><?php echo l('nocomments'); ?></h4>
		</div>
		<?php endif ?>

		<?php if ($data['count']['COUNT(CID)'] != 0): ?>		
		<div id="meta-comments">
			(<?php echo $data['count']['COUNT(CID)']; ?>) <?php echo l('comments') ?>
		</div>
		<?php endif ?>

		<!-- SOSIAL SHARE -->
		<div class="clearfix" style="
		    border-bottom: 1px solid #eee;
		    border-left: 1px solid #eee;
		    border-right: 1px solid #eee;
		    padding: 5px 10px;
		">
			<style type="text/css">
			.sosialbutton {
				position: relative;
				top: 2px;
			}

			</style>

			<!-- FACEBOOK -->
			<meta property="og:type" content="article" />
			<meta property="og:site_name" content="Netcoid Indonesia" />
			<meta property="fb:admins" content="1667473111" />
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) {return;}
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script><div class="fb-like sosialbutton l" data-send="false" data-layout="button_count" data-show-faces="false" data-font="verdana"></div>
			<!-- FACEBOOK END -->

			<!-- TWITTER -->
			<div class="sosialbutton l"><a href="https://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="netcoid" data-lang="id">Tweet</a></div>
			<script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
			<!-- TWITTER END -->

			<!-- GOOGLE PLUS -->
			<div class="sosialbutton l">
			<!-- Place this tag where you want the +1 button to render -->
			<div class="g-plusone" data-size="medium"></div>
			<!-- Place this render call where appropriate -->
			<script type="text/javascript">
			  window.___gcfg = {lang: 'id'};
			  (function() {
			    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			    po.src = 'https://apis.google.com/js/plusone.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
			  })();
			</script>
			</div>
			<!-- GOOGLE PLUS END -->
		</div>
		
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