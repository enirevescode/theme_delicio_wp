<?php get_template_part('header-pizze'); ?>
<br>
<br>
<div class="row">
   <div class="col">
      <h1>La Carte des <?php single_cat_title('', true); ?></h1>
   </div>
</div>
<br>
<!-- <article class="post"> -->
<section>
<div class="container">
<!-- <article class="post"> -->
      <?php if (have_posts()) : ?>
         <div class="row justify-content-between">
            <?php while (have_posts()) : the_post(); ?>
            <div class="card-group" style="width: 17rem">
               <!-- <div class="img-fluid"> -->
                  <a href="<?php the_permalink(); ?>">
                     <?php the_post_thumbnail('smartph', ['class' => 'card-img-top', 'alt' => '']) ?>
                  </a>
                  <div class="card-body">
                        <h6 class='card-title' style="text-align:center"><a href="<?php the_permalink(); ?>"><?php echo get_post_meta(get_the_ID(), 'pizza', true); ?></a></h6>
                        <p class="card-text-single mx-3 my-3"><?php echo get_post_meta(get_the_ID(), 'recette_de_la_pizza', true); ?></p>
                   </div>
                        <div class="card-footer">
                        <small class="text-muted">
                        <p class="card-text-prix"><?php echo get_post_meta(get_the_ID(), 'prix_de_la_pizza', true); ?> €</p></small>
                        </div>
               <!-- </div> -->
            </div>
         <?php endwhile; ?>
      </div>
</div>
         <?php else : ?>
            <h1>Pas d'articles</h1>
         <?php endif; ?>
</section>
<!-- </article> -->
<?php get_footer(); ?>

<div class="card-group">
   <div class="card">
      <img class="card-img-top" src="..." alt="Card image cap">
         <div class="card-body">
            <h5 class="card-title">Card title</h5>
               <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
         </div>
                  <div class="card-footer">
                     <small class="text-muted">Last updated 3 mins ago</small>
                  </div>
</div>