<div class="span3 user-info">
<?php 
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
	
    echo '<div class="profile-photo">';
    echo "<img src=\"/image.php/$photo?width=300&amp;height=300&amp;cropratio:1:1&amp;image=$photo\" alt=\"profile picture\" />";
    echo "</div>";
    echo '<div class="profile-items">';
    echo '<h2 class="user-alias">'.$alias.'</h2>';
    ?>
    <div class="user-buttons">
    <?php if($this->session->userdata('logged_in') == TRUE):
        if($userID == $this->session->userdata('humanoid')):
            echo '<a href="/user/account" class="btn btn-primary">';
            echo '<i class=" icon-pencil icon-white"></i> Edit Profile</a>';
        else:            
    ?>
        <div class="btn-group">
                <? if($is_following): ?>
                    <a href="/user/unfollow/<? echo $alias ?>" class="btn btn-danger">
                    <i class="icon-minus-sign icon-white"></i> Unfollow</a> 
                <? else: ?>
                    <a href="/user/follow/<? echo $alias ?>" class="btn btn-primary">
                    <i class="icon-plus-sign icon-white"></i>  Follow</a> 
                <? endif; ?>
                <a href="/messages/new_message/<? echo $alias ?>" class="btn btn-primary">
                    <i class="icon-envelope icon-white"></i> PM</a> 
        </div>
    <?php
        endif;
    endif;
    echo '</div>'; // end user-buttons div
    ?>
    <button type="button" class="btn btn-success visible-phone shove-down" data-toggle="collapse" data-target="#user-collapse">
        About <? echo $alias ?> <i class="icon-info-sign icon-white"></i>
    </button>
 
    <div id="user-collapse" class="collapse">
    <?php
    if($gender != "none")
    {   
        echo '<div class="user-gender">';
        echo '<h3>Gender:</h3>';
        echo "<p>$genderSelect[$gender]</p>";
        echo '</div>';
    }

    if($status != "none")
    {
        echo '<div class="user-relationship">';
        echo '<h3>Difficulty:</h3>';
        echo "<p>$statusSelect[$status]</p>";
        echo '</div>';
    }

    if($info != '')
    {
        echo '<div class="user-information">';
        echo "<h3>Information</h3>";
        echo '<p class="information">'.html_entity_decode($info).'</p>';
        echo '</div>';
    }
?>
        </div> <!-- End user-collapse -->
    </div> <!-- end Profile Items -->
    <div style="clear: both;"></div>
</div>