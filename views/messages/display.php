<div class="message-users">
    <h2><?php foreach ($users as $row): ?>
        <?php if($row['userID'] != $myID): ?>
        <?php echo $row['userAlias'] ?>
        <?php 
        endif;
        endforeach; 
    ?>
    <span>and you</span></h2>
</div>
<?php foreach ($message as $message): ?>
<div class="message clearfix">
    <div class="user-thumb">
        <img src="/image.php<?php echo $message['profilePhoto'] ?>?width=64&amp;height=64&amp;image=<?php echo $message['profilePhoto'] ?>" alt="Picture of <?php echo $message['userAlias'] ?>">
    </div>
    <p>
        <div class="date muted pull-right">
            <?php echo date('g:ia n/j/Y',strtotime($message['messageDate'])); ?>
        </div>
        <a href="/user/profile/<?php echo $message['userAlias'] ?>">
            <?php echo $message['userAlias'] ?>
        </a> 
    </p>
    <p>
      <?php echo $message['messageBody'] ?>
    </p>
    
</div>
<?php endforeach ?>