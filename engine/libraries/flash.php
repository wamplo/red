<?php
namespace Engine\libraries;

if (! defined ( 'SECURE' ))
    exit ( 'Hello, security@networks.co.id' );

/**
* Code name HERMES, runs the message system around netcoid
* saat ini pake sessions, cuma munkin nanti ada yang lebih baik
* tanpa menggunakan session atau url kaya ?sucess
*/
class Flash {

    #private $messages
    public function setMessage($message){
        $_SESSION ['HERMES']['message'] = $message;
        return TRUE;
    }

    public function setError($message){
        $_SESSION ['HERMES']['error'] = $message;
        return TRUE;
    }

    public function showMessage(){
        if (isset($_SESSION ['HERMES']['message'])) {
            echo '<div id="red-ajax-notification" style="text-align: center; background: none repeat scroll 0pt 0pt rgb(225, 244, 255); border-right: 1px solid rgb(187, 215, 232); border-left: 1px solid rgb(187, 215, 232); border-bottom: 1px solid rgb(187, 215, 232); position: absolute; margin-bottom: 5px; padding: 5px; width: 100%;">'.$_SESSION ['HERMES']['message'].'</div></div><script type="text/javascript">$("#red-ajax-notification").delay(2000).fadeOut("slow");</script>';
            unset ( $_SESSION ['HERMES']['message'] );
            return TRUE;
        }       
    }

    public function showError(){
        if (isset($_SESSION ['HERMES']['error'])) {
            echo '<div id="red-ajax-notification" style="text-align: center; background: #FAFFB3; border-right: 1px solid rgb(187, 215, 232); border-left: 1px solid rgb(187, 215, 232); border-bottom: 1px solid rgb(187, 215, 232); position: absolute; margin-bottom: 5px; padding: 5px; width: 100%;">'.$_SESSION ['HERMES']['error'].'</div></div><script type="text/javascript">$("#red-ajax-notification").delay(2000).fadeOut("slow");</script>';
            unset ( $_SESSION ['HERMES']['error'] );
            return TRUE;
        }       
    }

    public function showAll(){
        $this->showError();
        $this->showMessage();
    }
}

?>