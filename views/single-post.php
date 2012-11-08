<div class="single-post">
    <?php foreach ($post as $post_item): ?>

            <div class="post-item clearfix">
                <div class="post-info well well-large clearfix">
                    <div class="user-thumb">
                        <a href="/user/profile/<?php echo $post_item['userAlias'] ?>">
                            <img src="/image.php<?php echo $post_item['profilePhoto'] ?>?width=64&amp;height=64&amp;cropratio=1:1&amp;image=<?php echo $post_item['profilePhoto'] ?>" alt="Picture of <?php echo $post_item['userAlias'] ?>">
                        </a>
                    </div>
                    <div class="post-info">
                        <div class="date muted pull-right">
                             <?php echo date('g:ia n/j/Y',strtotime($post_item['postCreated'])) ?>
                        </div>
                        <a href="/user/profile/<?php echo $post_item['userAlias'] ?>">
                                <?php echo $post_item['userAlias'] ?>
                        </a>
                    </div>
                    <p class="post-text"><?php echo $post_item['postText'] ?></p>
                </div>
            <?php if(${'comment'.$post_item['postID']}): ?>
                    <div class="post-comments page-comments">
                            <?php foreach (array_reverse(${'comment'.$post_item['postID']}, TRUE) as $comment): ?>
                                    <div class="comment-item clearfix">
                                            <div class="user-thumb">
                                                <a href="/user/profile/<?php echo $comment['userAlias'] ?>">
                                                    <img src="/image.php<?php echo $comment['profilePhoto'] ?>?width=32&amp;height=32&amp;cropratio=1:1&amp;image=<?php echo $comment['profilePhoto'] ?>" alt="Picture of <?php echo $comment['userAlias'] ?>">
                                                </a>
                                            </div>

                                            <div class="comment-info">
                                                <div class="date muted pull-right">
                                                    <?php echo date('g:ia',strtotime($comment['commentDate'])) ?>
                                                </div>
                                                <a href="/user/profile/<?php echo $comment['userAlias'] ?>">
                                                        <?php echo $comment['userAlias'] ?>
                                                </a>			
                                                <p class="comment-text"><?php echo $comment['commentText'] ?></p>
                                            </div>
                                    </div>
                            <?php endforeach ?>
                    </div>
            <?php endif; ?>
        </div>

    <?php endforeach ?>
</div>