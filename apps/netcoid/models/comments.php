<?php
namespace Apps\Netcoid\Models;

if (! defined ( 'SECURE' ))
	exit ( 'Hello, security@networks.co.id' );

class Comments extends \Engine\libraries\Database {

	public $database = 'Master';
	
	function set($data) {
		$data = $this->insert ( 'comments', $data );
		return $data;
	}

	function del($cid) {
		$status = $this->query ( "DELETE FROM comments WHERE CID = :cid", array ('cid' => $cid ) );
		return $status;
	}

	function delbyPID($pid){
		$status = $this->query ( "DELETE FROM comments WHERE comment_PID = :pid", array ('pid' => $pid ) );
		return $status;		
	}

	function getLastId() {
		$id = $this->start->lastInsertId();
		return $id;
	}

	function getUIDbyCID($cid) {
		$data = $this->fetch ( "SELECT comment_UID FROM comments WHERE CID = :cid", array ('cid' => $cid ) );
		return $data;
	}

	function getCommentsByPID($pid, $from = 0, $limit = 20) {
		$data = $this->fetchAll ( "SELECT users.name, users.username, comments.comment, comments.comment_html, comments.CID, comments.time_create, comments.comment_UID
		FROM comments, users WHERE comments.comment_UID = users.UID AND comment_PID = :pid ORDER BY time_create ASC LIMIT $limit", array('pid' => $pid));
		return $data;
	}

	function countByPid($pid) {
		$count = $this->fetch ( "SELECT COUNT(CID) FROM comments WHERE comment_PID = :pid", array ('pid' => $pid ) );
		return $count;
	}

	function listCommentsByMentions($uid) {
		$data = $this->fetchAll ( "SELECT mentions.mention_UID, users.name, 
		comments.CID, comments.comment_html, comments.comment, comments.comment_PID FROM comments
		LEFT JOIN mentions ON comments.CID = mentions.mention_CID
		LEFT JOIN users ON comments.comment_UID = users.UID
		WHERE mentions.mention_UID = :uid
		AND mentions.read = 0 ORDER BY cid DESC LIMIT 20", array ('uid' => $uid ) );
		return $data;
	}
}

?>