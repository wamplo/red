<style type="text/css">
.d {
    padding: 5px 0;
}
.d li{
    border-bottom: 1px solid #EEEEEE;
    padding: 5px 10px;
}
.d li:hover {background: none repeat scroll 0 0 #FFFCE7;}

.d #messages-subject {

font-size: 12px;
}

.d #messages-meta {
    font-size: 11px;
    color:#ccc;
}

.d #r {
    background: none repeat scroll 0 0 #EEEEEE;
    border: 1px solid #DDDDDD;
    padding: 5px;
    text-align: center;
}
.d #r {
    background: none repeat scroll 0 0 #DDDDDD;
    border: 1px solid #CCCCCC;
    padding: 5px;
    text-align: center;
}
.d #heading-meta {
    background: none repeat scroll 0 0 #F0F0F0;
    border-bottom: 1px solid #DDDDDD;
    border-left: 1px solid #DDDDDD;
    border-right: 1px solid #DDDDDD;
    padding: 5px;
    margin-bottom: 5px;
}

</style>

<div id="red-content">

<?php #var_dump($data) ?>

<?php if (!empty($data['messages'])): ?>
	<ul class="d">
	<div id="r">Inbox</div>
	<div id="heading-meta">See All</div>
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
<?php endif ?>

<?php if (!empty($data['archives'])): ?>
	<ul class="d">
	<div id="r">Archives</div>
	<div id="heading-meta" class="clearfix"><span class="dt"><a href="/api/message/delete">Delete All</a></span> <span class="dq">See All</span></div>
	<?php foreach ($data['archives'] as $archive): ?>
		<a class="a" href="/messages?id=<?php echo $archive['mid']; ?>"><li>
		<div id="messages-subject">
			<?php echo $archive['subject']; ?>
		</div>
		<div id="messages-meta">
			<a class="u" href="/<?php echo $archive['username']; ?>"><?php echo $archive['name']; ?></a> <i>on</i> <?php echo $archive['time_create'] ?>
		</div>
		</li></a>
	<?php endforeach ?>
	</ul>
<?php endif ?>

</div>