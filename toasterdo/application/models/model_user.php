<?php
class Model_User{

    /**
     * Character set to generate
     *
     * @var string
     */
    private static $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789';


    /**
     * Implementation of login to the app
     *
     * @param string $login ($_POST['login'])
     * @param string $password ($_POST['password'])
     */
    public function login_user( string $login, string $password ): void
    {
        $user = $this->get_user_by_login( $login );

        if( $user['user_pass'] == md5(trim( $password ))){
            $hash = "";
            $clean = strlen(self::$chars) - 1;
            while (strlen($hash) < 8){
                $hash .= self::$chars[mt_rand(0,$clean)];
            }

            $this->set_hash( $user['ID'], $hash );
            $this->set_cookies('', $user['ID'], $hash );
        }
    }


    /**
     *  Main register
     * @param string $login - $_POST['login']
     * @param string $password - $_POST['password']
     * @return bool false  - if login already exists
     */
    public function register_user ( string $login, string $password ): ?bool
    {
        if( $this->get_user_by_login( $login ) )
            return false;

        $user['user_login'] = $login;
        $user['user_pass']  = md5(trim( $password ));

        if ( $this->set_user( $user ) )
            $this->login_user( $login, $password );

        return true;
    }


    /**
     * Get user by 'login
     *
     * @param string $login
     * @return array|FALSE
     */
    private function get_user_by_login ( string $login ): ?array {
        $db = new SafeMySQL();
        $data = $db->getRow( "SELECT * FROM users WHERE user_login=?s", $login );

        return $data;
    }


    /**
     * Add user in DB
     *
     * @param $user (array['Row'=>'value'])
     * @return bool
     */
    private function set_user ( array $user ): ?bool{

        $db = new SafeMySQL();

        if( $db->query(" INSERT INTO users SET ?u ", $user) )
            return true;

        return false;
    }


    /**
     * Add hash in Db by user_id
     * @param int $user_id
     * @param string $hash
     */
    private function set_hash ( int $user_id, string $hash ): void
    {
        $db = new SafeMySQL();
        $sql = "UPDATE users SET user_hash=?s WHERE id = ?i";
        $db -> query($sql, $hash, $user_id);
    }


    /**
     * Set $_COOKIE ['ID'] and $_COOKIE['hash']
     *
     * @param bool $clear
     * @param string $user_id
     * @param string $hash
     */
    public function set_cookies(bool $clear = false, string $user_id= '', string $hash = '' ): void
    {
        $time = time()+3600;
        if($clear == true) $time = time()-3600;
        setcookie ('ID', $user_id, $time,'/');
        setcookie ('hash', $hash, $time,'/');
    }

}
