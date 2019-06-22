<?php
spl_autoload_register('core::loadClass');
class Core
{
    public function _construct()
    { }

    public static function loadClass($className)
    {
        include_once BASE_PATH.'classes'.DS.$className.'.php';
    }

   /*  public function start()
    {
        $controller = empty($_REQUEST['page']) ? 'main' : $_REQUEST['page'];
        $action = empty($_REQUEST['action']) ? 'index' : $_REQUEST['action'];

        $controllerPath = BASE_PATH.'controllers'.DS.$controller.'_controller.php';

        if (file_exists($controllerPath)) {
            include $controllerPath;
        } else {
            die('Page not found!');
        };

        $constrollerName = 'controller' . ucfirst($controller);
        $controller = new $constrollerName;

        $actionName = 'action' . ucfirst($action);
        return $controller->$actionName();
    } */

    protected function runAction($controller, $action)
    {
        $c_path = BASE_PATH.'controllers/'.$controller.'_controller.php';
        if(@!include $c_path) {
            throw new httpException(404, 'Controller '.$controller.' not found');
        }
        $c_name = 'controller'.ucfirst($controller);
        $controller = new $c_name;
        $a_name = 'action'.ucfirst($action);
        if (!method_exists($controller, $a_name)){
            throw new httpException(404, 'Action '.$a_name.' not found');
        }

        return $controller->$a_name();
    }

    public function start()
    {
        try {
            $this->runAction($_REQUEST['page'] ?? 'main', $_REQUEST['action'] ?? 'index');
        } catch (httpException $e) {
            $e->sendHttpHeader();
            $this->runAction('errors', 'notfound');
            $this->log->error($e->getMessage(), 'http');
        } catch (Exception $e) {
            echo 'CORE On';
            $this->log->error($e->getMessage(), 'common');
            throw $e;
        }

    }

}