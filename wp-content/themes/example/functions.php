<?



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



// add_role();
// https://wp-kama.ru/function/add_role