<?php 

if (! defined ( 'SECURE' ))
    exit ( 'Hello, security@networks.co.id' );

use Engine\Libraries\Forms;
use Engine\Libraries\Security;
use Engine\Libraries\Validation;
use Engine\Libraries\Flash;
use Engine\Libraries\Sessions;

class Api extends Engine\Red
{
    private $v, $f, $e, $h;
    
    public function __construct(){
        $this->v = new Validation;
        $this->f = new Forms;
        $this->e = new Sessions;
        $this->h = new Flash;
    }

    /**
     * postRefresh()
     * a post refresh checks if there is any update
     * on a user feed
     * @param $_GET['f'], Sessions(UID)
     * @return TRUE (new changes), FALSE (no changes)
     * @author Adam Ramadhan
     * @version 1
     **/
    public function postRefresh(){

        $p = new Apps\Netcoid\Models\Posts;
        $g = new Apps\Netcoid\Models\Groups;

        $follow_post = $p->getFollowingPost($this->e->get('uid'));
        $follow_group = $g->getFollowingGroups($this->e->get('uid'));

        # JOIN PID YANG SAMA +  TYPE
        foreach ($follow_post as $newfollow_post) {
            $renderarr[$newfollow_post['PID']] = array(
                'post' => $newfollow_post,
                'type' => 'post'
            );
        }

        foreach ($follow_group as $newfollow_group) {
           $renderarr[$newfollow_group['PID']] = array(
                'post' => $newfollow_group,
                'type' => 'groups'
            );
        }

        # SORT THE ARRAY
        krsort($renderarr); # var_dump(key($renderarr));

        # IF DIFFRENT
        if (key($renderarr) != $_GET['f']) {
            echo json_encode(true);
        }

        # IF STILL THE SAME
        if (key($renderarr) == $_GET['f']) {
            echo json_encode(false); 
        }

        # var_dump($p->getDiff($_GET['f'],$this->e->get('uid')));
        #var_dump($p->getDiff($_GET['f'],$this->e->get('uid')));
    }

    /**
     * checkUsername()
     * checks for a username if exist
     * @param $_POST['username']
     * @return TRUE (doesn`t exist), FALSE (user exist)
     * @author Adam Ramadhan
     * @version 1
     **/
    public function checkUsername(){
        $u = new Apps\Netcoid\Models\Users;
        $e = $u->userexist($_POST['username']);
        if (!empty($e)) {
            echo json_encode(false);
        }

        if (empty($e)) {
            echo json_encode(true);
        }        
    }

    /**
     * checkName()
     * checks for a name if exist
     * @param $_POST['name']
     * @return TRUE (doesn`t exist), FALSE (user exist)
     * @author Adam Ramadhan
     * @version 1
     **/
    public function checkName(){
        $u = new Apps\Netcoid\Models\Users;
        $e = $u->companyexist($_POST['name']);
        if (!empty($e)) {
            echo json_encode(false);
        }

        if (empty($e)) {
            echo json_encode(true);
        }        
    }

    /**
     * followUID()
     * follows an UID if not follow
     * @param $_POST['name'], Sessions(UID)
     * @return TRUE (doesn`t exist), FALSE (user exist)
     * @author Adam Ramadhan
     * @version 1
     **/
    public function followUID(){
        if (isset($_GET['id']) && $this->e->get('uid') && isset($_SERVER ['HTTP_REFERER'])) {

            # YOU CANT FOLLOW YOUR SELF
            if ($this->e->get('uid') === $_GET['id']) {
                die('security@networks.co.id');
            }

            $o = new Apps\Netcoid\Models\Follow;
            $u = new Apps\Netcoid\Models\Users;
            
            $status = $o->isFollowingUID($this->e->get('uid'), $_GET['id']);
            $user = $u->getData($_GET['id']);

            # SETTING UP FOR FOLLOW
            $f['follow_uid'] = $this->e->get ( 'uid' );
            $f['target_uid'] = $_GET ['id'];
            
            # @todo nanti diganti pake $_SERVER ['HTTP_REFERER'] aja? biar gak ambil dr database
            if (empty($status)) {
                $o->set($f);
                $this->h->setMessage('Following '. $user['name'] .'!'); 
                header('Location: ' . $_SERVER ['HTTP_REFERER']);
            } else {
                die('security@networks.co.id');
            }
        }
    }

    public function unfollowUID(){
        if (isset($_GET['id']) && $this->e->get('uid') && isset($_SERVER ['HTTP_REFERER'])) {

            $o = new Apps\Netcoid\Models\Follow;
            $u = new Apps\Netcoid\Models\Users;

            $status = $o->isFollowingUID($this->e->get('uid'), $_GET['id']);
            $user = $u->getData($_GET['id']);

            # SETTING UP FOR UNFOLLOW
            $f['follow_uid'] = $this->e->get ( 'uid' );
            $f['target_uid'] = $_GET ['id'];

            if (!empty($status)) {
                $o->unfollowUID($f);
                $this->h->setMessage('Unfollowing '. $user['name'] .'!'); 
                header('Location: ' . $_SERVER ['HTTP_REFERER']);
            }
        }
    }

    public function followGID(){
        if (isset($_GET['id']) && $this->e->get('uid') && isset($_SERVER ['HTTP_REFERER'])) {

            $o = new Apps\Netcoid\Models\Follow;
            $g = new Apps\Netcoid\Models\Groups;

            $status = $o->isFollowingGID($this->e->get('uid'), $_GET['id']);
            $group = $g->getGroup($_GET['id']);

            # SETTING UP FOR UNFOLLOW
            $f['follow_uid'] = $this->e->get ( 'uid' );
            $f['target_gid'] = $_GET ['id'];

            if (empty($status)) {
                $o->set($f);
                $this->h->setMessage('Following '. $group['name'] .'!'); 
                header('Location: ' . $_SERVER ['HTTP_REFERER']);
            }
        }
    }

    public function unfollowGID(){
        if (isset($_GET['id']) && $this->e->get('uid') && isset($_SERVER ['HTTP_REFERER'])) {

            $o = new Apps\Netcoid\Models\Follow;
            $g = new Apps\Netcoid\Models\Groups;

            $status = $o->isFollowingGID($this->e->get('uid'), $_GET['id']);
            $group = $g->getGroup($_GET['id']);

            # SETTING UP FOR UNFOLLOW
            $f['follow_uid'] = $this->e->get ( 'uid' );
            $f['target_gid'] = $_GET ['id'];

            if (!empty($status)) {
                $o->unfollowGID($f);
                $this->h->setMessage('Unfollowing '. $group['name'] .'!'); 
                header('Location: ' . $_SERVER ['HTTP_REFERER']);
            }
        }
    }

    /**
     * OPEN Mentions
     * - Check if its his comment
     * - Set 0 to 1
     *
     * @url /api/m/open
     * @arg2 $_POST['id']
     * @author Adam Ramadhan
     **/
    public function openM(){
        # check if its his comment
        if (isset($_GET['id']) && $this->e->get('uid')) {
            $m = new Apps\Netcoid\Models\Mentions;
            # @todo perlu optimasi
            $check = $m->getDatafromCIDandUID($_GET['id'], $this->e->get('uid'));
            if ($this->e->get('uid') == $check['mention_UID']) {
                $m->open($check['MID'], $this->e->get('uid'));
                header('Location: /mentions');
            } else {
                die('security@networks.co.id');
            }
        }

        else {
            die('api@networks.co.id');
        }
    }

    public function delC(){
       if (isset($_GET['id']) && $this->e->get('uid')) {


           $c = new Apps\Netcoid\Models\Comments;
           $check = $c->getUIDbyCID($_GET['id']);
           
           if (isset($_SERVER ['HTTP_REFERER']) && $this->e->get('uid') == $check['comment_UID'])
            {
                $c->del($_GET['id']);
                $this->h->setMessage('Comment Deleted'); 
                header('Location: ' . $_SERVER ['HTTP_REFERER']);
            }

       } else {
           die('api@networks.co.id');
       }
    }

    /**
     * SET COMMENT FOR POSTS
     * - $this->__commentRender();
     * - set comment
     * - set mention
     *
     * @url /api/c/set
     * @arg1 $_POST['comment']
     * @arg2 $_POST['id']
     * @author Adam Ramadhan
     **/
    public function setC(){

        if (isset($_POST['comment']) && $this->e->get('uid')) {

            $this->v->required($_POST['comment'], 'comment tidak boleh kosong');
            $this->v->regex($_POST['comment'], '/^(.|\n){4,400}$/',  # nanti dihapus
                '4-400 any dan spasi');

            if(!sizeof($this->v->errors)) 
            {
                # CHECK POST IS HUMAN
                if ($this->f->checkHumanPost(3)) {

                    # RENDER COMMENT
                    $r = $this->__commentRender($_POST['comment']);

                    # SETTING UP
                    $p['comment'] = $r['text'];

                    # START PLUGIN
                    $m = new Engine\Vendors\Stackexchangeinc\wmd\ElephantMarkdown;
                    $vendorHTMLpurifier = new Engine\Vendors\HTMLpurifier\HTMLpurifier;
                    $HTMLpurifierConfig = HTMLPurifier_Config::createDefault();
                    $HTMLpurifierConfig->set('HTML.SafeObject', "1");
                    $HTMLpurifierConfig->set('Output.FlashCompat', "1");
                    $HTMLpurifierConfig->set('Filter.YouTube', "1");
                    $purifier = new HTMLPurifier($HTMLpurifierConfig);
                    $data['comment_html'] = $purifier->purify($m->parse($p['comment']));
                    # END PLUGIN

                    $data['comment_UID'] = $this->e->get('uid');
                    $data['comment_PID'] = $_POST['id'];            
                    $time = new DateTime ( NULL, new DateTimeZone ( 'Asia/Jakarta' ) );
                    $data['time_create'] = $time->format('Y-m-d H:i:s');
                    $m = new Apps\Netcoid\Models\Mentions;

                    # SET COMMENT
                    $c = new Apps\Netcoid\Models\Comments;
                    $p = new Apps\Netcoid\Models\Posts;

                    $c->set($data);
                    
                    # TAMBAH SATU REPLY
                    $p->addReply1($data['comment_PID']);

                    # SET MENTION IF THERE IS SOME USERNAME IN COMMENT
                    if (!empty($r['usernames'])) {
                        $m->set($c->getLastId(), $r['usernames']);
                    }
                    $this->h->setMessage('Comment Posted'); 
                    header('Location: /post?id='.$_POST['id'] );
                }           
            }

            if(sizeof($this->v->errors)) 
            {
                $this->h->setError($this->v->errors[0]); 
                header('Location: /post?id='.$_POST['id'] );
            }
   
        } else {
            die('api@networks.co.id');
        }
    }

    // UNREAD MESSAGE
    public function UnreadM(){
        if (isset($_GET['id']) && $this->e->get('uid')) {
            
            $m = new Apps\Netcoid\Models\Messages;
            $status = $m->getMessage($_GET['id'],$this->e->get('uid'));

            # IF TRUE OR THERE IS A RETURN
            if ($status['type'] == 1) {
                $m->to_type($_GET['id'], 0);
                $this->h->setMessage('Moveing to inbox...');
                header('Location: /messages?id=' . $_GET['id']);
            }

        } else {
            die('api@networks.co.id');
        }        
    }

    // DELETE MESSAGE
    public function DeleteM(){
        # IF NOT SET ID DELETE ALL
        if ($this->e->get('uid')) {
        
            $m = new Apps\Netcoid\Models\Messages;
            
            $m->delReadMessages($this->e->get('uid'));
            $this->h->setMessage('Deleted...');
            header('Location: /messages');

        } else {
            die('api@networks.co.id');
        }   

        # IF SET ID
        if (isset($_GET['id']) && $this->e->get('uid')) {
            
            $m = new Apps\Netcoid\Models\Messages;
            $status = $m->getMessage($_GET['id'],$this->e->get('uid'));

            # IF TRUE OR THERE IS A RETURN
            if ($status['type'] == 1) {

                # AUTH JUST FOR RECIVER
                if ($status['ruid'] == $this->e->get('uid')) {

                    $m->delMessage($_GET['id']);
                    $this->h->setMessage('Deleted...');
                    header('Location: /messages');
                }
            }

        } else {
            die('api@networks.co.id');
        }        
    }

    // READ MESSAGE
    public function ReadM(){
        if (isset($_GET['id']) && $this->e->get('uid')) {
            
            $m = new Apps\Netcoid\Models\Messages;
            $status = $m->getMessage($_GET['id'],$this->e->get('uid'));

            # IF TRUE OR THERE IS A RETURN
             if ($status['type'] == 0) {
                $m->to_type($_GET['id'], 1);
                $this->h->setMessage('Moveing to archive...');
                header('Location: /messages?id=' . $_GET['id']);
            }

        } else {
            die('api@networks.co.id');
        }
    }

    /**
     * PARSE COMMENT TO ARR DATA
     * @arg1 text
     * @return arr(arr('usernames'),'comment');
     * @author Adam Ramadhan
     **/
    private function __commentRender($text){

        # IF THERE IS USERNAMES
        $newdata = array();

        # GET ALL USERNAME FROM TEXT =USERNAME
        preg_match_all ("/=([a-zA-Z0-9_]+)/", $text, $usernames);

        # @TODO SIMPLER AND MORE EFFICIENT
        foreach($usernames[1] as $username) {
            $u = new Apps\Netcoid\Models\Users;
            $data = $u->getDataForComments($username);
            if (!empty($data)) {
                $newdata[$username] = array(
                    'role'  => $data['role'], 
                    'name'  => $data['name'], 
                    'uid'   => $data['uid']
                );
            }
        }

        # @TODO SIMPLER AND MORE EFFICIENT
        foreach ($newdata as $username => $values) {
            switch ($values ['role']) {
                case '1' :
                    $text = preg_replace('/=(' . $username . ')/', '<a class="u" href="/'. strtolower ( '\1' ) .'">'. $values ['name'] .' &#x2714;</a>', $text);
                    break;

                case '5' :
                    $text = preg_replace('/=(' . $username . ')/', 
                    '<a class="u" href="/'. strtolower ( '\1' ) .'">*'. $values ['name'] .'</a>', $text);
                    break;
                
                case '0' :
                    $text = preg_replace('/=(' . $username . ')/', '<a class="u" href="/'. strtolower ( '\1' ) .'">'. $values ['name'] .'</a>', $text);
                    break;
                
                default :
                    $text = preg_replace('/=(' . $username . ')/', '<a class="u" href="/'. strtolower ( '\1' ) .'">'. $values ['name'] .'</a>', $text);
                    break;
            }
        }

        # SET RETURN
        $return = array(
            'usernames' => $newdata,
            'text'      => $text 
        );

        return $return;
    }
}
?>