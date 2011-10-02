<?php 
# REGISTER ROUTES
$routes = array(

    '(^[a-zA-Z0-9_]{6,20}$)' =>  'Profiles:Index',
    '^([a-zA-Z0-9_]{6,20})/posts$' =>  'Profiles:Posts',
    '^([a-zA-Z0-9_]{6,20})/offers$' =>  'Profiles:Offers',
    '^([a-zA-Z0-9_]{6,20})/requests$' =>  'Profiles:Requests',

    'verify'    =>  'test:Offline',
    'HQ'        =>  'test:Offline',

    'index' 			=>  'site:Index',
    'signup'            =>  'site:Signup',
    'search'            =>  'site:Search',
    'group'             =>  'Groups:Index',
    'register' 			=>  'register:Index',
    'development'       =>  'test:Offline',

    'messages'          =>  'Message:Index',
    'messages/send'     =>  'Message:Send',

    'api/c/username' 	=>  'Api:checkUsername',
    'api/c/name' 		=>  'Api:checkName',

    'login' 			=>  'Auth:Login',
    'logout' 			=>  'Auth:Logout',

    'dashboard'         =>  'Users:Dashboard',
    'mentions'          =>  'Users:Mentions',
    'edit/profile'		=>	'Users:editProfile',

    'post'				=> 	'posts:showPost',
    'post/edit'         =>  'posts:editPost',
    'post/any'			=>	'posts:Any',
    'post/offer'		=>	'posts:Offer',
    'post/request'		=>	'posts:Request',
    'post/bump'         =>  'posts:Bump',
    'post/delete'       =>  'posts:Delete',

    // MESSAGE
    'api/message/read'  =>  'Api:ReadM',
    'api/message/unread'  =>  'Api:UnreadM',

    'api/c/set'			=>	'Api:setC',
    'api/c/del'         =>  'Api:delC',

    'api/s/u/follow'    =>  'Api:followUID',
    'api/s/u/unfollow'  =>  'Api:unfollowUID',
    'api/s/g/follow'    =>  'Api:followGID',
    'api/s/g/unfollow'  =>  'Api:unfollowGID',

    'api/p/refresh'     =>  'Api:postRefresh',
#'api/c/get'			=>	'Api:getC'

    // MENTION
    'api/m/open'        =>  'Api:openM'
    #'([0-9]+)' 	=>	'dashboard:Index'
);
?>