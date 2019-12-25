<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/reverse_form.css" />
<div type="button" class="email-bt" data-toggle="modal" data-target="#myModal">
    <div class="text-call">
        <i class="fa fa-envelope" aria-hidden="true"></i>
        <span><?php echo $button_feedback;?></span>
    </div>
</div>

<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $form_name; ?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form id="reverse_form" action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name" ><?php echo $text_name; ?></label><span class="required">*</span>
                        <input type="text" class="form-control" id="name" name="name" placeholder="<?php echo $text_name; ?>">
                    </div>

                    <div class="form-group">
                        <label for="tel" ><?php echo $text_telephone; ?></label><span class="required">*</span>
                        <input type="tel" class="form-control" required id="tel" name="tel" placeholder="<?php echo $mask; ?>">
                        <?php if ($mask) { ?>
                        <script src="catalog/view/javascript/jquery/jquery.maskedinput.min.js"></script>
                        <?php } ?>
                    </div>

                    <div class="form-group">
                        <label for="email"><?php echo $text_email; ?></label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="<?php echo $text_email; ?>">
                    </div>

                    <div class="form-group">
                        <label for="description"><?php echo $text_description; ?></label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="<?php echo $text_description; ?>"></textarea>
                    </div>

                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button id="close" type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $button_close; ?></button>
                <button onclick="sendForm()" class="btn btn-success"><?php echo $button_send; ?></button>
            </div>

        </div>
    </div>
</div>


<script type="text/javascript">

    jQuery(function($) {
    <?php if ($mask) { ?>
        $("#tel").mask('<?php echo $mask; ?>');
        <?php } ?>

    <?php if ($front_validate) { ?>
        $('#name,#tel,#email').focusout(function(){
            let id = $(this).attr('id');
            let val = $(this).val();

            switch(id)
            {
                case 'name':
                    if(val != '')
                    {
                        $(this).removeClass('err');
                        $('#text-danger'+id).remove();
                    }
                    else
                    {
                        $('#text-danger'+id).remove();
                        $(this).addClass('err');
                        $(this).after('<div id="text-danger' + id + '" class="text-danger">' + '<?php echo $name_error; ?>' + '</div>');
                    }
                    break;

                case 'tel':
                    if( val.indexOf("_") != -1 || val == '' )
                    {
                        $('#text-danger'+id).remove();
                        $(this).addClass('err');
                        $(this).after('<div id="text-danger' + id + '" class="text-danger">' + '<?php echo $tel_error; ?>' + '</div>');

                    }
                    else
                    {
                        $(this).removeClass('err');
                        $('#text-danger'+id).remove();
                    }
                    break;

                case 'email':
                    if(val != '') {
                        let rv_email = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
                        if(rv_email.test(val))
                        {
                            $(this).removeClass('err');
                            $('#text-danger'+id).remove();
                        }
                    else
                        {
                            $('#text-danger'+id).remove();
                            $(this).addClass('err');
                            $(this).after('<div id="text-danger' + id + '" class="text-danger">' + '<?php echo $email_error; ?>' + '</div>');
                        }
                    }
                    break;
            }
        });
        <?php } ?>

    });
</script>

<script type="text/javascript">
    function sendForm() {
        $.ajax({
            type: 'post',
            url: 'index.php?route=extension/module/reverse_form/send',
            dataType: 'json',
            data: $('#reverse_form').serialize(),
            success: function (json) {
                if (json['error']) {

                    $('.text-danger').remove();
                    $('.form-control').removeClass('err');
                    $.each(json['error'], function (id, val) {
                        $('#' + id).addClass('err').after('<div id="text-danger' + id + '" class="text-danger">' + val + '</div>');
                    });
                } else {
                    $('.text-danger').remove();
                    $('.form-control').removeClass('err');
                    $("#close").click();
                }

            }
        });
    }
</script>
