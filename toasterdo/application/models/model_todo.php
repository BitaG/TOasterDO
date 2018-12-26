<?php
class Model_Todo{

    /**
     * Get All post for user by user_id
     * @param int $user_id
     * @return array
     */
    public function get_posts ( int $user_id ): array
    {
        $db  = new SafeMySQL();
        $sql = " SELECT * FROM posts INNER JOIN users ON posts.user_id = users.ID WHERE user_id = ?i ORDER BY posts.post_date DESC ";
        $posts  = $db->getAll( $sql, $user_id );

        return $posts;
    }

    /**
     * Get post by ID
     * @param int $post_id
     * @return array
     */
    public function get_post_by_id( int $post_id ): array
    {
        $db  = new SafeMySQL();
        $sql = " SELECT * FROM posts  WHERE post_id = ?i ";
        $posts  = $db->getRow( $sql, $post_id );

        return $posts;
}

    /**
     * Delete post by id
     * @param int $post_id
     */
    public function delete_post_by_id( int $post_id ): void
    {

       $children_ids = $this->get_children_post_ids( $post_id );

       if ($children_ids)
           $sql_part = sprintf(" IN (%s, %d)",implode(', ',$children_ids), $post_id);
        else
            $sql_part = sprintf(" = %d",$post_id);

        $sql = "DELETE FROM posts WHERE post_id".$sql_part;

       $db = new SafeMySQL();
       $db->query( $sql );

   }


    /**
     * Get children posts id
     * @param int $parent
     * @return array
     */
    public function get_children_post_ids( int $parent ): array
    {
        $db = new SafeMySQL();
        $posts = $db->getCol(" SELECT post_id FROM posts WHERE parent = ?i", $parent);

        return $posts;
   }


    /**
     * Get Child post
     * @param int $parent
     * @return array
     */
    public function get_children_post( int $parent ): array
    {
       $db = new SafeMySQL();
       $posts = $db->getAll(" SELECT post_id, post_title, post_status FROM posts WHERE parent = ?i", $parent);

       return $posts;
   }


    /**
     * Get post for parent list
     * @param int $user_id
     * @param int|null $post_id
     * @return array|null
     */
    public function get_posts_for_parent(   int $user_id,  ?int $post_id = null): ?array
    {
       $posts = $this->get_posts( $user_id );
       if ($post_id == NULL ) return $posts ;

       $child_ids = $this->get_children_post_ids( $post_id );

       foreach ($posts as $post){
           if( in_array($post['post_id'], $child_ids) || $post['post_id'] == $post_id) continue; // skip child

           $result[]=array(
               'post_id' => $post['post_id'],
               'post_title' =>$post['post_title'],
                );
        }

        return $result;
    }


    /**
     * Update post
     * @param int|null $user_id
     * @param int|null $post_id
     * @param array|null $value
     * @return bool
     */
    public function update_post( int $user_id = null, int $post_id = null, ?array  $value = null ): bool
    {
        if (  $user_id == null ) return false;
        if (  $post_id ){

            $child_ids = $this->get_children_post_ids($post_id);

            //if have child and post_status == done
            if( $child_ids && $value['post_status']=='done' ) {
                foreach ($child_ids as $child_id )
                    $this->update_post( $user_id, $child_id, array('post_status'=>'done'));
            }

            //if have parent and  and post_status == done
            if( $value['parent'] !=0 && $value['post_status']=='done'){

                //we take the children of our father and check whether they all have post_status = done
                $child_status_check = $this->child_status_is_by_parent_id($value['parent']);
                if($child_status_check) $this->update_post( $user_id, $value['parent'], array('post_status'=>'done'));
            }

            $sql= "UPDATE posts SET ?u WHERE post_id =".$post_id;
        }

        else
            $sql= "INSERT posts SET ?u";

        $db  =  new SafeMySQL();
        $db->query($sql, $value);

        return true;
   }


    /**
     * Get children post status with a $status
     *
     * @param integer $parent_id
     * @param string $status
     * @return bool ( true - if ALL children post status == $status   )
     *
     */
    function child_status_is_by_parent_id( $parent_id, $status='done' ): bool
    {
       $chidren_posts = $this->get_children_post( $parent_id );

       foreach ($chidren_posts as $child){
           if( $child['post_status'] !=$status )
               return false;
       }

       return true;
   }

}
