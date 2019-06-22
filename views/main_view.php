<?php if (isset($data['user'])) {
    include 'views/logout_view.php';
    echo '<h4>You are in!</h4>';
} else {
    echo '<div class="login-navbar"><a class="signin" href="?page=user&action=registration">Sign in</a>
    <a class="login" href="?page=user&action=login">Login</a></div>';
}; ?>
<div>
    <?php if ($data['posts']['posts']) {
        foreach ($data['posts']['posts'] as $post) {
            
            echo '<div class="all-post">';

            if (!empty($post['image_url'])) {
                echo '<div><img src="' . $post['image_url'] . '" alt=image height="200px"/></div>';
            }

            echo '<div><h4><a href="?page=post&action=index&post_id=' . $post['post_id'] . '">' . $post['title'] . '</a></h4>
                <p>Author: <i><b>'.$post['nickname'].'</b></i></p>
                <h6>Created: '.$post['publication_time'].'</h6>
                <p>' . $post['short_desc'] . '</p>
                <h6><a href="?page=post&action=index&post_id=' . $post['post_id'] . '">Read more</a></h6>
                <p>'.$post['likes'].'<i class="material-icons" style="color:#4299D2;">thumb_up</i>'.
                $post['dislikes'].'<i class="material-icons" style="color:#4299D2;">thumb_down</i></p>';

            foreach($data['posts']['comments_count'] as $comment_count){
                if($comment_count['post_id'] === $post['post_id']){
                    echo '<p>'.$comment_count['comments_count'].' comments</p>';
                }
            }

            echo '</div>';
            
            echo '</div><hr/>';
        }
    }
    ?>
</div>