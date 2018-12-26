<body>
<?php require_once ('todo-head.php');?>
<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-8 pt-2">
            <form class="card px-4 pt-3" method="post">
                <div class="card-header">
                    <input type="text" class="h6 w-100" placeholder="Имя" value="<?php echo $post['post_title'];?>" name="post_title" required>
                </div>

                <div class="card-body small">
                    <textarea class="card-text w-100" rows="10" cols="45" name="post_content" placeholder="Текст..." required><?php echo $post['post_content'];?></textarea>

                    <div class="py-3">
                        <small>Статус</small>
                        <select class="custom-select" name="post_status">
                            <option value="open" <?php echo selected( $post['post_status'],'open');?>>open</option>
                            <option value="done" <?php echo selected( $post['post_status'],'done');?>>done</option>
                            <option value="close" <?php echo selected( $post['post_status'],'close');?>>close</option>
                        </select>
                    </div>

                    <div class="py-3">
                        <small>Родитель</small>
                        <select class="custom-select" name="parent">
                            <option value="0">Без родителя</option>
                            <?php foreach( $parents as $parent) :?>
                            <option value="<?php echo $parent['post_id'];?>" <?php echo selected( $parent['post_id'],$post['parent']);?> ><?php echo $parent['post_title'];?></option>
                           <?php endforeach;?>
                        </select>
                    </div>

                    <?php if ($childs):?>
                    <div class="py-3">
                        <small>Дочерние</small>
                        <ul>
                            <?php foreach ($childs as $child):?>

                            <li ><a href="todo/edit/?id=<?php echo $child['post_id'];?>"  class="text-dark"><?php echo $child['post_title'];?></a></li>

                            <?php endforeach;?>
                        </ul>
                    </div>
                    <?php endif;?>

                </div>
                <div class="card-footer text-muted text-right py-3">
                    <input class="float-left d-inline-block small" name="post_date" type="date" min="2019-01-02" value="<?php echo $post['post_date'];?>" >
                    <input type="hidden" name="check" value="true">
                    <?php if ($post): ?>
                    <input type="submit" name="action" value="Delete" class="btn btn-outline-danger ">
                    <?php endif; ?>
                    <input type="submit" name="action" value="Save" class="btn btn-outline-success">
                </div>
            </form>

        </div>

    </div>



</body>