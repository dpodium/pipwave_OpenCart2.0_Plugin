<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-pipwave" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
            <h1><?php echo $heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-pipwave" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-api">
                            <?php echo $entry_api_key; ?>
                        </label>
                        <div class="col-sm-10">
                            <input type="text" name="pipwave_api_key" value="<?php echo $pipwave_api_key; ?>" id="input-api" class="form-control" />
                            <div class="hint-block" style="color: #1E91CF; margin: 4px 0;"><?php echo $tooltip_api_key; ?></div>
                            <?php if ($error_api_key) { ?>
                            <div class="text-danger"><?php echo $error_api_key; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-secret">
                            <?php echo $entry_api_secret; ?>
                        </label>
                        <div class="col-sm-10">
                            <input type="password" name="pipwave_api_secret" value="<?php echo $pipwave_api_secret; ?>" id="input-secret" class="form-control" />
                            <div class="hint-block" style="color: #1E91CF; margin: 4px 0;"><?php echo $tooltip_api_secret; ?></div>
                            <?php if ($error_api_secret) { ?>
                            <div class="text-danger"><?php echo $error_api_secret; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-order-status"><?php echo $entry_order_status; ?></label>
                        <div class="col-sm-10">
                            <select name="pipwave_order_status_id" id="input-order-status" class="form-control">
                                <?php foreach ($order_statuses as $order_status) { ?>
                                <?php if ($order_status['order_status_id'] == $pipwave_order_status_id) { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo $entry_complete_status; ?></label>
                        <div class="col-sm-10">
                            <select name="pipwave_complete_status_id" class="form-control">
                                <?php foreach ($order_statuses as $order_status) { ?>
                                <?php if ($order_status['order_status_id'] == $pipwave_complete_status_id) { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo $entry_refund_status; ?></label>
                        <div class="col-sm-10">
                            <select name="pipwave_refund_status_id" class="form-control">
                                <?php foreach ($order_statuses as $order_status) { ?>
                                <?php if ($order_status['order_status_id'] == $pipwave_refund_status_id) { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo $entry_partial_refund_status; ?></label>
                        <div class="col-sm-10">
                            <select name="pipwave_partial_refund_status_id" class="form-control">
                                <?php foreach ($order_statuses as $order_status) { ?>
                                <?php if ($order_status['order_status_id'] == $pipwave_partial_refund_status_id) { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo $entry_canceled_status; ?></label>
                        <div class="col-sm-10">
                            <select name="pipwave_canceled_status_id" class="form-control">
                                <?php foreach ($order_statuses as $order_status) { ?>
                                <?php if ($order_status['order_status_id'] == $pipwave_canceled_status_id) { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo $entry_failed_status; ?></label>
                        <div class="col-sm-10">
                            <select name="pipwave_failed_status_id" class="form-control">
                                <?php foreach ($order_statuses as $order_status) { ?>
                                <?php if ($order_status['order_status_id'] == $pipwave_failed_status_id) { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                        <div class="col-sm-10">
                            <select name="pipwave_status" id="input-status" class="form-control">
                                <?php if ($pipwave_status) { ?>
                                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                <option value="0"><?php echo $text_disabled; ?></option>
                                <?php } else { ?>
                                <option value="1"><?php echo $text_enabled; ?></option>
                                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
                        <div class="col-sm-10">
                            <select name="pipwave_geo_zone_id" id="input-geo-zone" class="form-control">
                                <option value="0"><?php echo $text_all_zones; ?></option>
                                <?php foreach ($geo_zones as $geo_zone) { ?>
                                <?php if ($geo_zone['geo_zone_id'] == $pipwave_geo_zone_id) { ?>
                                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_test_mode; ?></label>
                        <div class="col-sm-10">
                            <label class="radio-inline">
                                <?php if ($pipwave_test_mode) { ?>
                                <input type="radio" name="pipwave_test_mode" value="1" checked="checked" />
                                <?php echo $text_yes; ?>
                                <?php } else { ?>
                                <input type="radio" name="pipwave_test_mode" value="1" />
                                <?php echo $text_yes; ?>
                                <?php } ?>
                            </label>
                            <label class="radio-inline">
                                <?php if (!$pipwave_test_mode) { ?>
                                <input type="radio" name="pipwave_test_mode" value="0" checked="checked" />
                                <?php echo $text_no; ?>
                                <?php } else { ?>
                                <input type="radio" name="pipwave_test_mode" value="0" />
                                <?php echo $text_no; ?>
                                <?php } ?>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            <?php echo $entry_processing_fee_group; ?>
                        </label>
                        <div class="col-sm-10">
                            <?php foreach ($customer_groups as $customer_group) { ?>
                            <div class='row'>
                                <div class="col-sm-6">
                                    <div class="checkbox">
                                        <label>
                                            <?php if (isset($pipwave_processing_fee_groups[$customer_group['customer_group_id']])) { ?>
                                            <input type="checkbox" name="pipwave_processing_fee_groups[<?php echo $customer_group['customer_group_id']; ?>]" value="<?php echo $customer_group['name']; ?>" checked />
                                            <?php } else { ?>
                                            <input type="checkbox" name="pipwave_processing_fee_groups[<?php echo $customer_group['customer_group_id']; ?>]" value="<?php echo $customer_group['name']; ?>" />
                                            <?php } ?>
                                            <?php echo $customer_group['name']; ?>
                                        </label>
                                    </div>
                                </div>                            
                            </div>
                            <div class='form-group row' style='padding-top: 0; padding-bottom: 0;'>
                                <div class="col-sm-6">
                                    <label class='control-label'><?php echo $entry_processing_fee_ref; ?></label>
                                    <input type="text" name="pipwave_processing_fee_ref[<?php echo $customer_group['customer_group_id']; ?>]" value="<?php echo $pipwave_processing_fee_ref[$customer_group['customer_group_id']]; ?>" class="form-control" />                            
                                    <?php if (isset($error_processing_fee_ref[$customer_group['customer_group_id']])) { ?>
                                    <div class="text-danger"><?php echo $error_processing_fee_ref[$customer_group['customer_group_id']]; ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="hint-block" style="color: #1E91CF; margin: 4px 0;"><?php echo $tooltip_processing_fee_group; ?></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="pipwave_sort_order" value="<?php echo $pipwave_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
                        </div>
                    </div>
                </form>
                <div style="margin-top: 30px;">
                    <b><?php echo $more_info['step_title']; ?></b>
                    <ol>
                        <li style="padding:5px">
                            <?php echo $more_info['step_sign_in'] . $more_info['step_sign_up']; ?>
                        </li>
                        <li style="padding: 5px">
                            <?php echo $more_info['step_setup']; ?>
                        </li>
                        <li style="padding: 5px">
                            <?php echo $more_info['step_configure']; ?>
                        </li>
                        <li style="padding: 5px">
                            <?php echo $more_info['step_more_info']; ?>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>