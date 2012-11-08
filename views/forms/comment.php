<div class="comment-form">
<?php   
$txt_comment = array(
    'name' => 'commentText',
    'rows' => '0',
    'cols' => '0',
    'class' => 'expanding',
  );

    echo validation_errors(); 

    echo form_open('posts/thread');

    echo form_hidden('postID', $postID);
    echo form_textarea($txt_comment);
	
?>

<input type="submit" name="submit" class="btn btn-primary pull-right clearfix" value="Comment" /> 
	
</form>
</div>