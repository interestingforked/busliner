<?php defined('SYSPATH') or die('No direct script access.'); ?>

<script type="text/javascript">
$(document).ready(function() {
    var requiredFields = ['#info_question','#name','#postcode','#city','#country','#e_mail','#phone'];
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
<?php echo Form::open($uri); ?>
 <fieldset>
     <dl>
         <dt><label for="person_type">Вы являетесь:</label></dt>
         <dd><select name="person_type" id="person_type">
                 <option>Специализированным дилером</option>
                 <option>Производителем программного обеспечения</option>
                 <option>Производителем POS систем</option>
                 <option>Владельцем ресторана</option>
                 <option>Другим заинтересованным лицом</option>
             </select>
         </dd>
         <dt><label for="info_type">Какая информация вам нужна?</label></dt>
         <dd><select name="info_type" id="info_type">
                 <option>Общая</option>
                 <option>Терминал Don</option>
                 <option>Терминал Max2 / Max2Plus</option>
                 <option>Терминал Sol / Sol+</option>
                 <option>POS Columbus</option>
                 <option>Прочие продукты</option>
             </select>
         </dd>
         <dt><label for="info_question">Ваш вопрос <span>*</span>:</label></dt>
         <dd><textarea cols="50" rows="4"  name="info_question" id="info_question"></textarea></dd>
         <dt><label for="name">Имя <span>*</span>:</label></dt>
         <dd><input type="text" name="name" id="name" /></dd>
         <dt><label for="company_name">Компания:</label></dt>
         <dd><input type="text" name="company_name" id="company_name" /></dd>
         <dt><label for="postcode">Почтовый код <span>*</span>:</label></dt>
         <dd><input type="text" name="postcode" id="postcode" /></dd>
         <dt><label for="city">Город <span>*</span>:</label></dt>
         <dd><input type="text" name="city" id="city" /></dd>
         <dt><label for="country">Страна <span>*</span>:</label></dt>
         <dd><?php echo Form::select('country', $countries, 'Russia'); ?></dd>
         <dt><label for="e_mail">Эл. почта <span>*</span>:</label></dt>
         <dd><input type="text" name="e_mail" id="e_mail" /></dd>
         <dt><label for="phone">Телефон <span>*</span>:</label></dt>
         <dd><input type="text" name="phone" id="phone" /></dd>
         <dt><label for="fax">Факс:</label></dt>
         <dd><input type="text" name="fax" id="fax" /></dd>
     </dl>
     <div class="submit">
         <input type="submit" id="submit" name="send" value="отправить запрос" />
     </div>
 </fieldset>
<?php echo Form::close(); ?>