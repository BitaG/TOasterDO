<body>
<?php require_once('todo-head.php') ;?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 pt-2">
            <div class="card px-4 pt-3">
                <div class="card-header text-center pb-3">
                    <a href="/todo/edit/" class="text-dark">Добавить запись</a>
                </div>
                <div class="card-body">
                    <?php if( $posts ):?>

                    <ul class="list-group">
                        <?php foreach ( $posts as $post ):?>

                        <li class="list-group-item">
                                    <h6 class="<?php if( $post['post_status'] == 'done') echo 'text-success'?> font-weight-bold"> <?php echo $post['post_title'];?> </h6>
                                    <p class="small text-muted"><?php echo $post['post_content'];?></p>
                            <a href="/todo/edit/?id=<?php echo $post['post_id'];?>" class="edit"><i class="far fa-edit"></i></a>
                        </li>
                        <?php endforeach;?>
                    </ul>

                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>
</body>
<!--onclick="$(this).closest('form').submit()"-->