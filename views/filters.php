<div class="span3">
    <button type="button" class="btn btn-primary visible-phone shove-down" data-toggle="collapse" data-target="#filter-collapse">
        <i class="icon-filter icon-white"></i> Filters <span class="caret"></span>
    </button>
 
    <div id="filter-collapse" class="collapse clearfix">
        <h3>Filters</h3>
        <div class="filter-section">
        <h4>Categories</h4>
        <ul>
        <?php foreach ($type as $type_item): ?>
            <li>
                <a href="/posts/view/<?php echo $type_item['typeTitle'] ?>">
                <?php echo $type_item['typeTitle'] ?>
                </a>
            </li>
        <?php endforeach ?>
        </ul>
        </div>
        <div class="filter-section">
        <?php if($this->session->userdata('logged_in') == TRUE): ?>
            <h4>People</h4>
            <ul>
                <li><a href="/posts/view/following">Following</a></li>
                <li><a href="/posts/view/followers">Followers</a></li>
            </ul>
        <?php endif; ?>
        </div>
    </div>
    
</div>