<?php

class View
{
    public function generate( string $content_view, array $data = array() ): void
	{
	    extract( $data, EXTR_PREFIX_SAME, "wddx" );

        include 'application/views/header.php'; //header file
        include 'application/views/'.$content_view; //content view file
        include 'application/views/footer.php'; //footer file

	}

}
