<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>

<?php
if ($modal) {
    ?>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <?php
            } else {
                ?><!doctype html>
                <html>
                <head>
                    <meta charset="utf-8">
                    <title>Invoice</title>
                    <!-- <title><?= $page_title . " " . lang("no") . " " . $inv->salesno; ?></title> -->
                    <meta http-equiv="cache-control" content="max-age=0"/>
                    <meta http-equiv="cache-control" content="no-cache"/>
                    <meta http-equiv="expires" content="0"/>
                    <meta http-equiv="pragma" content="no-cache"/>
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <link rel="shortcut icon" href="<?= $assets ?>images/icon.png"/>
                    <link href="<?= $assets ?>dist/css/styles.css" rel="stylesheet" type="text/css" />
                    <style type="text/css" media="all">
                        body { color: #000; }
                        #wrapper { max-width: 520px; margin: 0 auto; padding-top: 20px; }
                        .btn { margin-bottom: 5px; }
                        .table { border-radius: 3px; }
                        .table th { background: #f5f5f5; }
                        .table th, .table td { vertical-align: middle !important; }
                        h3 { margin: 5px 0; }

                        @media print {
                            .no-print { display: none; }
                            #wrapper { max-width: 420px; width: 100%; min-width: 50px; margin: auto; }
                        }
                    </style>
                </head>
                <body>

                    <?php
                }
                ?>
                <div id="wrapper">
                    <div id="receiptData" style="width: auto; max-width: 580px; min-width: 250px; margin: auto;">
                        <div class="no-print">
                            <?php if ($message) { ?>
                            <div class="alert alert-success">
                                <button data-dismiss="alert" class="close" type="button">×</button>
                                <?= is_array($message) ? print_r($message, true) : $message; ?>
                            </div>
                            <?php } ?>
                        </div>
                        <div id="receipt-data">
                            <div>
                               <!-- <div style="text-align:center;">
                                    <?php
                                    if ($store) {
                                        echo '<br>';
                                        echo $store->address1.'<br>'.$store->address2;
                                        echo $store->city.'<br>'.$store->phone;
                                        echo '</p>';
                                        echo '<p>'.nl2br($store->receipt_header).'</p>';
                                    }
                                    ?>
                                </div> -->
                                <p>
                                    <strong>No Seri : <?=$inv->nofaktur_pajak; ?> <br>
                                    PERUSAHAAN KENA PAJAK<br>
                                    NAMA : PT.SHAFCO MULTI TRADING<br>
                                    ALAMAT : JL. BUAH BATU DALAM V NO 109/105 CIJAGRA LENGKONG<br>
                                    NPWP : <?=$inv->npwp; ?>  </strong>
                                <hr style=" width: 100%; border-bottom: 2px solid #ddd;">
                                   <?=$store->name; ?> <br>
                                <?= $store->address1.'<br>'; ?>
                                Telp :  <?= $store->phone ?><br>
                                <?=  date('d-m-Y H:i:s',strtotime( $inv->date)); ?> <br>
                                </p>
                                <div style="clear:both;"></div>
                                <table class="table table-striped table-condensed">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center; width: 50%; border-bottom: 2px solid #ddd;">CODE</th>
                                            <th style="text-align:center; width: 12%; border-bottom: 2px solid #ddd;">QTY</th>
                                            <th style="text-align:center; width: 24%; border-bottom: 2px solid #ddd;"><?=lang('price');?></th>
                                            <th style="text-align:center; width: 26%; border-bottom: 2px solid #ddd;"><?=lang('subtotal');?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $tax_summary = array();
                                        foreach ($rows as $row) {
                                            echo '<tr><td colspan="4" style="text-align:left;">' . $row->product_code .' - '. $row->product_name .'</td></tr>';
                                            echo '<tr><td></td><td  style="text-align:center;">' . $this->tec->formatQuantity($row->quantity) . '</td>'; echo '<td style="text-align:right;">';
                                            echo $this->tec->formatMoney($row->net_unit_price + ($row->item_tax / $row->quantity)) . '</td><td style="text-align:right;">' . $this->tec->formatMoney($row->subtotal) . '</td></tr>';
                                            if ($row->disc_persen > 0){
                                                echo '<tr><td colspan="2">Discount</td>'; echo '<td style="text-align:right;">';
                                                echo $this->tec->formatMoney($row->subtotal*($row->disc_persen/100)) . '</td><td style="text-align:right;">' . $this->tec->formatMoney($row->subtotal-($row->subtotal*($row->disc_persen/100))) . '</td></tr>';
                                            }

                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th colspan="2" style="text-align:left;">Total Items(Qty)</th>
                                        <th colspan="2" style="text-align:right;"><?= $this->tec->formatdecimal($inv->total_items).'('.$this->tec->formatdecimal($inv->total_quantity).')'; ?></th>
                                    </tr>
                                        <tr>
                                            <th colspan="2" style="text-align:left;"><?= lang("total"); ?> Harga Jual</th>
                                            <!-- <th colspan="2" style="text-align:right;"><?= $this->tec->formatMoney($inv->total + $inv->product_tax); ?></th> --><th colspan="2" style="text-align:right;"><?= $this->tec->formatMoney($inv->total ); ?></th>
                                        </tr>
                                        <?php
                                        if ($inv->order_tax != 0) {
                                            echo '<tr><th colspan="2" style="text-align:left;">' . lang("order_tax") . '</th><th colspan="2" style="text-align:right;">' . $this->tec->formatMoney($inv->order_tax) . '</th></tr>';
                                        }
                                       if ($inv->total_discount != 0) {
                                            echo '<tr><th colspan="2" style="text-align:left;">Potongan Harga</th><th colspan="2" style="text-align:right;">' . $this->tec->formatMoney($inv->total_discount) . '</th></tr>';
                                        }

                                        if ($Settings->rounding) {
                                            $round_total = $this->tec->roundNumber($inv->grand_total, $Settings->rounding);
                                            $rounding = $this->tec->formatDecimal($round_total - $inv->grand_total);
                                            ?>
                                            <tr>
                                                <th colspan="2" style="text-align:left;">Potongan Poin</th>
                                                <th colspan="2" style="text-align:right;">0</th>
                                            </tr>

                                            <tr> <?php
                                                echo '<th colspan="2" style="text-align:left;">Total Harus Dibayar</th>';
                                                echo '<th colspan="2" style="text-align:right;">'.$this->tec->Formatmoney($inv->total+$inv->order_tax-$inv->total_discount).'</th>'; ?>
                                            </tr>
                                           <!-- <tr>
                                                <th colspan="2" style="text-align:left;">DP</th>
                                                <th colspan="2" style="text-align:right;">0</th>
                                            </tr>-->
                                            <tr><?php
                                                echo '<th colspan="2" style="text-align:left;">DPP</th>';
                                                echo '<th colspan="2" style="text-align:right;">'.$this->tec->formatMoney(($inv->total+$inv->order_tax-$inv->total_discount)/1.1).' </th>';?>
                                            </tr>
                                            <tr>
                                                <?php
                                                echo '<th colspan="2" style="text-align:left;">PPN= 10% x DPP</th>';
                                                echo '<th colspan="2" style="text-align:right;">'.$this->tec->formatMoney((($inv->total+$inv->order_tax-$inv->total_discount)/1.1)*0.1).' </th>';?>
                                            </tr>
                                           <!-- <tr>
                                                <th colspan="2" style="text-align:left;"><?= lang("grand_total"); ?></th>
                                                <th colspan="2" style="text-align:right;"><?= $this->tec->formatMoney($inv->grand_total + $rounding); ?></th>
                                            </tr> -->
                                            <?php
                                        } else {
                                            $round_total = $inv->grand_total;
                                            ?>
                                            <tr>
                                                <th colspan="2" style="text-align:left;"><?= lang("grand_total"); ?></th>
                                                <th colspan="2" style="text-align:right;"><?= $this->tec->formatMoney($inv->grand_total); ?></th>
                                            </tr>
                                            <?php
                                        }
                                        if ($inv->paid < $round_total) { ?>
                                        <tr>
                                            <th colspan="2" style="text-align:left;"><?= lang("paid_amount"); ?></th>
                                            <th colspan="2" style="text-align:right;"><?= $this->tec->formatMoney($inv->paid); ?></th>
                                        </tr>
                                        <tr>
                                            <th colspan="2" style="text-align:left;"><?= lang("due_amount"); ?></th>
                                            <th colspan="2" style="text-align:right;"><?= $this->tec->formatMoney($inv->grand_total - $inv->paid); ?></th>
                                        </tr>
                                        <?php } ?>
                                    </tfoot>
                                </table>
                                <?php
                                if ($payments) {
                                    echo '<table class="table table-striped table-condensed" style="margin-top:10px;"><tbody>';
                                    foreach ($payments as $payment) {
                                        echo '<tr>';

                                            echo '<td style="padding-left:15px;">' . lang($payment->paid_by) . '</td>';
                                            echo '<td style="padding-left:15px;">' . $this->tec->formatMoney($payment->amount) . '</td>';
                                            echo '<td style="padding-left:15px;">' . ($payment->pos_balance > 0 ? $this->tec->formatMoney($payment->pos_balance) : 0) . '</td>';


                                        echo '</tr>';
                                    }

                                    foreach ($brands as $brand) {
                                        echo '<tr>';
                                        echo '<td style="padding-left:15px;">' . lang($brand->nmbrand) . '</td>';
                                        echo '<td style="padding-left:15px;">' . $this->tec->formatMoney($brand->total) . '</td>';



                                        echo '</tr>';
                                    }
                                    echo '</tbody></table>';
                                }

                                ?>



                                <?= $inv->note ? '<p style="margin-top:10px; text-align: center;">' . $this->tec->decode_html($inv->note) . '</p>' : ''; ?>
                                <?php if (!empty($store->receipt_footer)) { ?>
                                <div class="well well-sm"  style="margin-top:10px;">
                                    <div style="text-align: center;"><?= nl2br($store->receipt_footer); ?></div>
                                </div>
                                <?php } ?>
                            </div>
                            <div style="clear:both;"></div>
                        </div>

                        <!-- start -->
                        <div id="buttons" style="padding-top:10px; text-transform:uppercase;" class="no-print">
                            <hr>
                            <?php if ($modal) { ?>
                            <div class="btn-group btn-group-justified" role="group" aria-label="...">
                                <div class="btn-group" role="group">
                                    <?php
                                    if ( ! $Settings->remote_printing) {
                                        echo '<a href="'.site_url('pos/print_receipt/'.$inv->id.'/0').'" id="print" class="btn btn-block btn-primary">'.lang("print").'</a>';
                                    } elseif ($Settings->remote_printing == 1) {
                                        echo '<button onclick="window.print();" class="btn btn-block btn-primary">'.lang("print").'</button>';
                                    } else {
                                        echo '<button onclick="return printReceipt()" class="btn btn-block btn-primary">'.lang("print").'</button>';
                                    }
                                    ?>
                                </div>
                                <div class="btn-group" role="group">
                                    <a class="btn btn-block btn-success" href="#" id="email"><?= lang("email"); ?></a>
                                </div>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close'); ?></button>
                                </div>
                            </div>
                            <?php } else { ?>
                            <span class="pull-right col-xs-12">
                                <?php
                                if ( ! $Settings->remote_printing) {
                                    echo '<a href="'.site_url('pos/print_receipt/'.$inv->id.'/1').'" id="print" class="btn btn-block btn-primary">'.lang("print").'</a>';
                                    echo '<a href="'.site_url('pos/open_drawer/').'" class="btn btn-block btn-default">'.lang("open_cash_drawer").'</a>';
                                } elseif ($Settings->remote_printing == 1) {
                                    echo '<button onclick="window.print();" class="btn btn-block btn-primary">'.lang("print").'</button>';
                                } else {
                                    echo '<button onclick="return printReceipt()" class="btn btn-block btn-primary">'.lang("print").'</button>';
                                    echo '<button onclick="return openCashDrawer()" class="btn btn-block btn-default">'.lang("open_cash_drawer").'</button>';
                                }
                                ?>
                            </span>
                            <span class="pull-left col-xs-12"><a class="btn btn-block btn-success" href="#" id="email"><?= lang("email"); ?></a></span>
                            <span class="col-xs-12">
                                <a class="btn btn-block btn-warning" href="<?= site_url('pos'); ?>"><?= lang("back_to_pos"); ?></a>
                            </span>
                            <?php } ?>
                            <div style="clear:both;"></div>
                        </div>
                        <!-- end -->
                    </div>
              </div>
                <!-- start -->
                <?php
                if (!$modal) {
                    ?>
                    <script type="text/javascript">
                        var base_url = '<?=base_urls();?>';
                        var site_url = '<?=site_urls();?>';
                       var dateformat = '<?=$Settings->dateformat;?>', timeformat = '<?= $Settings->timeformat ?>';
                        <?php unset($Settings->protocol, $Settings->smtp_host, $Settings->smtp_user, $Settings->smtp_pass, $Settings->smtp_port, $Settings->smtp_crypto, $Settings->mailpath, $Settings->timezone, $Settings->setting_id, $Settings->default_email, $Settings->version, $Settings->stripe, $Settings->stripe_secret_key, $Settings->stripe_publishable_key); ?>
                        var Settings = <?= json_encode($Settings); ?>;
                    </script>
                    <script src="<?= $assets ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
                    <script src="<?= $assets ?>dist/js/libraries.min.js" type="text/javascript"></script>
                    <script src="<?= $assets ?>dist/js/scripts.min.js" type="text/javascript"></script>
                    <?php
                }
                ?>
                <script type="text/javascript">
                    $(document).ready(function () {
                        $('#print').click(function (e) {
                            e.preventDefault();
                            var link = $(this).attr('href');
                            $.get(link);
                            return false;
                        });
                        $('#email').click(function () {
                            bootbox.prompt({
                                title: "<?= lang("email_address"); ?>",
                                inputType: 'email',
                                value: "<?= $customer->email; ?>",
                                callback: function (email) {
                                    if (email != null) {
                                        $.ajax({
                                            type: "post",
                                            url: "<?= site_url('pos/email_receipt') ?>",
                                            data: {<?= $this->security->get_csrf_token_name(); ?>: "<?= $this->security->get_csrf_hash(); ?>", email: email, id: <?= $inv->id; ?>},
                                            dataType: "json",
                                            success: function (data) {
                                                bootbox.alert({message: data.msg, size: 'small'});
                                            },
                                            error: function () {
                                                bootbox.alert({message: '<?= lang('ajax_request_failed'); ?>', size: 'small'});
                                                return false;
                                            }
                                        });
                                    }
                                }
                            });
                            return false;
                        });
                    });
                </script>
                <?php /* include FCPATH.'themes'.DIRECTORY_SEPARATOR.$Settings->theme.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'pos'.DIRECTORY_SEPARATOR.'remote_printing.php'; */ ?>
                <?php include 'remote_printing.php'; ?>
                <?php
                if ($modal) {
                    ?>
                </div>
            </div>
        </div>
        <?php
    } else {
        ?>
    <!-- end -->
    </body>
    </html>
    <?php
}
?>
