<article class="<?php echo($post_status);?> <?php echo($oe_style); ?>">
    <div class="row">
        <div class="one-quarter meta">
            <div class="thumbnail">
                <img src="<?php echo($post_image); ?>" alt="<?php echo($post_title); ?>" />
            </div>

            <ul>
                <li><small>by:</small> <?php echo($post_author); ?></li>
                <li><small>on:</small> <?php echo($published_date); ?></li>
                <li><small>filed in:</small> <a href="<?php echo($post_category_link); ?>"><?php echo($post_category); ?></a></li>
                <li></li>
            </ul>
        </div>

        <div class="three-quarters post">
            <h2><a href="<?php echo($post_link); ?>"><?php echo($post_title); ?></a></h2>

            <?php echo($post_intro); ?>

            <ul class="actions">
                <li><a class="button" href="<?php echo($post_link); ?>">Continue Reading</a></li>
                <?php if ($category) { ?>
                <li><a class="button" href="<?php echo($blog_url); ?>blog/">More Articles</a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</article>
