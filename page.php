<?php get_header()?>
<div class="container">
<div class="row">
<?php if (have_posts()):?>
    <?php while(have_posts()): ?>
        <?php the_post();?>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php the_title();?></h5>
                    <?php if (has_post_thumbnail()):?>
                        <?=the_post_thumbnail('large');?>
                    <?php endif;?>
                    <p><?php the_content();?></p>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
<?php endif; ?>
<div class="col-md-3">
    <?php get_sidebar();?>
</div>
</div>
</div>
<?php get_footer()?>