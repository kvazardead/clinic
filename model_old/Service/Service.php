<?php

use Mixin\ModelOld;

class ServiceModel extends ModelOld
{
    public $table = 'services';
    public $table_label = array(
        'DIS_mark' => 'Отдел',
        's.code' => 'Код',
        's.name' => 'Услуга',
        's.price' => 'Цена',
        's.price_foreigner' => 'Цена для иностранцев',
        's.type' => 'Тип(1,2,3)',
    );

    public function form_template($pk = null)
    {
        ?>
        <form method="post" action="<?= add_url() ?>" enctype="multipart/form-data">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">

            <div class="form-group">
                <label>Шаблон:</label>
                <input type="file" class="form-control" name="template" accept="application/vnd.ms-excel" required>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Внести</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>
        <?php
    }

    public function form($pk = null)
    {
        global $db, $PERSONAL, $classes;
        if( isset($_SESSION['message']) ){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">

            <div class="form-group row">

                <div class="col-md-5">
                    <label>Выбирите Роль:</label>
                    <select data-placeholder="Выбрать роль" name="user_level" id="user_level" class="<?= $classes['form-select'] ?>" required>
                        <option></option>
                        <?php foreach ($PERSONAL as $key => $value): ?>
                            <?php if(!in_array($key, [1,2,3,4,7,8,14,32])): ?>
                                <option value="<?= $key ?>"<?= ($this->value('user_level') == $key) ? 'selected': '' ?>><?= $value ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label>Отдел:</label>
                    <select data-placeholder="Выбрать отдел" name="division_id" id="division_id" class="<?= $classes['form-select'] ?>" required >
                        <option></option>
                        <?php foreach ($db->query("SELECT * FROM divisions") as $row): ?>
                            <option value="<?= $row['id'] ?>" data-chained="<?= $row['level'] ?>" <?= ($this->value('division_id') == $row['id']) ? 'selected': '' ?>><?= $row['title'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-3">
                    <label>Тип:</label>
                    <select name="type" class="<?= $classes['form-select'] ?>" required>
                        <option value="1" <?= ($this->value('type') == 1) ? 'selected': '' ?>>Обычная</option>
                        <option value="2" <?= ($this->value('type') == 2) ? 'selected': '' ?>>Консультация</option>
                        <option value="3" <?= ($this->value('type') == 3) ? 'selected': '' ?>>Операционная</option>
                    </select>
                </div>

            </div>

            <div class="form-group row">

                <div class="col-md-8">
                    <label>Название:</label>
                    <input type="text" class="form-control" name="name" placeholder="Введите название" required value="<?= $this->value('name') ?>">
                </div>

                <div class="col-md-4">
                    <label>Код:</label>
                    <input type="text" class="form-control" name="code" placeholder="Введите код" value="<?= $this->value('code') ?>">
                </div>
            </div>

            <div class="form-group row">

                <div class="col-md-3">
                    <label>Цена:</label>
                    <input type="text" class="form-control input-price" name="price" placeholder="Введите цену" required value="<?= number_format($this->value('price')) ?>">                    
                </div>

                <div class="col-md-3">
                    <label>Цена(для иностранецев):</label>
                    <input type="text" class="form-control input-price" name="price_foreigner" placeholder="Введите цену" required value="<?= number_format($this->value('price_foreigner')) ?>">
                </div>

            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Сохранить</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>
        <script type="text/javascript">

            $(function(){
                $("#division_id").chained("#user_level");
            });

            $(".input-price").on("input", function (event) {
                if (isNaN(Number(event.target.value.replace(/,/g, "")))) {
                    try {
                        event.target.value = event.target.value.replace(
                            new RegExp(event.originalEvent.data, "g"),
                            ""
                        );
                    } catch (e) {
                        event.target.value = event.target.value.replace(
                            event.originalEvent.data,
                            ""
                        );
                    }
                } else {
                    event.target.value = number_with(
                        event.target.value.replace(/,/g, "")
                    );
                }
            });

        </script>
        <?php
        if ($pk) {
            $this->jquery_init();
        }
    }

    public function clean()
    {
        if( isset($_FILES['template']) and $_FILES['template'] ){
            $this->post['template'] = read_excel($_FILES['template']['tmp_name']);
            $this->save_excel();
        }
        $this->post['price'] = (isset($this->post['price'])) ? str_replace(',', '', $this->post['price']) : 0;
        $this->post['price_foreigner'] = (isset($this->post['price_foreigner'])) ? str_replace(',', '', $this->post['price_foreigner']) : 0;
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        if($this->post['user_level'] and !$this->post['division_id']){
            $this->post['division_id'] = null;
        }
        return True;
    }

    public function clean_excel($old_post)
    {
        global $db;
        $post = [];
        if ($this->table_label) {
            foreach ($this->table_label as $key => $value) {
                $key = str_replace("s.", "", $key);
                if ($key == "DIS_mark") $key = "division_id";
                $post[$key] = $old_post[$value];
            }
        }
        
        $post['price'] = preg_replace("/,+/", "", $post['price']);
        $post['price_foreigner'] = preg_replace("/,+/", "", $post['price_foreigner']);
        $dis = $db->query("SELECT id, level FROM divisions WHERE mark = '{$post['division_id']}'")->fetch();
        $post['user_level'] = $dis['level'];
        $post['division_id'] = $dis['id'];
        return $post;
    }

    public function save_excel()
    {
        global $db;
        $db->beginTransaction();
        $keys = $this->post['template'][0];
        unset($this->post['template'][0]);

        foreach ($this->post['template'] as $value) {
            $post = [];
            foreach ($keys as $k => $key) {
                $post[$key] = $value[$k];
            }
            if ($post = $this->clean_excel($post)) {
                $object = Mixin\insert_or_update($this->table, $post, "code");
                if (!intval($object)){
                    $this->error($object);
                    $db->rollBack();
                }
            }
        }

        $db->commit();
        $this->success();
    }

    public function success()
    {
        $_SESSION['message'] = '
        <div class="alert alert-primary" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            Успешно
        </div>
        ';
        render();
    }

    public function error($message)
    {
        $_SESSION['message'] = '
        <div class="alert bg-danger alert-styled-left alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            <span class="font-weight-semibold"> Введены некорректные данные!</span>
        </div>
        ';
        render();
    }
}

?>