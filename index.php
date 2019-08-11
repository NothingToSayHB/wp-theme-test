<?php get_header();?>

<div class="container">

    <div class="row">

        <div class="col">
 
        <?php if (have_posts()):?>
            <?php while(have_posts()): the_post();?>
                    <div class="card posts">
                        <div class="card-header">
                            <h3 class="card-title"><?php the_title();?></h3>
                        </div>
                        <div class="card-body">
                            <?php if (has_post_thumbnail()):?>
                                <?php the_post_thumbnail('thumbnail');?>
                            <?php else:?>
                                <p>Netu!</p>
                            <?php endif;?>
                            <p><?php the_excerpt();?></p>  
                            <a class="d-block" href="<?php the_permalink();?>"><?php echo __('Читать далие', 'test')?></a>
                        </div>
                    </div>
            <?php endwhile;?>
            <?php else:?>
                <p>Netu postov</p>
            <?php endif;?>

        </div>
        <?php get_sidebar(); ?>
    </div>
    
<?php the_posts_pagination(array(

        // 'type' => 'list', // делает список
    ));?>
</div>

<?php $queery = new WP_Query([
    'category_name' => 'markup,edge-case-2',
    'posts_per_page' => -1,
    'orderby' => 'title',
    'order' => 'ASC'
]);
?>
<?php if ($queery->have_posts()):?>
<?php while($queery->have_posts()): $queery->the_post();?>
<h3><?php the_title();?></h3>
<?php endwhile;?>
<?php endif;?>
<?php wp_reset_postdata();?>

<?php get_footer();?>






