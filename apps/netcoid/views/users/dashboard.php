<style type="text/css">
.introduction{}
#red-menu-dashboard {
    background: none repeat scroll 0 0 #EEEEEE;
    height: 50px;
}

#ajax-refresh {
    border: 1px solid #EEEEEE;
    margin-bottom: 5px;
    padding: 5px;
    text-align: center;
    display:block;
}

a .bootstraps:hover{text-decoration:none;color:#444;background-color:#FFFDE8;border:1px solid #ddd;}
.bootstraps{border: 1px solid #CCC;}
.bootstraps .image{    background-image: url("www-static/netcoid/assets/img/icons/lisat.png");
    background-position: 10px center;
    background-repeat: no-repeat;
    border-bottom: 1px solid #EEEEEE;
    padding: 5px;
    text-align: center;}
.bootstraps .desc{padding: 5px;}
</style>
<div id="red-menu-dashboard">
<ul class="clearfix" style="width:960px;margin:0 auto;">
	<li class="l" style="padding-top:17.5px"><a href="/dashboard"><?php $this->getIMG('netcoid','img/icons/user_menu_groups.png') ?></a></li>
	<li class="l" style="padding-top:17.5px;margin-left:25px"><a href="/edit/profile"><?php $this->getIMG('netcoid','img/icons/edit.png') ?></a></li>
</ul>
</div>
<div class="clearfix" id="red-content">

	<!-- IF UPDATE -->
	<div id="ajax-update-following"></div>

	<!-- IF NO POST -->
	<?php if (empty($data['posts'])): ?>
        <a href="/search"><div class="c bootstraps">
            <div class="image">Ikuti Perkembangan disekitar anda</div> 
            <div class="desc">Jelajahi groups, follow pelaku bisnis atau topik yang ingin anda ikuti.</div>
        </div></a>

        <div style="margin-top: 20px;">
        <?php $this->getIMG('netcoid','img/tutorial/feedbackfollow.png'); ?>
        <?php $this->getIMG('netcoid','img/tutorial/userfollow.png') ?>
        </div>
	<?php endif ?>
	<!-- IF NO POST END -->

	<!-- IF POST --> 
	<?php if (isset($data['posts'])): ?>
		<div id="posts-from-following">
		<ul>
			<?php foreach ($data['posts'] as $post): ?>
				<?php #var_dump($post); ?>
				<!-- IF FROM FOLLOWING USERS -->
				<?php if ($post['type'] === 'post'): ?>
					<!-- POST -->
					<?php if ($post['post']['status'] == 0): ?>
						<li class="from-follow-uid" data-id="<?php echo $post['post']['PID'];?>"><a class="u" href="/<?php echo $post['post']['username'] ?>"><?php echo $post['post']['name'] ?></a> <i>post</i> <a target="_blank" class="a" href="/post?id=<?php echo $post['post']['PID'] ?>">
						<?php echo $post['post']['title']; ?></a></li>
					<?php endif ?>

					<!-- OFFER -->
					<?php if ($post['post']['status'] == 1): ?>
						<li class="from-follow-uid" data-id="<?php echo $post['post']['PID'];?>"><a class="u" href="/<?php echo $post['post']['username'] ?>"><?php echo $post['post']['name'] ?></a> <i>offers</i> <a target="_blank" class="a" href="/post?id=<?php echo $post['post']['PID'] ?>">
						<?php echo $post['post']['title']; ?></a></li>
					<?php endif ?>

					<!-- OFFER -->
					<?php if ($post['post']['status'] == 2): ?>
						<li class="from-follow-uid" data-id="<?php echo $post['post']['PID'];?>"><a class="u" href="/<?php echo $post['post']['username'] ?>"><?php echo $post['post']['name'] ?></a> <i>requests</i> <a target="_blank" class="a" href="/post?id=<?php echo $post['post']['PID'] ?>">
						<?php echo $post['post']['title']; ?></a></li>
					<?php endif ?>				
				<?php endif ?>

				<!-- IF FROM FOLLOWING GROUP -->
				<?php if ($post['type'] === 'groups'): ?>
					<!-- POST -->
					<?php if ($post['post']['status'] == 0): ?>
						<li class="from-follow-gid" data-id="<?php echo $post['post']['PID'];?>"><i>In</i> <a class="a" target="_blank" href="/group?id=<?php echo $post['post']['post_GID'] ?>"><?php echo $post['post']['groupname']; ?></a>, <a class="u" href="/<?php echo $post['post']['username'] ?>"><?php echo $post['post']['name'] ?></a> <i>post</i> <a target="_blank" class="a" href="/post?id=<?php echo $post['post']['PID'] ?>"><?php echo $post['post']['title']; ?></a></li>
					<?php endif ?>

					<!-- OFFER -->
					<?php if ($post['post']['status'] == 1): ?>
						<li class="from-follow-gid" data-id="<?php echo $post['post']['PID'];?>"><i>In</i> <a class="a" target="_blank" href="/group?id=<?php echo $post['post']['post_GID'] ?>"><?php echo $post['post']['groupname']; ?></a>, <a class="u" href="/<?php echo $post['post']['username'] ?>"><?php echo $post['post']['name'] ?></a> <i>offers</i> <a target="_blank" class="a" href="/post?id=<?php echo $post['post']['PID'] ?>"><?php echo $post['post']['title']; ?></a></li>
					<?php endif ?>

					<!-- OFFER -->
					<?php if ($post['post']['status'] == 2): ?>
						<li class="from-follow-gid" data-id="<?php echo $post['post']['PID'];?>"><i>In</i> <a class="a" target="_blank" href="/group?id=<?php echo $post['post']['post_GID'] ?>"><?php echo $post['post']['groupname']; ?></a>, <a class="u" href="/<?php echo $post['post']['username'] ?>"><?php echo $post['post']['name'] ?></a> <i>requests</i> <a target="_blank" class="a" href="/post?id=<?php echo $post['post']['PID'] ?>"><?php echo $post['post']['title']; ?></a></li>
					<?php endif ?>				
				<?php endif ?>

			<?php endforeach ?>
		</ul>
		</div>
	<?php endif ?>
</div>