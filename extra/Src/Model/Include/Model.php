<?php

namespace Mixin;

abstract class Model extends Credo implements ModelInterface
{
    /**
     * 
     * Model
     * 
     * @version 9.1
     */

    private $get = [];
    private $post = [];
    private $files = [];
    protected $table = '';

    use 
        ModelSetter, 
        ModelGetter,
        ModelTSave, 
        ModelTUpdate, 
        ModelTDelete,
        ModelTResponce,
        ModelHook;


    final public function call(String $action = null, Array $get = null, Array $post = null, Array $files = null)
    {
        if ($get != null) $this->setGet($get);
        if ($post != null) $this->setPost($post);
        if ($files != null) $this->setFiles($files);
        $this->action($action);
    }

    private function action(String $action = null){
        if ($action == "get") $this->getElement();
        elseif ($action == "save") $this->save();
        elseif ($action == "delete") $this->delete();
        elseif ($action == "update") $this->update();
        elseif ($action == "axe") $this->axeElement();
        else $this->error("NOT ACTION!");
    }

    private function axeElement()
    {
        if (method_exists(get_class($this), 'axe')) $this->{'axe'}();
        else Hell::error("403");
    }

    private function getElement()
    {
        if (isset($this->get['form']) and empty($this->get['id'])) {

            $form = $this->get['form'];
            unset($this->get['form']);
            if (method_exists(get_class($this), $form)) $this->{$form}();

        }else{
            $object = $this->byId($this->get['id']);

            if ($object) {
                
                if(isset($this->get['form'])) {
                    
                    $this->setPost($object);
                    $form = $this->get['form'];
                    unset($this->get['form']);
                    if (method_exists(get_class($this), $form)) $this->{$form}();
                    else Hell::error("403");
    
                }else {

                    header('Content-type: application/json');
                    echo json_encode($object);

                }

            } else Hell::error("403");
        }
    }

    private function save(){
        $this->saveBefore();
        $this->saveBody();
        $this->saveAfter();
    }

    private function update(){
        $this->updateBefore();
        $this->updateBody();
        $this->updateAfter();
    }

    private function delete(){
        $this->deleteBefore();
        $this->deleteBody();
        $this->deleteAfter();
    }

    final public function csrfToken(){
        $token = bin2hex(random_bytes(24));
        $_SESSION['CSRFTOKEN'] =  $token;
        echo "<input type=\"hidden\" name=\"csrf_token\" value=\"$token\">";
    }

    public final function cleanGet()
    {
        $this->get = HellCrud::clean_form($this->get);
        $this->get = HellCrud::to_null($this->get);
    }

    public final function cleanPost()
    {
        $this->post = HellCrud::clean_form($this->post);
        $this->post = HellCrud::to_null($this->post);
    }

    protected function value(String $column = null)
    {
        return (isset($this->getPost()->{$column})) ? $this->getPost()->{$column} : null;
    }

    final public function stop()
    {
        exit;
    }

    final public function dd()
    {
        parad("Get", $this->getGet());
        parad("Post", $this->getPost());
        parad("Files", $this->getFiles());
        $this->stop();
    }

}

?>