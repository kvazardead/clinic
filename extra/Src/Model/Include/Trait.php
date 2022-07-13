<?php

namespace Mixin;

trait ModelGet
{
    final public function setGet($data)
    {
        $this->get = $data;
    }

    final public function getGet(String $item = null)
    {
        return ($item == null) ? $this->get : $this->get[$item] ?? null;
    }
}

trait ModelPost
{
    final public function setPost($data)
    {
        $this->post = $data;
    }

    final public function getPost(String $item = null)
    {
        return ($item == null) ? $this->post : $this->post[$item] ?? null;
    }

    final public function setPostItem(String $item, $value = null)
    {
        $this->post[$item] = $value;
    }

    final public function deletePostItem(String $item)
    {
        unset($this->post[$item]);
    }
}

trait ModelFiles
{
    final public function setFiles($data)
    {
        $this->files = $data;
    }

    final public function getFiles(String $item = null)
    {
        return ($item == null) ? $this->files : $this->files[$item] ?? null;
    }
}

trait ModelTSave
{
    public function saveBefore(){
        $this->db->beginTransaction();
        $this->cleanPost();
    }

    public function saveBody(){
        $object = HellCrud::insert($this->table, $this->getPost());
        if (!is_numeric($object)) $this->error($object);
    }

    public function saveAfter(){
        $this->db->commit();
        $this->success();
    }
}

trait ModelTUpdate
{
    public function updateBefore(){
        $this->db->beginTransaction();
        $this->cleanGet();
        $this->cleanPost();
    }

    public function updateBody(){
        $object = HellCrud::update($this->table, $this->getPost(), $this->getGet());
        if (!is_numeric($object) and $object <= 0) $this->error($object);
    }

    public function updateAfter(){
        $this->db->commit();
        $this->success();
    }
}

trait ModelTDelete
{
    public function deleteBefore(){
        $this->db->beginTransaction();
        $this->cleanGet();
    }

    public function deleteBody(){
        $object = HellCrud::delete($this->table, $this->getGet('id'));
        if ($object <= 0) $this->error($object);
    }

    public function deleteAfter(){
        $this->db->commit();
        $this->success();
    }
}

trait ModelTJsonResponce
{
    public function success()
    {
        header('Content-type: application/json');
        echo json_encode(array(
            'status' => 'success'
        ));
        exit;
    }

    public function error($message)
    {
        header('Content-type: application/json');
        echo json_encode(array(
            'status' => 'error',
            'message' => $message
        ));
        if($this->db->inTransaction()) $this->db->rollBack();
        exit;
    }
}

trait ModelHook
{
    final public function urlHook(String $otherModel = null)
    {
        return Hell::apiHook( array_merge( array("model" => ($otherModel) ? $otherModel : get_class($this)), $this->getGet() ) );
    }
}

?>