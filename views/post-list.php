<div class="post-list">
    <?php foreach ($post as $post_item): ?>
        <div class="post-item clearfix">
            <div class="post-info well clearfix">
                <div class="user-thumb">
                    <a href="/user/profile/<?php echo $post_item['userAlias'] ?>">
                        <img src="/image.php<?php echo $post_item['profilePhoto'] ?>?width=64&amp;height=64&amp;cropratio=1:1&amp;image=<?php echo $post_item['profilePhoto'] ?>" alt="Picture of <?php echo $post_item['userAlias'] ?>">
                    </a>
                </div>

                <div class="date muted pull-right">
                     <a href="/posts/thread/<?php echo $post_item['postID'] ?>" class="date-permalink">
                         <?php echo date('g:ia n/j/Y',strtotime($post_item['postCreated'])) ?>
                    </a>
                </div>

                    <a href="/user/profile/<?php echo $post_item['userAlias'] ?>">
                            <?php echo $post_item['userAlias'] ?>
                    </a>

            <p class="post-text"><?php echo $post_item['postText'] ?></p>
            </div>
            <?php if(${'count'.$post_item['postID']} > 3): ?>
            <p class="view-thread clearfix">
                    <a href="/posts/thread/<?php echo $post_item['postID'] ?>" class="btn btn-block btn-mini">
                        View All <?php echo ${'count'.$post_item['postID']} ?> Comments
                    </a>
            </p>
            <?php endif; ?>
            <?php if(${'comment'.$post_item['postID']}): ?>
                    <div class="post-comments">
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
        
        <?php if($this->session->userdata('logged_in') == TRUE): ?>
        <!-- comment form -->
        <div class="comment-form clearfix">
        <?php   
        $txt_comment = array(
            'name' => 'commentText',
            'rows' => '0',
            'cols' => '0',
            'class' => 'expanding',
          );

            echo validation_errors(); 

            echo form_open('posts/thread');

            echo form_hidden('postID', $post_item['postID']);
            echo form_textarea($txt_comment);

        ?>
        <input type="submit" name="submit" class="btn btn-primary btn-mini pull-right clearfix" value="Comment" /> 
        </form>
        </div>  
        <?php endif;?>

    </div>
    <?php endforeach ?>
</div>