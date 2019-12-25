<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-filter" data-toggle="tooltip" title="<?php echo $button_save; ?>"
                        class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>"
                   class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#home"><?php echo $menu_setting ?></a></li>
                    <li><a data-toggle="tab" href="#menu1"><?php echo $menu_list ?></a></li>
                </ul>

                <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">
                        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data"
                              id="form-filter" class="form-horizontal">
                            <div class="form-group">
                                <select name="reverse_form_status" id="input-status" class="form-control active">
                                    <?php if ($reverse_form_status) { ?>
                                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                    <option value="0"><?php echo $text_disabled; ?></option>
                                    <?php } else { ?>
                                    <option value="1"><?php echo $text_enabled; ?></option>
                                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div id="menu1" class="tab-pane fade">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="history">
                                <thead>
                                <tr>
                                    <td class="text-left"><?php echo $column_info; ?></td>
                                    <td class="text-left"><?php echo $column_date_added; ?></td>
                                    <td class="text-center"><?php echo $column_action; ?></td>
                                </tr>
                                </thead>

                                <tbody>
                                <?php if (isset($histories) && $histories) { ?>
                                <?php foreach ($histories as $history) { ?>
                                <tr>
                                    <td class="text-left">

                                        <p><strong><?php echo $name; ?>:</strong> <?php echo $history['name']; ?></p>
                                        <p><strong><?php echo $phone; ?>:</strong> <?php echo $history['phone']; ?></p>
                                        <p><strong><?php echo $email; ?>:</strong> <?php echo $history['email']; ?></p>
                                        <p><strong><?php echo $description; ?>
                                                :</strong> <?php echo $history['description']; ?></p>
                                    </td>
                                    <td class="text-center">
                                        <p><?php echo $history['date_add']; ?></p>
                                    </td>
                                    <td class="text-center">
                                        <a onclick="delete_selected(<?php echo $history['id']; ?>);"
                                           data-toggle="tooltip" title="" class="btn btn-warning"
                                           data-original-title="<?php echo $button_delete; ?>"><i
                                                    class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php } else { ?>
                                <tr>
                                    <td class="text-center" colspan="4"><?php echo $text_no_results; ?></td>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script type="text/javascript">

    function delete_selected(id) {
        $.ajax({
            type: 'post',
            url: 'index.php?route=extension/module/reverse_form/delete_selected&token=<?php echo $token; ?>&delete=' + id,
            dataType: 'json',
            success: function (json) {
                $('#history').load('index.php?route=extension/module/reverse_form&token=<?php echo $token; ?> #history');
            }
        });
    }
</script>

<?php echo $footer; ?>




