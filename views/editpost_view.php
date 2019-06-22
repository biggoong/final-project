<p><?php $post = $data['post'];?></p>
<form method="POST" action="?page=profile&action=editPost&post_id=<?php echo $post['post_id'] ?>" enctype="multipart/form-data">
    <label>Title</label>
    <input name="title" value="<?php echo $post['title']; ?>"/>
    <label>Upload image</label>
    <input type="file" name="image"/>
    <label>Text</label>
    <textarea name="text" rows="30" cols="80"><?php echo $post['text'] ?></textarea><br />
    <input type="submit" name='send' value='Save' />
</form>