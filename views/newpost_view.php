<form method="POST" action="?page=profile&action=createPost" enctype="multipart/form-data">
    <label>Title</label>
    <input name="title" />
    <label>Upload image</label>
    <input type="file" name="image"/>
    <label>Text</label>
    <textarea name="text" placeholder="Write your story here!" rows="30" cols="80"></textarea><br />
    <input type="submit" name='send' value='Post' />
</form>