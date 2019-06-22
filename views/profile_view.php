<?php include 'views/logout_view.php'; ?>
<div class="profile-container">
    <div class="avatar-container">
        <img class="avatar" src="static/avatar.jpeg" alt="avatar" width="200" height="200" />
    </div>
    <h4><?php echo ($data['user']); ?></h4>
    <div class="login-navbar">
        <a class="creat-post" href="?page=profile&action=createPost">New Post</a>
    </div>
    <div>
        <?php if ($data['posts']) {
            foreach ($data['posts'] as $post) {
                echo '<div class="all-post">';
                if (!empty($post['image_url'])) {
                    echo '<div><img src="' . $post['image_url'] . '" alt=image height="200px"/></div>';
                }
                echo '<div><h4><a href="?page=post&action=index&post_id=' . $post['post_id'] . '">' . 
                $post['title'] . '</a></h4>
                <p>' . $post['short_desc'] . '</p>
                <h6><a href="?page=post&action=index&post_id=' . $post['post_id'] . '">Read more</a></h6>
                <p>'.$post['likes'].'<i class="material-icons" style="color:#4299D2;">thumb_up</i>'.
                $post['dislikes'].'<i class="material-icons" style="color:#4299D2;">thumb_down</i></p>
                <div class="login-navbar">
                <a class="edit-post" href="?page=profile&action=editPost&post_id=' . 
                $post['post_id'] . '">Edit Post</a>
                <a class="delete-post" href="?page=profile&action=deletePost&post_id=' . 
                $post['post_id'] . '">Delete Post</a>
                </div>
                </div></div><hr/>';
            }
        }
        ?>
    </div>
</div>