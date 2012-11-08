    <?php if(isset($success)): ?>
        <div class="alert alert-success span12">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <span class="label label-success">Success!</span> Profile updated.
        </div>
    </div>
    <div class="row-fluid">
    <?php endif; ?>
<div class="span6">
    <div class="edit-profile">
    <h2>Edit Profile</h2>
    
<?php 
    
    echo validation_errors();

    echo form_open_multipart('user/account');
	
        $genderSelect = array(
        'none' => 'Not Specified',
        'male' => 'Male',
        'female' => 'Female'
    );


    $statusSelect = array(
        'none' => 'Not Specified',
        'swag' => 'Swaggin',
        'single' => 'Single',
        'relationship' => 'In a Relationship',
        'engaged' => 'Engaged',
        'married' => 'Married'     
    );
            
        echo form_label('Alias:', 'alias');
        echo form_input('alias', $this->session->userdata('alias'));
        
	// gender field
	echo form_label('Gender:', 'gender');
	echo form_dropdown('gender', $genderSelect, $gender);

	// relationship status field
	echo form_label('Relationship Status:', 'status');
	echo form_dropdown('status', $statusSelect, $status);
	
	// information field
	echo form_label('Information:', 'info');
	echo form_textarea('info', $info);

	// profile picture upload
	echo form_label('Profile Picture:', 'photo');
	echo form_upload('photo');	
?>

	<input class="btn btn-primary shove-down" type="submit" name="submit" value="Update" /> 
        </div>
</div>
<div class="span6">
    <?php
    echo '<div class="edit-photo">';
    echo "<img src=\"/image.php/$id.jpg?width=200&amp;height=200&amp;image=$photo\" alt=\"profile picture\" />";
    echo '</div>';
    ?>
</div>
</form>