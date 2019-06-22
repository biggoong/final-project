<div>
    <h2><?php echo $data['post']['title'] ?></h2>
    <p>Author: <i><b><?php echo $data['post']['nickname'] ?></b></i></p>
    <h6>Created: <?php echo $data['post']['publication_time'] ?></h6>
    <p><?php echo $data['post']['likes'] ?><i class="material-icons" style="color:#4299D2;">thumb_up</i>
    <?php echo $data['post']['dislikes'] ?><i class="material-icons" style="color:#4299D2;">thumb_down</i></p>
    <div><img src="<?php echo $data['post']['image_url'] ?>" alt=image height="500px"/></div>
    <p><?php echo $data['post']['text'] ?></p>
</div>
<hr/>
<?php if ($data['user_id'] == $data['post']['user_id']){
echo '<div class="login-navbar">
    <a class="edit-post" href="?page=profile&action=editPost&post_id='.$data['post']['post_id'].'">
    Edit Post</a>
    <a class="delete-post" href="?page=profile&action=deletePost&post_id='.$data['post']['post_id'].'">
    Delete Post</a>
</div>';
};
?>
<div><p>Comments:</p></div>
<?php
if(isset($data['comments'])){
    foreach($data['comments'] as $comment){
        echo '<div class="comments">
        <div><p><i><b>'.$comment['nickname'].'</b></i></p>
        <h6>Created: '.$comment['publication_time'].'</h6></div>
        <div><p>'.$comment['text'].'</p></div>
        </div>';
    }
} else {
    echo '<p>No comments yet!!!!!</p>';
}
?>
<?php
if (isset($data['user_id'])){
    echo
    '<form method="POST" action="?page=post&action=comment">
    <input type="hidden" name="user_id" value="'.$data['user_id'].'" />
    <input type="hidden" name="post_id" value="'.$data['post']['post_id'].'" />
    <textarea name="text" placeholder="Leave your comment here!" rows="7" cols="80"></textarea><br />
    <input type="submit" name="send" value="Post" />
</form>';
};
?>
