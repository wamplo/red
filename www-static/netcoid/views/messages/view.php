<style type="text/css">
#single-message {
    width: 650px; /* 700px */
}
#unread-messages {
    border-left: 1px solid #DDDDDD;
    font-size: 12px;
    width: 258px;
}
#unread-messages li {
    word-wrap: break-word;
}
.f li:hover #messages-subject{background: #eee;}
.f li:hover #messages-meta {background: #eee;}
.f #messages-subject {
    padding: 5px 10px;
}

.f #messages-meta {
    border-bottom: 1px solid #eee;
    font-size: 11px;
    padding: 5px 10px;
    color:#ccc;
}
#ag {
    border: 1px solid #EEEEEE;
    margin: 20px 0 0;
    padding: 5px;
    text-align: center;
}

</style>
<div class="clearfix" id="red-content">
	
	<?php #var_dump($data); ?>

	<!-- SINGLE MESSAGE START -->
	<div class="ef blog-post" id="single-message">
		<h1><?php echo $data['message']['subject'] ?></h1>
		<?php echo $data['message']['message']; ?>

		<?php if ($data['message']['type'] == 0): ?>
			<a href="/api/message/read?id=<?php echo $_GET['id']; ?>"><div id="ag">Done Reading</div></a>
		<?php endif ?>

		<?php if ($data['message']['type'] == 1): ?>
			<a href="/api/message/unread?id=<?php echo $_GET['id']; ?>"><div id="ag">Unread</div></a>
		<?php endif ?>
	</div>
	<!-- SINGLE MESSAGE END -->

	<!-- UNREAD MESSAGES START -->
	<div class="ei f" id="unread-messages">
		<ul>
			<?php foreach ($data['messages'] as $message): ?>
				<a class="a" href="/messages?id=<?php echo $message['mid']; ?>"><li>
				<div id="messages-subject">
					<?php echo $message['subject']; ?>
				</div>
				<div id="messages-meta">
					<a class="u" href="/<?php echo $message['username']; ?>"><?php echo $message['name']; ?></a> <i>on</i> <?php echo $message['timecreate'] ?>
				</div>
				</li></a>
			<?php endforeach ?>
		</ul>
	</div>
	<!-- UNREAD MESSAGES END -->
</div>