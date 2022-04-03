<?

<form action="<?=admin_url('admin-ajax.php?action=custom_send_mail');?>"></form>/* custom_send_mail in functions.php*/

add_action('wp_ajax_custom_send_mail', 'custom_send_mail');
add_action('wp_ajax_nopriv_custom_send_mail', 'custom_send_mail');

function custom_send_mail()
{
  // подразумевается что $to, $subject, $message уже определены...
  $name = $_POST['name'];
  $email = $_POST['email'];
  $subject = $_POST['subject'];
  $message = $_POST['message'];
  $to = get_option('admin_email');

  $message = $message . ' ' . $name . ' ' . $email;

  // удалим фильтры, которые могут изменять заголовок $headers
  remove_all_filters( 'wp_mail_from' );
  remove_all_filters( 'wp_mail_from_name' );

  $headers = array(
    'From: noreply <noreplay@'.$_SERVER['HTTP_HOST'].'>',
    'content-type: text/html',
    // 'cc: John 1 Codex <jqc@wordpress.org>',
    // 'cc: John 2 Codex <j2qc@wordpress.org>',
    // 'bcc: iluvwp@wordpress.org', // тут можно использовать только простой email адрес
  );

  wp_mail($to, $subject, $message, $headers);
}



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
