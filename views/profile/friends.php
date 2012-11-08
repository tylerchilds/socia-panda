<div class="span3 friends-module">
    <?php 
        if($following):
        echo '<h4>Following</h4>';
        foreach ($following as $friend):?>
        <div class="friend">
            <a href="/user/profile/<? echo $friend['userAlias'] ?>" rel="tooltip" data-placement="left" title="<? echo $friend['userAlias'] ?>">
                <img src="/image.php/<? echo $friend['profilePhoto'] ?>?width=100&amp;height=100&amp;cropratio=1:1&amp;image=<? echo $friend['profilePhoto'] ?>" alt="Photo of <? echo $friend['userAlias'] ?>" />
            </a>
        </div>
        <?php 
        endforeach;
        endif;
        if($followers):
        echo '<h4>Followers</h4>';
        foreach ($followers as $friend):?>
        <div class="friend">
            <a href="/user/profile/<? echo $friend['userAlias'] ?>" rel="tooltip" data-placement="left" title="<? echo $friend['userAlias'] ?>">
                <img src="/image.php/<? echo $friend['profilePhoto'] ?>?width=100&amp;height=100&amp;cropratio=1:1&amp;image=<? echo $friend['profilePhoto'] ?>" alt="Photo of <? echo $friend['userAlias'] ?>" />
            </a>
        </div>
        <? 
            endforeach;
            endif;
        ?>
</div>