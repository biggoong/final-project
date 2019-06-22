<?php
class controllerProfile extends Controller
{
    protected $posts = false;

    public function __construct()
    {
        parent::__construct();
        $this->posts = new posts();
    }

    public function actionIndex()
    {
        $all_posts = $this->posts->selectAllPostsByUser($this->user->user_id);
        $data = [];
        $data['user'] = $this->user->nickname;
        $data['posts'] = $all_posts;
        $this->createView('profile_view.php', 'template_view.php', $data);
    }

    public function uploadImage()
    {
        $target_dir = BASE_PATH . "static/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            die("File is not an image.");
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            die("Sorry, file already exists.");
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["image"]["size"] > 200000) {
            die("Sorry, your file is too large.");
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            die("Sorry, your file was not uploaded.");
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                return "static/" . basename($_FILES["image"]["name"]);
            } else {
                die("Sorry, there was an error uploading your file.");
            }
        }
    }

    public function actionCreatePost()
    {
        $user_id = $this->user->user_id;
        $error = '';
        $image_url = '';
        if (isset($_POST['send'])) {
            if (!empty($_FILES["image"]["name"])) {
                $image_url = $this->uploadImage();
            }
            if (!empty($_POST['title']) && !empty($_POST['text'])) {
                try {
                    unset($_POST['send']);
                    $this->posts->createPost($_POST, $image_url, $user_id);
                    header('location:?page=profile&action=index');
                } catch (Exception $e) {
                    $error = $e->getMessage();
                }
            }
        }
        $this->createView('newpost_view.php', 'template_view.php');
    }

    public function actionEditPost()
    {
        $post_id = $_REQUEST['post_id'] ?? 0;
        $post = false;
        $data = [];
        $image_url = '';
        $error = '';
        if (!empty($post_id)) {
            $post = $this->posts->selectPost($post_id);
            $data['user_id'] = $this->user->user_id;
            $data['post'] = $post[0];
            if ($data['user_id'] == $data['post']['user_id']) {
                if (isset($_POST['send'])) {
                    if (!empty($_FILES["image"]["name"])) {
                        $image_url = $this->uploadImage();
                    }
                    if (!empty($_POST['title']) && !empty($_POST['text'])) {
                        try {
                            unset($_POST['send']);
                            $this->posts->editPost($_POST, $image_url, $post_id);
                            header('location:?page=post&action=index&post_id=' . $post_id);
                        } catch (Exception $e) {
                            $error = $e->getMessage();
                        }
                    }
                }
            }
        } else {
            throw new httpException(404, 'Post not found!');
        }

        $this->createView('editpost_view.php', 'template_view.php', $data);
    }

    public function actionDeletePost()
    {
        $post_id = $_REQUEST['post_id'] ?? 0;
        if (!empty($post_id)) {
            $post = $this->posts->selectPost($post_id);
            $data['user_id'] = $this->user->user_id;
            $data['post'] = $post[0];
            if ($data['user_id'] == $data['post']['user_id']) {
                $this->posts->deletePost($post_id);
                header('location:?page=profile&action=index');
            }
        } else {
            throw new httpException(404, 'Post not found!');
        }
    }
}
