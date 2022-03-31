<?

get_header();
get_header('test'); // = header-test.php

get_footer();
get_footer('test'); // = footer-test.php

get_sidebar();



the_post();



if (have_posts()) : while (have_posts()) : the_post();
?>
    <h1><? the_title(); ?></h1>
    <? the_post_thumbnail('news-main', array('alt' => get_the_title(), 'class' => 'page-news__img')); ?>
    <time>
      <?= get_the_date(); ?>
      <?= ' - ' . get_the_time(); ?>
    </time>
<?
  endwhile;
endif;




get_template_part('some-dir/some-template');
get_post_format(); //'aside', 'chat', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio'
get_template_part('some-dir/some-template', get_post_format());//some-dir/some-template-chat if get_post_format = chat


is_home();
