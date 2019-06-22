<?php
class Controller
{
    protected $models = [];
    protected $user = false;

    public function __construct()
    {
        $this->user = new user();
    }


    public function getModel($name) 
    {
        if (isset($this->models[$name])){
            return $this->models[$name];
        }

        $modelPath = BASE_PATH.'models'.DS.$name.'_model.php';

        if (file_exists($modelPath)) {
            include $modelPath;
        } else {
            die('File does not exist!');
        };

        $modelName = 'model'.ucfirst($name);
        return $this->models[$name] = new $modelName();
    }
  
    public function createView($content_view, $template_view, $data = null){
        include_once 'views'.DS.$template_view;
    }

}
