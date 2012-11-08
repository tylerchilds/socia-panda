<div class="post-form clearfix">
<?php 

$txt_post = array(
    'name' => 'postText',
    'rows' => '0',
    'cols' => '0',
    'class' => 'expanding',
  );

    echo validation_errors();

    echo form_open('posts/create');
    echo form_textarea($txt_post);
	
?>
<select name="postType" class="pull-left">
<option value="all">All</option>
<div class="btn-group" data-toggle="buttons-checkbox">
	<?php foreach ($type as $type_item):
            if($type_item['typeTitle'] == $category): ?>
                <option value="<?php echo $type_item['typeID'] ?>" selected="selected"><?php echo $type_item['typeTitle'] ?></option>
            <?php else: ?>
		<option value="<?php echo $type_item['typeID'] ?>"><?php echo $type_item['typeTitle'] ?></option>
	<?php 
            endif;
        endforeach ?>
</div>
</select>

<input type="submit" name="submit" class="btn btn-primary pull-right clearfix" value="Post" /> 
	
</form>
</div>