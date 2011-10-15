<?php
namespace Apps\Netcoid\Models;

if (! defined ( 'SECURE' ))
	exit ( 'Hello, security@networks.co.id' );

class Posts extends \Engine\libraries\Database {

	public $database = 'Master';
	
	function setPost($data) {
		$data = $this->insert ( 'posts', $data );
		return $data;
	}

	function del($pid) {
		$status = $this->query ( "DELETE FROM posts WHERE pid = :pid", array ('pid' => $pid ) );
		return $status;
	}

	function editPost($data){
		$update = $this->query ( "UPDATE posts SET 
					title = :title,
					content = :content,
					content_html = :content_html,
					time_update = :time_update,
					post_GID = :post_GID,
					post_UID = :post_UID,
					status	= :status
				WHERE pid = :pid", $data );
		return $data;
	}

	function setBump($data){
		$update = $this->query ( "UPDATE posts SET 
					time_bump = :time_bump
				WHERE pid = :pid", $data );
		return $data;
	}

	function setPostReturnId($data){
		$getid = $this->insertwithlastid ( 'posts', $data );
		return $getid;
	}	

	function getPostbyPID($pid){
		$data = $this->fetch( 'SELECT posts.PID, posts.title, posts.content, posts.content_html, posts.time_create, posts.time_update, posts.time_bump, posts.status, posts.post_UID, posts.count_views, users.username, users.name as name, users.username FROM posts, users WHERE posts.PID = :pid AND posts.post_UID = users.UID LIMIT 1',array( 'pid' => $pid ));
		return $data;	
	}

	function getPostbyUID($uid,$items,$offset,$status = 0){

		if ($offset === 0) {
			$start = 0;
			$end = $items;
		}

		if ($offset !== 0) {
			$start = $items * $offset;
			$end = $items; 
		}

		$data = $this->fetchAll( 'SELECT groups.name as groups_name, posts.PID, posts.title, posts.time_create, posts.time_update, posts.time_bump, posts.status, posts.post_GID, posts.post_UID, posts.count_views, users.username, users.name FROM posts, users, groups WHERE users.UID = posts.post_UID AND posts.post_UID = :uid AND posts.post_GID = groups.GID AND posts.status = :status ORDER BY time_bump DESC LIMIT '. $start .','. $end, array( 'uid' => $uid, 'status' => $status ));
		return $data;	
	}

	function CountPostsbyGroup($gid, $status = 0){
		$data = $this->fetch( 'SELECT COUNT(PID) FROM posts WHERE posts.post_GID = :gid AND posts.status = :status', array( 'gid' => $gid, 'status' =>  $status ));
		return $data['COUNT(PID)'];			
	}

	function CountPostsbyUID($uid,$status = 0){
		$data = $this->fetch( 'SELECT COUNT(PID) FROM posts WHERE posts.post_UID = :uid AND posts.status = :status', array( 'uid' => $uid, 'status' => $status ));
		return $data['COUNT(PID)'];			
	}

	function getPostsbyGroup($gid,$items,$offset){

		if ($offset === 0) {
			$start = 0;
			$end = $items;
		}

		if ($offset !== 0) {
			$start = $items * $offset;
			$end = $items; 
		}

		#var_dump($start,$end,$offset);
		$data = $this->fetchAll( 'SELECT posts.PID, posts.title, posts.content, posts.content_html, posts.time_create, posts.time_update, posts.time_bump, posts.status, posts.post_UID, posts.count_reply, posts.count_views, users.username, users.name FROM posts, users WHERE posts.post_GID = :gid AND posts.post_UID = users.UID ORDER BY time_bump DESC LIMIT '. $start .','. $end, array( 'gid' => $gid ));
		return $data;		
	}

	function getLastPost($limit = 10) {
		$data = $this->fetchAll( 'SELECT PID, title, content, content_html, time_create, time_update, time_bump, posts.status, post_UID, count_views, post_GID, groups.name as `group`, users.name as name, username FROM posts, groups, users WHERE post_GID = GID AND post_UID = UID ORDER BY time_create DESC LIMIT ' . $limit);
		return $data;
	}

	function addReply1($pid){
		$data = $this->query('UPDATE posts SET posts.count_reply = posts.count_reply + 1 WHERE posts.PID = :pid', array( 'pid' => $pid ));
		return $data;
	}

	function addView1($pid){
		$data = $this->query('UPDATE posts SET posts.count_views = posts.count_views + 1 WHERE posts.PID = :pid', array( 'pid' => $pid ));
		return $data;
	}


	function getFollowingPost($uid, $limit = 20) {
		$data = $this->fetchAll ( "SELECT posts.PID, posts.post_GID, posts.title, posts.status, users.name, users.username
		FROM posts
		INNER JOIN follow ON follow.target_UID = posts.post_UID
		INNER JOIN users ON users.UID = follow.target_UID AND users.UID != :uid
		WHERE follow.follow_UID = :uid
		ORDER BY posts.time_create DESC LIMIT 25", array ('uid' => $uid ) );
		return $data;
	}

	function getDiff($pid, $uid){
		$data = $this->fetch('SELECT count(posts.PID) AS updates
		FROM posts
		INNER JOIN follow ON follow.target_UID = posts.post_UID
		INNER JOIN users ON users.UID = follow.target_UID AND users.UID != :uid
		WHERE follow.follow_UID = :uid AND posts.PID > :pid', array('uid' => $uid, 'pid' => $pid));		
		return $data;
	}
}

?>