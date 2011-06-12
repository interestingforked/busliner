<?php defined('SYSPATH') or die('No direct script access.'); ?>

<script type="text/javascript">
    $(document).ready(function() {
        var requiredFields = ['#name','#postcode','#city','#country','#e_mail','#phone','#reference_text'];
        $("form").submit(function() {
            var accepted = true;
            $(requiredFields).each(function(index) {
                if ($(requiredFields[index]).val() == '') {
                    $(requiredFields[index]).css('background', '#FFD6D6');
                    accepted = false;
                }
            });
            if ( ! accepted) {
                alert('Заполните пожалуйста обязательные поля, отмеченые звёздочкой.');
            }
            return accepted;
        });
    });
</script>

<?php
if (isset($message)) {
    echo $message;
}
?>

<?php echo Form::open($uri, array('enctype' => 'multipart/form-data')); ?>
<fieldset>
    <dl>
        <dt><label for="name">Имя <span>*</span>:</label></dt>
        <dd><input type="text" id="name" name="name" /></dd>
        <dt><label for="company_name">Компания:</label></dt>
        <dd><input type="text" id="company_name" name="company_name" /></dd>
        <dt><label for="postcode">Почтовый код <span>*</span>:</label></dt>
        <dd><input type="text" id="postcode" name="postcode" /></dd>
        <dt><label for="city">Город <span>*</span>:</label></dt>
        <dd><input type="text" id="city" name="city" /></dd>
        <dt><label for="country">Страна <span>*</span>:</label></dt>
        <dd><?php echo Form::select('country', $countries, 'Russia'); ?></dd>
        <dt><label for="e_mail">Эл. почта <span>*</span>:</label></dt>
        <dd><input type="text" id="e_mail" name="e_mail" /></dd>
        <dt><label for="phone">Телефон <span>*</span>:</label></dt>
        <dd><input type="text" id="phone" name="phone" /></dd>
        <dt><label for="fax">Факс:</label></dt>
        <dd><input type="text" id="fax" name="fax" /></dd>
        <dt><label for="reference_text">Ваш опыт использования Orderman <span>*</span>:</label></dt>
        <dd><textarea cols="50" rows="4"  id="reference_text" name="reference_text"></textarea></dd>
        <dt><label for="www">Сайт:</label></dt>
        <dd><input type="text" id="www" name="www" /></dd>
        <dt><label for="reference_img">Логотип компании:</label></dt>
        <dd><input type="file" id="reference_img" name="reference_img" /></dd>
    </dl>
    <div class="submit">
        <input type="submit" name="send" value="отправить запрос" />
    </div>
</fieldset>
<?php echo Form::close(); ?>