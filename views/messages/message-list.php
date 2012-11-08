<h3>Messages</h3>
<?php foreach ($threads as $thread): ?>
    <?php
        if($thread['threadUnread'] == 1): ?>
            <div class="thread-item">
            <a href="/messages/view/<?php echo $thread['threadID'] ?>" class="thread-link btn btn-primary">
            <div class="thread-users">
            <i class="icon-envelope icon-white"></i>
        <?php else: ?>
            <div class="thread-item">
            <a href="/messages/view/<?php echo $thread['threadID'] ?>" class="thread-link btn">
            <div class="thread-users">
    <?php 
        endif;
        foreach (${'users'.$thread['threadID']} as $row): ?>
        <?php if($row['userAlias'] != $myAlias): ?>
        <?php echo $row['userAlias'] ?>
        <?php 
        endif;
        endforeach; 
    ?>
    <span>and you</span>
</div> <!-- end thread users div -->

        <p>
            <?php 
                foreach (${'message'.$thread['threadID']} as $row):
                    echo $row['messageBody'];
                endforeach; 
            ?>
        </p>
    </a>
</div><!-- end thread item div -->

<?php endforeach ?>