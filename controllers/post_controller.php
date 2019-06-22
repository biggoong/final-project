<?php
class controllerPost extends Controller
{
    protected $posts = false;

    public function __construct()
    {
        parent::__construct();
        $this->posts = new posts();
    }

    public function actionIndex()
    {
        $post_id = $_REQUEST['post_id'] ?? null;
        $post = false;
        $comments = false;
        $data = [];
        if (isset($post_id)) {
            $post = $this->posts->selectPost($post_id);
            $comments = $this->posts->selectComments($post_id);
        } else {
            throw new httpException(404, 'Page not found');
        }
        $data['user_id'] = $this->user->user_id;
        $data['post'] = $post[0];
        $data['comments'] = $comments;
        $this->createView('post_view.php', 'template_view.php', $data);
    }

    public function actionComment()
    {
        $error = '';
        if (isset($_POST['send'])) {
            try {
                unset($_POST['send']);
                $this->posts->createComment($_POST);
                header('location:?page=post&action=index&post_id='.$_POST['post_id']);
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
    }
};
