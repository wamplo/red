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
.messageslist li:hover #messages-subject{background: #eee;}
.messageslist li:hover #messages-meta {background: #eee;}
.messageslist #messages-subject {
    padding: 5px 10px;
}

.messageslist #messages-meta {
    border-bottom: 1px solid #eee;
    font-size: 11px;
    padding: 5px 10px;
    color:#ccc;
}


#message-helper
{
    margin: 20px 0 0;
}

#message-helper a
{
	color:#444;
}

#message-helper #doneread {
    background: none repeat scroll 0 0 #F0F0F0;
    border-bottom: 1px solid #DDDDDD;
    border-left: 1px solid #DDDDDD;
    border-right: 1px solid #DDDDDD;
    padding: 5px;
    text-align: center;
}

#message-helper #reply {
    background: none repeat scroll 0 0 #DDDDDD;
    border: 1px solid #CCCCCC;
    padding: 5px;
    text-align: center;
}


</style>
<div class="clearfix" id="red-content">
	
	<?php #var_dump($data); ?>

	<!-- SINGLE MESSAGE START -->
	<div class="l blog-post" id="single-message">
		<h1><?php echo $data['message']['subject'] ?></h1>
		<?php echo $data['message']['message']; ?>

		<?php if ($data['message']['type'] == 0): ?>
			<div id="message-helper">
				<a href="/messages/send?id=<?php echo $data['message']['suid']; ?>"><div id="reply">Reply</div></a>
				<a href="/api/message/read?id=<?php echo $_GET['id']; ?>"><div id="doneread">Done Reading</div></a>
			</div>
		<?php endif ?>

		<?php if ($data['message']['type'] == 1): ?>
			<div id="message-helper">
			   <a href="/api/message/delete?id=<?php echo $_GET['id']; ?>"><div id="reply">Delete</div></a>
				<a href="/api/message/unread?id=<?php echo $_GET['id']; ?>"><div id="doneread">Unread</div></a>
			</div>
		<?php endif ?>
	</div>
	<!-- SINGLE MESSAGE END -->

	<!-- UNREAD MESSAGES START -->
	<div class="r messageslist" id="unread-messages">
		<ul>
			<?php foreach ($data['messages'] as $message): ?>
				<a class="a" href="/messages?id=<?php echo $message['mid']; ?>"><li>
				<div id="messages-subject">
					<?php echo $message['subject']; ?>
				</div>
				<div id="messages-meta">
					<a class="u" href="/<?php echo $message['username']; ?>"><?php echo $message['name']; ?></a> <i>on</i> <?php echo $message['time_create'] ?>
				</div>
				</li></a>
			<?php endforeach ?>
		</ul>
	</div>
	<!-- UNREAD MESSAGES END -->
</div>