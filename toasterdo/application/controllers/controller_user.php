<?php
class Controller_User extends Controller
{

    function __construct()
    {
        $this->model = new Model_User();
        $this->view = new View();
    }


    function action_index()
    {

        if( $_POST['login'] && $_POST['password'] ){
            $this->model->login_user( $_POST['login'], $_POST['password'] );

            Route::go_to_page('todo');
        }

        $this->view->generate('homepage_view.php');
    }


    function action_register()
    {

        if( $_POST['login'] && $_POST['password'] == $_POST['double_password'] ){

            if( $this->model->register_user( $_POST['login'], $_POST['password'] ) )
                Route::go_to_page('todo');
        }


        // generation page
        $this->view->generate('register_view.php', array());

    }


    function action_logout(){
        //clear Cookies
        $this->model->set_cookies(true);
        Route::go_to_page('');
}

}