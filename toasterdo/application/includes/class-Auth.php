<?php

/**
 * Class Auth
 * Login user bayer
 */
class Auth{
    /**
     * Start method
     * @param array $pages
     */
    public static function start(array $pages ): void
    {
        $user_hash =  Auth::get_user_hash($_COOKIE['ID']);

        if( !$_COOKIE['ID'] && $pages[1]=='todo' || $user_hash != $_COOKIE['hash'] )
            Route::go_to_page('');

        if( $_COOKIE['ID'] ){
            if( $pages[1] == null || ( $pages[1] == 'user' && $pages[2] == 'register' ))
                Route::go_to_page('todo');
        }

    }

    /**
     * Get user hash
     * @param null $cookie_id
     * @return null|string
     */
    private function get_user_hash( $cookie_id = null ): ?string
    {
        if ( $cookie_id == null ) return null;

        $db= new SafeMySQL();
        $sql= "SELECT user_hash FROM ?n WHERE ID=?i";
        $user_hash = $db ->getOne($sql,"users",$_COOKIE['ID']);

        return $user_hash;
    }
}

