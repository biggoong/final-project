<?php
class controllerUser extends Controller
{
    public function actionRegistration()
    {
        $error = '';
        if (isset($_POST['send'])) {
            if ($_POST['password'] !== $_POST['password_confirm']) {
                $error = 'Password confirm wrong!';
            } else {
                unset($_POST['password_confirm'], $_POST['send']);
                try {
                    $reg_token = $this->user->reg($_POST);
                    header('location:?page=userCheck');
                    return;
                } catch (Exception $e) {
                    $error = $e->getMessage();
                }
            }
        }
        $this->createView('registration_view.php', 'template_view.php', $error);
    }

    public function actionLogin()
    {
        $data = [];
        $account_token = $_REQUEST['account_token'] ?? '';
        $error = '';

        if (isset($_POST['send'])) {
            try {
                unset($_POST['send']);
                $res = $this->user->login($_POST);
                header('location:?page=profile&action=index');
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }

        $data['account_token'] = $account_token;
        $data['error'] = $error;
        $this->createView('login_view.php', 'template_view.php', $data);
    }

    public function actionLogout()
    {
        $this->user->logout();
    }
}
