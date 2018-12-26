<?php

class Controller_Todo extends Controller
{
    function __construct()
    {
        $this->model = new Model_Todo();
        $this->view = new View();
    }


    function action_index()
    {


        $data['posts'] = $this->model->get_posts( $_COOKIE['ID'] );

        $this->view->generate('todo/list_view.php', $data);

    }


    function action_edit(){

        if($_POST['check']){
            //save post
            if($_POST['action'] == 'Save'){

                $value = array(
                    'post_date'     => $_POST['post_date'],
                    'post_title'    => $_POST['post_title'],
                    'post_content'  => $_POST['post_content'],
                    'post_status'   => $_POST['post_status'],
                    'parent'        => $_POST['parent'],
                    'user_id'       => $_COOKIE['ID'],
                );

                $this->model->update_post( $_COOKIE['ID'], $_GET['id'], $value );
            }

            elseif (($_POST['action']) == 'Delete')
                $this->model->delete_post_by_id( $_GET['id'] );

            Route::go_to_page('todo');

        }

        if( $_GET['id'])
            $data = array(
                'post' => $this->model->get_post_by_id ( $_GET['id'] ),
                'childs'=> $this->model->get_children_post ( $_GET['id'] ),
            );

        $data['parents']=$this->model->get_posts_for_parent( $_COOKIE['ID'], $_GET['id'] );

        $this->view->generate('todo/edit_view.php', $data );
    }

}