<?php
/**
 * Class Route
 *
 * Connects Controller, Model, View.
 */
class Route
{

    private static
        $controller_name = 'User',
        $action_name = 'index';

    function __construct()
    {
        //get routes
        $routes = $this->get_routes();

        //set new controller and new action
        if( !empty($routes[1]) )
            $this->set_controller_name( $routes[1] );

        if( !empty($routes[2]) )
            $this->set_action_name( $routes[2] );

        $this->include_model();
        $action = sprintf('action_%s', self::$action_name);
        $controller = $this->get_controller_object();

        if( method_exists( $controller, $action ))
            //call the controller method
            $controller->$action();
    }

    /**
     * Get and explode request uri
     * @return array
     */
    public static function get_routes(): array
    {
        $routes = explode('/', $_SERVER['REQUEST_URI']);

        return $routes;
    }

    /**
     * Set $controller_name
     * @param string $controller_name
     */
    private function set_controller_name( string $controller_name ): void
    {
        if( $controller_name )
        self::$controller_name = $controller_name;
    }

    /**
     * Set action_name
     * @param string $action_name
     */
    private function set_action_name( string $action_name): void
    {
        if( $action_name )
            self::$action_name = $action_name;
    }

    /**
     * Get controller object
     * @return object
     */
    private function get_controller_object ( )
    {
        $controller_path = sprintf('application/controllers/controller_%s.php',strtolower( self::$controller_name ));
        $class_name = sprintf('Controller_%s', self::$controller_name);

        if(!file_exists( $controller_path ))
            $this->go_to_page('404');//перекинем на 404

        include_once $controller_path;

        $object=new $class_name;

        return $object;
    }

    /**
     * Include file model_name.php
     */
    private function include_model(): void
    {

        $model_path = sprintf('application/models/model_%s.php', strtolower( self::$controller_name ));

        if( file_exists( $model_path ))
            include_once $model_path ;
    }

    /**
     * Relocate to page
     * @param string $page
     */
    public function go_to_page(string $page): void
    {
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('Location:'.$host.$page);
        exit();
    }

}