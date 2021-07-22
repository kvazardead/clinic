<?php

class PricePanel extends Model
{
    public $table = 'visits';

    public function get_or_404(int $pk)
    {
        global $db;
        $object = $db->query("SELECT * FROM $this->table WHERE id = $pk AND completed IS NULL")->fetch(PDO::FETCH_ASSOC);
        if($object){
            $this->set_post($object);

            if ($object['direction']) {
                if ($_GET['form'] != "form") {
                    return $this->{$_GET['form']}($object['id']);
                } else {
                    return $this->FirstPanel($object['id']);
                }
            } else {
                if (!(isset($_GET['refund']) and $_GET['refund'])) {
                    return $this->SecondPanel($object['id']);
                } else {
                    return $this->ThirdPanel($object['id']);
                }
            }

        }else{
            Mixin\error('cash_permissions_false');
        }

    }

    public function FirstPanel($pk = null)
    {
        global $db, $classes;
        $vps = (new VisitModel)->price_status($pk);
        ?>
        <div class="card border-1 border-dark">
            <div class="card-header header-elements-inline">
                <h5 class="card-title"><b><?= addZero($this->value('user_id')) ?> - <em><?= get_full_name($this->value('user_id')) ?></em></b></h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a href="<?= viv('card/content_1')."?pk=$pk" ?>" class="<?= $classes['btn-render'] ?>">Перейти к визиту</a>
                    </div>
                </div>
            </div>

            <div class="card-body">

                <legend class="font-weight-semibold text-uppercase font-size-sm">
                    <i class="icon-calculator3 mr-2"></i>Информация
                </legend>

                <table class="table table-hover">
                    <tbody>
                        <tr class="table-secondary">
                            <td>Баланс</td>
                            <td class="text-right text-<?= number_color($vps['balance']) ?>"><?= number_format($vps['balance']) ?></td>
                        </tr>
                        <tr class="table-secondary">
                            <td>Сумма к оплате</td>
                            <td class="text-right text-<?= number_color(-$vps['total_cost'], true) ?>"><?= number_format(-$vps['total_cost']) ?></td>
                        </tr>
                        <tr class="table-secondary">
                            <td>Скидка</td>
                            <td class="text-right text-dark"><?= number_format($vps['sale-total']) ?></td>
                        </tr>
                        <?php /*if(module('module_pharmacy')): ?>
                            <tr class="table-secondary">
                                <td>Сумма к оплате(лекарства)</td>
                                <td class="text-right text-danger"><?= number_format(round($price['cost_item_2'])) ?></td>
                            </tr>
                        <?php endif;*/ ?>
                        <tr class="table-secondary">
                            <td>Разница</td>
                            <td class="text-right text-<?= number_color($vps['result']) ?>"><?= number_format($vps['result']) ?></td>
                        </tr>
                        <input type="hidden" id="prot_item" value="<?= 0//$price['balance'] + $price_cost ?>">
                    </tbody>
                </table>

                <div class="text-right mt-3">

                    <?php (new VisitPricesModel)->form_button($pk, $vps) ?>

                </div>

                <div id="detail_div"></div>

            </div>
        </div>
        <?php
    }

    public function SecondPanel($pk = null)
    {
        global $db, $classes;
        ?>
        <div class="card border-1 border-dark" id="card_info">

            <div class="card-header header-elements-inline">
                <h5 class="card-title"><b><?= addZero($this->value('user_id')) ?> - <em><?= get_full_name($this->value('user_id')) ?></em></b></h5>
            </div>

            <div class="card-body">

                <legend class="font-weight-semibold text-uppercase font-size-sm">
                    <i class="icon-bag mr-2"></i>Услуги
                </legend>

                <div class="table-responsive card">
                    <table class="table table-hover table-sm">
                        <thead class="<?= $classes['table-thead'] ?>">
                            <tr>
                                <th class="text-left">Дата назначения</th>
                                <th>Мед услуги</th>
                                <th class="text-right">Сумма</th>
                                <th class="text-center" style="width: 150px">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($db->query("SELECT vss.id, vss.parent_id, vss.add_date, vss.service_name, vp.item_cost FROM visit_services vss LEFT JOIN visit_prices vp ON(vp.visit_service_id=vss.id) WHERE vss.visit_id = $pk AND vss.status = 1") as $row): ?>
                                <tr id="tr_VisitServicesModel_<?= $row['id'] ?>">
                                    <input type="hidden" class="parent_class" value="<?= $row['parent_id'] ?>">
                                    <input type="hidden" class="prices_class" value="<?= $row['id'] ?>">
                                    <td><?= date($row['add_date'], 1) ?></td>
                                    <td><?= $row['service_name'] ?></td>
                                    <td class="text-right total_cost"><?= $row['item_cost'] ?></td>
                                    <th class="text-center">
                                        <div class="list-icons">
                                            <button onclick="Delete('<?= del_url($row['id'], 'VisitServicesModel') ?>', 'tr_VisitServicesModel_<?= $row['id'] ?>')" class="btn btn-outline-danger btn-sm"><i class="icon-minus2"></i></button>
                                        </div>
                                    </th>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="text-left">
                    <strong>Итого: </strong><strong id="total_title"></strong>
                </div>
                <div class="text-right">
                    <button onclick="CardFuncCheck('<?= $pk ?>')" type="button" class="<?= $classes['btn-price'] ?>" data-toggle="modal" data-target="#modal_default">Оплата</button>
                </div>

            </div>

            </div>
            <script type="text/javascript">

            function CardFuncCheck(pk) {
                var array_services = [];

                Array.prototype.slice.call(document.querySelectorAll('.prices_class')).forEach(function(item) {
                    array_services.push(item.value);
                });

                $.ajax({
                    type: "GET",
                    url: "<?= up_url(null, 'VisitPricesModel') ?>",
                    data: {
                        visit_pk: pk,
                        service_pks: array_services,
                    },
                    success: function (result) {
                        $("#form_card").html(result);
                        Swit.init();
                    },
                });
            }
            </script>
        <?php
    }

    public function ThirdPanel($pk = null)
    {
        global $db, $classes;
        ?>
        <div class="card border-1 border-dark" id="card_info">

            <div class="card-header header-elements-inline">
                <h5 class="card-title"><b><?= addZero($this->value('user_id')) ?> - <em><?= get_full_name($this->value('user_id')) ?></em></b></h5>
            </div>

            <div class="card-body">

                <legend class="font-weight-semibold text-uppercase font-size-sm">
                    <i class="icon-bag mr-2"></i>Услуги
                </legend>

                <div class="table-responsive card">
                    <table class="table table-hover table-sm">
                        <thead class="<?= $classes['table-thead'] ?>">
                            <tr>
                                <th class="text-left">Дата назначения</th>
                                <th>Мед услуги</th>
                                <th class="text-right">Сумма</th>
                                <th class="text-center" style="width: 150px">Дата оплаты</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($db->query("SELECT vss.id, vss.parent_id, vss.add_date, vss.service_name, (vp.price_cash + vp.price_card + vp.price_transfer) 'item_cost', vp.price_date FROM visit_services vss LEFT JOIN visit_prices vp ON(vp.visit_service_id=vss.id) WHERE vss.visit_id = $pk AND vss.status = 5") as $row): ?>
                                <tr id="tr_VisitServicesModel_<?= $row['id'] ?>">
                                    <input type="hidden" class="prices_class" value="<?= $row['id'] ?>">
                                    <td><?= date_f($row['add_date'], 1) ?></td>
                                    <td><?= $row['service_name'] ?></td>
                                    <td class="text-right total_cost"><?= $row['item_cost'] ?></td>
                                    <td><?= date_f($row['price_date'], 1) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="text-left">
                    <strong>Итого: </strong><strong id="total_title"></strong>
                </div>
                <div class="text-right">
                    <button onclick="CardFuncCheck('<?= $pk ?>')" type="button" class="<?= $classes['btn-price'] ?>" data-toggle="modal" data-target="#modal_default">Оплата</button>
                </div>

            </div>

        </div>
        <script type="text/javascript">
            function CardFuncCheck(pk) {
                var array_services = [];

                Array.prototype.slice.call(document.querySelectorAll('.prices_class')).forEach(function(item) {
                    array_services.push(item.value);
                });

                $.ajax({
                    type: "GET",
                    url: "<?= up_url(null, 'VisitPricesModel') ?>",
                    data: {
                        visit_pk: pk,
                        refund: 1,
                        service_pks: array_services,
                    },
                    success: function (result) {
                        $("#form_card").html(result);
                        Swit.init();
                    },
                });
            }
        </script>
        <?php
    }

    public function DetailPanel($pk = null)
    {
        global $classes;
        ?>
        <legend class="font-weight-semibold text-uppercase font-size-sm">
            <i class="icon-cogs mr-2"></i>Детально
            <a class="float-right text-dark mr-1" onclick="printdiv('check_detail')">
                <i class="icon-printer2"></i>
            </a>
        </legend>

        <ul class="nav nav-tabs nav-tabs-solid nav-justified rounded border-0">
            <li class="nav-item"><a onclick="DetailControl('<?= up_url($pk, 'PricePanel', 'DetailPanelInvestments') ?>')" href="#" class="nav-link legitRipple active show" data-toggle="tab">Инвестиции</a></li>
            <li class="nav-item"><a onclick="DetailControl('<?= up_url($pk, 'PricePanel', 'DetailPanelServices') ?>')" href="#" class="nav-link legitRipple" data-toggle="tab">Услуги</a></li>
            <li class="nav-item"><a onclick="DetailControl('<?= up_url($pk, 'PricePanel', 'DetailPanelPharm') ?>')" href="#" class="nav-link legitRipple" data-toggle="tab">Лекарства</a></li>
            <!-- <li class="nav-item"><a onclick="Detail_control('<?= up_url($pk, 'PricePanel', 'DetailPanelPharm') ?>')" href="#" class="nav-link legitRipple" data-toggle="tab">Итог</a></li> -->
        </ul>

        <div class="table-responsive" id="div_show_detail">
            <script>
                $(document).ready(function(){
                    DetailControl('<?= up_url($pk, 'PricePanel', 'DetailPanelInvestments') ?>');
                });
            </script>
        </div>

        <script type="text/javascript">
            function DetailControl(params) {
                $.ajax({
                    type: "POST",
                    url: params,	
                    success: function (result) {
                        $('#div_show_detail').html(result);
                    },
                });
            }
        </script>
        <?php
    }

    public function DetailPanelInvestments($pk = null)
    {
        global $classes;
        ?>
        <div class="table-responsive mt-3 card" id="check_detail">
            <table class="table table-hover table-sm">
                <thead>
                    <tr class="bg-dark">
                        <th class="text-left" colspan="2">Наименование</th>
                        <th>Дата и время</th>
                        <th class="text-right">Сумма</th>
                    </tr>
                </thead>
                <tbody>
                    

                </tbody>
            </table>
        </div>
        <?php
    }

    public function DetailPanelServices($pk = null)
    {
        global $classes;
        ?>
        <div class="table-responsive mt-3 card" id="check_detail">
            <table class="table table-hover table-sm">
                <thead>
                    <tr class="bg-dark">
                        <th class="text-left" colspan="2">Наименование</th>
                        <th>Дата и время</th>
                        <th class="text-right">Сумма</th>
                    </tr>
                </thead>
                <tbody>
                    

                </tbody>
            </table>
        </div>
        <?php
    }

    public function DetailPanelPharm($pk = null)
    {
        global $classes;
        ?>
        <div class="table-responsive mt-3 card" id="check_detail">
            <table class="table table-hover table-sm">
                <thead>
                    <tr class="bg-dark">
                        <th class="text-left" colspan="2">Наименование</th>
                        <th>Дата и время</th>
                        <th class="text-right">Сумма</th>
                    </tr>
                </thead>
                <tbody>
                    

                </tbody>
            </table>
        </div>
        <?php
    }

}
        
?>