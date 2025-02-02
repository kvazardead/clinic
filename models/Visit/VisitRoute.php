<?php

class VisitRoute extends Model
{
    public $table = 'visit';

    public function form_out($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="route_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="grant_id" value="<?= $patient->grant_id ?>">
            <input type="hidden" name="user_id" value="<?= $patient->id ?>">

            <div class="form-group">
                <label>Отделы</label>
                <select data-placeholder="Выбрать отдел" multiple="multiple" id="division_selector" class="form-control select" onchange="table_change(this)" data-fouc>
                    <?php foreach ($db->query("SELECT * from division WHERE level in (5) AND id !=". division()) as $row): ?>
                        <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group-feedback form-group-feedback-right row">

                <div class="col-md-10">
                    <input type="text" class="form-control border-info" id="search_input" placeholder="Введите ID или имя">
                    <div class="form-control-feedback">
                        <i class="icon-search4 font-size-base text-muted"></i>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="text-right">
                        <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                            <span class="ladda-label">Сохранить</span>
                            <span class="ladda-spinner"></span>
                        </button>
                    </div>
                </div>

            </div>

            <div class="form-group">

                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr class="bg-dark">
                                <th>#</th>
                                <th>Отдел</th>
                                <th>Услуга</th>
                                <th>Доктор</th>
                                <th style="width: 100px">Кол-во</th>
                                <th class="text-right">Цена</th>
                            </tr>
                        </thead>
                        <tbody id="table_form">

                        </tbody>
                    </table>
                </div>

            </div>

        </form>
        <script type="text/javascript">

            let service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table_search') ?>",
                    data: {
                        divisions: $("#division_selector").val(),
                        search: $("#search_input").val(),
                        selected: service,
                        types: "1,2",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });
            });

            function table_change(the) {

                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
                    data: {
                        divisions: $(the).val(),
                        selected: service,
                        types: "1,2",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });

            }

        </script>
        <?php
    }

    public function form_sta($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="direction" value="1">
            <input type="hidden" name="status" value="1">
            <input type="hidden" name="route_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="grant_id" value="<?= $patient->grant_id ?>">
            <input type="hidden" name="user_id" value="<?= $patient->id ?>">

            <div class="form-group">
                <label>Отделы</label>
                <select data-placeholder="Выбрать отдел" multiple="multiple" id="division_selector" class="form-control select" onchange="table_change(this)" data-fouc>
                    <?php foreach ($db->query("SELECT * from division WHERE level in (5) AND id !=". division()) as $row): ?>
                        <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group-feedback form-group-feedback-right row">

                <div class="col-md-10">
                    <input type="text" class="form-control border-info" id="search_input" placeholder="Введите ID или имя">
                    <div class="form-control-feedback">
                        <i class="icon-search4 font-size-base text-muted"></i>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="text-right">
                        <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                            <span class="ladda-label">Сохранить</span>
                            <span class="ladda-spinner"></span>
                        </button>
                    </div>
                </div>

            </div>

            <div class="form-group">

                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr class="bg-dark">
                                <th>#</th>
                                <th>Отдел</th>
                                <th>Услуга</th>
                                <th>Доктор</th>
                                <th style="width: 100px">Кол-во</th>
                                <th class="text-right">Цена</th>
                            </tr>
                        </thead>
                        <tbody id="table_form">

                        </tbody>
                    </table>
                </div>

            </div>

        </form>
        <script type="text/javascript">
            let service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table_search') ?>",
                    data: {
                        divisions: $("#division_selector").val(),
                        search: $("#search_input").val(),
                        selected: service,
                        types: "1,2",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });
            });

            function table_change(the) {

                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
                    data: {
                        divisions: $(the).val(),
                        selected: service,
                        types: "1,2",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });

            }
        </script>
        <?php
    }

    public function form_out_labaratory($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="route_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="grant_id" value="<?= $patient->grant_id ?>">
            <input type="hidden" name="user_id" value="<?= $patient->id ?>">

            <div class="form-group">
                <label>Лаборатория</label>
                <select data-placeholder="Выбрать отдел" multiple="multiple" id="division_selector" class="form-control select" onchange="table_change(this)" data-fouc>
                    <?php foreach ($db->query("SELECT * from division WHERE level in (6)") as $row): ?>
                        <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group-feedback form-group-feedback-right row">

                <div class="col-md-10">
                    <input type="text" class="form-control border-info" id="search_input" placeholder="Введите ID или имя">
                    <div class="form-control-feedback">
                        <i class="icon-search4 font-size-base text-muted"></i>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="text-right">
                        <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                            <span class="ladda-label">Сохранить</span>
                            <span class="ladda-spinner"></span>
                        </button>                    
                    </div>
                </div>

            </div>

            <div class="form-group">

                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr class="bg-dark">
                                <th>#</th>
                                <th>Отдел</th>
                                <th>Услуга</th>
                                <!-- <th>Тип</th> -->
                                <th>Доктор</th>
                                <th style="width: 100px">Кол-во</th>
                                <th class="text-right">Цена</th>
                            </tr>
                        </thead>
                        <tbody id="table_form">

                        </tbody>
                    </table>
                </div>

            </div>

        </form>
        <script type="text/javascript">

            let service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table_search') ?>",
                    data: {
                        divisions: $("#division_selector").val(),
                        search: $("#search_input").val(),
                        selected: service,
                        types: "1,2",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });
            });

            function table_change(the) {

                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
                    data: {
                        divisions: $(the).val(),
                        selected: service,
                        types: "1,2",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });

            }
        </script>
        <?php
    }

    public function form_sta_labaratory($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="direction" value="1">
            <input type="hidden" name="status" value="1">
            <input type="hidden" name="route_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="grant_id" value="<?= $patient->grant_id ?>">
            <input type="hidden" name="user_id" value="<?= $patient->id ?>">

            <div class="form-group">
                <label>Лаборатория</label>
                <select data-placeholder="Выбрать отдел" multiple="multiple" id="division_selector" class="form-control select" onchange="table_change(this)" data-fouc>
                    <?php foreach ($db->query("SELECT * from division WHERE level in (6)") as $row): ?>
                        <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group-feedback form-group-feedback-right row">

                <div class="col-md-10">
                    <input type="text" class="form-control border-info" id="search_input" placeholder="Введите ID или имя">
                    <div class="form-control-feedback">
                        <i class="icon-search4 font-size-base text-muted"></i>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="text-right">
                        <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                            <span class="ladda-label">Сохранить</span>
                            <span class="ladda-spinner"></span>
                        </button>
                    </div>
                </div>

            </div>

            <div class="form-group">

                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr class="bg-dark">
                                <th>#</th>
                                <th>Отдел</th>
                                <th>Услуга</th>
                                <!-- <th>Тип</th> -->
                                <th>Доктор</th>
                                <th style="width: 100px">Кол-во</th>
                                <th class="text-right">Цена</th>
                            </tr>
                        </thead>
                        <tbody id="table_form">

                        </tbody>
                    </table>
                </div>

            </div>

        </form>
        <script type="text/javascript">
            let service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table_search') ?>",
                    data: {
                        divisions: $("#division_selector").val(),
                        search: $("#search_input").val(),
                        selected: service,
                        types: "1,2",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });
            });

            function table_change(the) {

                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
                    data: {
                        divisions: $(the).val(),
                        selected: service,
                        types: "1,2",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });

            }
        </script>
        <?php
    }

    public function form_out_diagnostic($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="route_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="grant_id" value="<?= $patient->grant_id ?>">
            <input type="hidden" name="user_id" value="<?= $patient->id ?>">

            <div class="form-group">
                <label>Отделы</label>
                <select data-placeholder="Выбрать отдел" multiple="multiple" id="division_selector" class="form-control select" onchange="table_change(this)" data-fouc>
                    <?php
                    foreach($db->query("SELECT * from division WHERE level = 10 AND (assist IS NULL OR assist = 1)") as $row) {
                        ?>
                        <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <div class="form-group-feedback form-group-feedback-right row">

                <div class="col-md-10">
                    <input type="text" class="form-control border-info" id="search_input" placeholder="Введите ID или имя">
                    <div class="form-control-feedback">
                        <i class="icon-search4 font-size-base text-muted"></i>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="text-right">
                        <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                            <span class="ladda-label">Сохранить</span>
                            <span class="ladda-spinner"></span>
                        </button>
                    </div>
                </div>

            </div>

            <div class="form-group">

                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr class="bg-dark">
                                <th>#</th>
                                <th>Отдел</th>
                                <th>Услуга</th>
                                <!-- <th>Тип</th> -->
                                <th>Доктор</th>
                                <th style="width: 100px">Кол-во</th>
                                <th class="text-right">Цена</th>
                            </tr>
                        </thead>
                        <tbody id="table_form">

                        </tbody>
                    </table>
                </div>

            </div>

        </form>
        <script type="text/javascript">

            let service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table_search') ?>",
                    data: {
                        divisions: $("#division_selector").val(),
                        search: $("#search_input").val(),
                        selected: service,
                        types: "1",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });
            });

            function table_change(the) {

                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
                    data: {
                        divisions: $(the).val(),
                        selected: service,
                        types: "1",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });

            }

        </script>
        <?php
    }

    public function form_sta_diagnostic($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="direction" value="1">
            <input type="hidden" name="status" value="1">
            <input type="hidden" name="route_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="grant_id" value="<?= $patient->grant_id ?>">
            <input type="hidden" name="user_id" value="<?= $patient->id ?>">

            <div class="form-group">
                <label>Отделы</label>
                <select data-placeholder="Выбрать отдел" multiple="multiple" id="division_selector" class="form-control select" onchange="table_change(this)" data-fouc>
                    <?php
                    foreach($db->query("SELECT * from division WHERE level = 10 AND (assist IS NULL OR assist = 1)") as $row) {
                        ?>
                        <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <div class="form-group-feedback form-group-feedback-right row">

                <div class="col-md-10">
                    <input type="text" class="form-control border-info" id="search_input" placeholder="Введите ID или имя">
                    <div class="form-control-feedback">
                        <i class="icon-search4 font-size-base text-muted"></i>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="text-right">
                        <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                            <span class="ladda-label">Сохранить</span>
                            <span class="ladda-spinner"></span>
                        </button>                    
                    </div>
                </div>

            </div>

            <div class="form-group">

                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr class="bg-dark">
                                <th>#</th>
                                <th>Отдел</th>
                                <th>Услуга</th>
                                <!-- <th>Тип</th> -->
                                <th>Доктор</th>
                                <th style="width: 100px">Кол-во</th>
                                <th class="text-right">Цена</th>
                            </tr>
                        </thead>
                        <tbody id="table_form">

                        </tbody>
                    </table>
                </div>

            </div>

        </form>
        <script type="text/javascript">
            let service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table_search') ?>",
                    data: {
                        divisions: $("#division_selector").val(),
                        search: $("#search_input").val(),
                        selected: service,
                        types: "1",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });
            });

            function table_change(the) {

                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
                    data: {
                        divisions: $(the).val(),
                        selected: service,
                        types: "1",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });

            }
        </script>
        <?php
    }

    public function form_out_physio_manipulation($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="route_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="grant_id" value="<?= $patient->grant_id ?>">
            <input type="hidden" name="user_id" value="<?= $patient->id ?>">

            <div class="form-group">
                <label>Отделы</label>
                <select data-placeholder="Выбрать отдел" multiple="multiple" id="division_selector" class="form-control select" onchange="table_change(this)" data-fouc>
                    <?php
                    foreach($db->query("SELECT * from division WHERE level IN (12, 13)") as $row) {
                        ?>
                        <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <div class="form-group-feedback form-group-feedback-right row">

                <div class="col-md-10">
                    <input type="text" class="form-control border-info" id="search_input" placeholder="Введите ID или имя">
                    <div class="form-control-feedback">
                        <i class="icon-search4 font-size-base text-muted"></i>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="text-right">
                        <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                            <span class="ladda-label">Сохранить</span>
                            <span class="ladda-spinner"></span>
                        </button>                
                    </div>
                </div>

            </div>

            <div class="form-group">

                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr class="bg-dark">
                                <th>#</th>
                                <th>Отдел</th>
                                <th>Услуга</th>
                                <!-- <th>Тип</th> -->
                                <th>Доктор</th>
                                <th style="width: 100px">Кол-во</th>
                                <th class="text-right">Цена</th>
                            </tr>
                        </thead>
                        <tbody id="table_form">

                        </tbody>
                    </table>
                </div>

            </div>

        </form>
        <script type="text/javascript">

            let service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table_search') ?>",
                    data: {
                        divisions: $("#division_selector").val(),
                        search: $("#search_input").val(),
                        selected: service,
                        types: "1",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });
            });

            function table_change(the) {

                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
                    data: {
                        divisions: $(the).val(),
                        selected: service,
                        types: "1",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });

            }

        </script>
        <?php
    }

    public function form_sta_physio_manipulation($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="direction" value="1">
            <input type="hidden" name="status" value="1">
            <input type="hidden" name="route_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="grant_id" value="<?= $patient->grant_id ?>">
            <input type="hidden" name="user_id" value="<?= $patient->id ?>">

            <div class="form-group">
                <label>Отделы</label>
                <select data-placeholder="Выбрать отдел" multiple="multiple" id="division_selector" class="form-control select" onchange="table_change(this)" data-fouc>
                    <?php
                    foreach($db->query("SELECT * from division WHERE level IN (12, 13)") as $row) {
                        ?>
                        <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <div class="form-group-feedback form-group-feedback-right row">

                <div class="col-md-10">
                    <input type="text" class="form-control border-info" id="search_input" placeholder="Введите ID или имя">
                    <div class="form-control-feedback">
                        <i class="icon-search4 font-size-base text-muted"></i>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="text-right">
                        <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                            <span class="ladda-label">Сохранить</span>
                            <span class="ladda-spinner"></span>
                        </button>
                    </div>
                </div>

            </div>

            <div class="form-group">

                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr class="bg-dark">
                                <th>#</th>
                                <th>Отдел</th>
                                <th>Услуга</th>
                                <!-- <th>Тип</th> -->
                                <th>Доктор</th>
                                <th style="width: 100px">Кол-во</th>
                                <th class="text-right">Цена</th>
                            </tr>
                        </thead>
                        <tbody id="table_form">

                        </tbody>
                    </table>
                </div>

            </div>

        </form>
        <script type="text/javascript">
            let service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table_search') ?>",
                    data: {
                        divisions: $("#division_selector").val(),
                        search: $("#search_input").val(),
                        selected: service,
                        types: "1",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });
            });

            function table_change(the) {

                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
                    data: {
                        divisions: $(the).val(),
                        selected: service,
                        types: "1",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });

            }
        </script>
        <?php
    }

    public function form_sta_doc($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="direction" value="1">
            <input type="hidden" name="status" value="2">
            <input type="hidden" name="accept_date" value="1">
            <input type="hidden" name="route_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="parent_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="user_id" value="<?= $patient->id ?>">
            <input type="hidden" name="division_grant" value="<?= division() ?>">

            <div class="form-group-feedback form-group-feedback-right row">

                <div class="col-md-10">
                    <input type="text" class="form-control border-info" id="search_input" placeholder="Введите ID или имя">
                    <div class="form-control-feedback">
                        <i class="icon-search4 font-size-base text-muted"></i>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="text-right">
                        <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                            <span class="ladda-label">Сохранить</span>
                            <span class="ladda-spinner"></span>
                        </button>
                    </div>
                </div>

            </div>

            <div class="form-group">

                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr class="bg-dark">
                                <th>#</th>
                                <th>Услуга</th>
                                <th style="width: 100px">Кол-во</th>
                                <th class="text-right">Цена</th>
                            </tr>
                        </thead>
                        <tbody id="table_form">
                            <tr>
                                <td colspan="4" class="text-center" onclick="table_change()">услуги</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </form>
        <script type="text/javascript">
            let service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table_search') ?>",
                    data: {
                        divisions: ["<?= division() ?>"],
                        search: $("#search_input").val(),
                        selected: service,
                        types: "1",
                        cols: 3,
                        head: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });
            });

            function table_change() {

                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
                    data: {
                        divisions: ["<?= division() ?>"],
                        selected: service,
                        types: "1",
                        cols: 3,
                        head: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });

            }
        </script>
        <?php
    }

    public function form_package($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="package" value="1">
            <?php if($patient->direction): ?>
                <input type="hidden" name="direction" value="1">
                <input type="hidden" name="status" value="1">
            <?php endif; ?>
            <input type="hidden" name="route_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="grant_id" value="<?= $patient->grant_id ?>">
            <input type="hidden" name="user_id" value="<?= $patient->id ?>">

            <div class="modal-body">

                <div class="form-group row">

                    <div class="col-md-12">
                        <label>Пакеты:</label>
                        <select data-placeholder="Выбрать пакет" class="form-control form-control-select2" required onchange="Change_Package_list(this)">
                            <option></option>
                            <?php foreach ($db->query("SELECT * FROM package WHERE autor_id = {$_SESSION['session_id']} ORDER BY name DESC") as $row): ?>
                                <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>

                <div class="form-group row">
                    <div id="package_item_result"></div>
                </div>

            </div>

            <div class="modal-footer">
                <div class="text-right">
                    <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                        <span class="ladda-label">Сохранить</span>
                        <span class="ladda-spinner"></span>
                    </button>
                </div>
            </div>

        </form>
        <script type="text/javascript">
            function Change_Package_list(params) {
                $.ajax({
                    type: "POST",
                    url: "<?= ajax('card_package_items') ?>",
                    data: { id:params.value },
                    success: function (result) {
                        $('#package_item_result').html(result);
                    },
                });
            }
        </script>
        <?php
    }

    public function clean()
    {
        if($this->post['package']){
            $this->save_package();
        }
        if (is_array($this->post['service'])) {
            $this->save_rows();
        }
        if ($this->post['accept_date']) {
            $this->post['accept_date'] = date('Y-m-d H:i:s');
        }
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    public function save()
    {
        global $db;
        if($this->clean()){
            $db->beginTransaction();

            $object = Mixin\insert($this->table, $this->post);
            if (!intval($object)){
                $this->error($object);
                $db->rollBack();
            }
            $service = $db->query("SELECT price, name FROM service WHERE id = {$this->post['service_id']}")->fetch();
            $post['visit_id'] = $object;
            $post['user_id'] = $this->post['user_id'];
            $post['item_type'] = 1;
            $post['item_id'] = $this->post['service_id'];
            $post['item_cost'] = $service['price'];
            $post['item_name'] = $service['name'];
            $object = Mixin\insert('visit_price', $post);
            if (intval($object)){
                $this->error($object);
                $db->rollBack();
            }
            
            $db->commit();
            $this->success();
        }
    }

    public function save_package()
    {
        global $db;
        $db->beginTransaction();

        foreach ($this->post['service'] as $key => $value) {

            $post_big['direction'] = $this->post['direction'];
            $post_big['route_id'] = $this->post['route_id'];
            $post_big['grant_id'] = $this->post['grant_id'];
            $post_big['user_id'] = $this->post['user_id'];
            if($this->post['direction']){$post_big['direction'] = $this->post['direction'];}
            if($this->post['status']){$post_big['status'] = $this->post['status'];}            
            $post_big['service_id'] = $value;
            $post_big['division_id'] = $this->post['division_id'][$key];
            $level_divis = $db->query("SELECT level FROM division WHERE id = {$post_big['division_id']}")->fetchColumn();
            if ($level_divis == 12) {
                $post_big['physio'] = True;
            }elseif ($level_divis == 13) {
                $post_big['manipulation'] = True;
            }elseif ($level_divis == 10) {
                $post_big['diagnostic'] = True;
            }elseif ($level_divis == 6) {
                $post_big['laboratory'] = True;
            }
            $post_big['parent_id'] = $this->post['parent_id'][$key];
            for ($i=0; $i < $this->post['count'][$key]; $i++) {
                $post_big = Mixin\clean_form($post_big);
                $post_big = Mixin\to_null($post_big);
                $object = Mixin\insert($this->table, $post_big);
                if (!intval($object)){
                    $this->error($object);
                    $db->rollBack();
                }

                if (!$post_big['direction'] or (!permission([2, 32]) and $post_big['direction'])) {
                    $service = $db->query("SELECT price, name FROM service WHERE id = $value")->fetch();
                    $post['visit_id'] = $object;
                    $post['user_id'] = $this->post['user_id'];
                    $post['item_type'] = 1;
                    $post['item_id'] = $value;
                    $post['item_cost'] = $service['price'];
                    $post['item_name'] = $service['name'];
                    $object = Mixin\insert('visit_price', $post);
                    if (!intval($object)){
                        $this->error($object);
                        $db->rollBack();
                    }
                }
            }
            unset($post_big);
        }

        $db->commit();
        $this->success();
    }

    public function save_rows()
    {
        global $db;
        $db->beginTransaction();

        if ($this->post['accept_date'] and $this->post['division_grant']) {
            $post_big['accept_date'] = date('Y-m-d H:i:s');
            $post_big['division_id'] = $this->post['division_grant'];
            $post_big['parent_id'] = $this->post['parent_id'];
        }
        foreach ($this->post['service'] as $key => $value) {

            $post_big['direction'] = $this->post['direction'];
            $post_big['status'] = $this->post['status'];
            $post_big['grant_id'] = $this->post['grant_id'];
            $post_big['route_id'] = $this->post['route_id'];
            $post_big['user_id'] = $this->post['user_id'];
            $post_big['service_id'] = $value;
            if (!$this->post['division_grant']) {
                $post_big['parent_id'] = $this->post['parent_id'][$key];
                $post_big['division_id'] = $this->post['division_id'][$key];
            }
            $level_divis = $db->query("SELECT level FROM division WHERE id = {$post_big['division_id']}")->fetchColumn();
            if ($level_divis == 12) {
                $post_big['physio'] = True;
            }elseif ($level_divis == 13) {
                $post_big['manipulation'] = True;
            }elseif ($level_divis == 10) {
                $post_big['diagnostic'] = True;
            }elseif ($level_divis == 6) {
                $post_big['laboratory'] = True;
            }
            for ($i=0; $i < $this->post['count'][$key]; $i++) {
                $post_big = Mixin\clean_form($post_big);
                $post_big = Mixin\to_null($post_big);
                $object = Mixin\insert($this->table, $post_big);
                if (!intval($object)){
                    $this->error($object);
                    $db->rollBack();
                }

                $service = $db->query("SELECT price, name FROM service WHERE id = {$post_big['service_id']}")->fetch();
                $post['visit_id'] = $object;
                $post['user_id'] = $this->post['user_id'];
                $post['item_type'] = 1;
                $post['item_id'] = $post_big['service_id'];
                $post['item_cost'] = $service['price'];
                $post['item_name'] = $service['name'];
                $object = Mixin\insert('visit_price', $post);
                if (!intval($object)){
                    $this->error($object);
                    $db->rollBack();
                }
            }
            unset($post_big);
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
			<span class="font-weight-semibold"> '.$message.'</span>
	    </div>
        ';
        render();
    }
}

?>