<?php
class controllerUsercheck extends Controller
{
    protected $db;
    public $dataUserCheck = false;

    public function __construct()
    {
        $this->db = sql::getInstance();
        $this->dataUserCheck = $this->db->select('users', 'nickname, account_token', ['status' => 1]);
    }

    public function actionIndex()
    {
        $this->createView('usercheck_view.php', 'template_view.php', $this->dataUserCheck);
    }

}
