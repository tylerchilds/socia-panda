<?php

$txt_message = array(
    'name' => 'message',
    'rows' => '0',
    'cols' => '0',
    'class' => 'expanding',
  );
$send = array(
    'name' => 'submit',
    'value' => 'Send',
    'class' => 'btn btn-primary shove-down pull-right',
);
$reply = array(
    'name' => 'submit',
    'value' => 'Send',
    'class' => 'btn btn-primary shove-down pull-right clearfix',
);
    if(isset($create))
    {
        echo '<div class="new-message">';
        echo '<h2>Panda Message for '.$userAlias.'</h2>';
        echo validation_errors();
	echo form_open('messages/new_message');
        echo form_hidden('userAlias', $userAlias);
	echo form_textarea($txt_message);
        echo form_submit($send);
    }
    else
    {
        echo '<div class="reply-message">';
        echo validation_errors();
        echo form_open('messages/view');

	echo form_hidden('threadID', $threadID);
	echo form_textarea($txt_message);
        echo form_submit($reply);
    }	
?>
	
</form>
</div>
