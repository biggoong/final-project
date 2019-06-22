<?php
class controllerMain extends Controller
{
    protected $posts = false;

    public function __construct()
    {
        parent::__construct();
        $this->posts = new posts();
    }

    public function actionIndex()
    {
        $all_posts = $this->posts->selectAllPosts();
        $data = [];
        $data['user'] = $this->user->user_id;
        $data['posts'] = $all_posts;
        $this->createView('main_view.php', 'template_view.php', $data);
    }
}
