<?



// add_role();
// https://wp-kama.ru/function/add_role



add_action('wp_enqueue_scripts', 'add_styles');
add_action('wp_footer', 'add_scripts');
add_action('after_setup_theme', 'reg_nav_menu');
add_action('after_setup_theme', 'reg_theme_supports');

add_filter('nav_menu_css_class', 'add_class_for_item_nav_menu', 0, 3);
add_filter('navigation_markup_template', 'custom_pagination_template', 10, 2);

add_action('init', 'reg_taxonomies');
add_action('init', 'reg_post_types');
add_action('init', 'reg_taxonomies_for_posts');
add_action('widgets_init', 'reg_sidebar_widgets');
// add_action('wp_ajax_custom_send_mail', 'custom_send_mail');
// add_action('wp_ajax_nopriv_custom_send_mail', 'custom_send_mail');



add_image_size('news-preview', 446, 290, true);
add_image_size('news-main', 697, 453, true);



add_action('test_action', 'test_action_function', 100);
function test_action_function()
{
  return 'TEST';
}
//do_action('test_action');



add_shortcode('test_shortcode', 'test_shortcode_function', 100);
function test_shortcode_function()
{
  return 'TEST';
}



function add_styles()
{
  wp_enqueue_style('style', get_stylesheet_uri());
  wp_enqueue_style('libs_header', get_template_directory_uri() . '/assets/css/libs/header.min.css');
  wp_enqueue_style('header', get_template_directory_uri() . '/assets/css/header.min.css');
  wp_enqueue_style('libs_footer', get_template_directory_uri() . '/assets/css/libs/footer.min.css');
  wp_enqueue_style('footer', get_template_directory_uri() . '/assets/css/footer.min.css');
}



function add_scripts()
{
  wp_enqueue_script('libs_header', get_template_directory_uri() . '/assets/js/libs/header.min.js');
  wp_enqueue_script('header', get_template_directory_uri() . '/assets/js/header.min.js');
  wp_enqueue_script('libs_footer', get_template_directory_uri() . '/assets/js/libs/footer.min.js');
  wp_enqueue_script('footer', get_template_directory_uri() . '/assets/js/footer.min.js');
}



function reg_nav_menu()
{
  register_nav_menu('nav_menu_top_main', 'Верхнее меню главной страницы');
  register_nav_menu('nav_menu_top_secondary', 'Верхнее меню второстепенных страниц');
}



function reg_theme_supports()
{
  add_theme_support('post-thumbnails', array('page', 'post', 'news'));

  add_theme_support('post-formats', array('aside', 'chat', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio')); //aside chat gallery link image quote status video audio

  add_theme_support('custom-logo', [
    // 'height'      => 190,
    // 'width'       => 190,
    'flex-width'  => true,
    'flex-height' => true,
    'header-text' => '',
    'unlink-homepage-logo' => true, // WP 5.5
  ]);
}



function add_class_for_item_nav_menu($classes, $item, $args)
{
  if (isset($args->menu_item_class)) {
    $classes[] = $args->menu_item_class;
    // echo '<pre style="background-color:white;">';
    // var_dump($classes);
    // var_dump($item);
    // echo '</pre>';
  }
  return $classes;
}



function custom_pagination_template($template, $class)
{
  /*
	Вид базового шаблона:
	<nav class="navigation %1$s" role="navigation">
		<h2 class="screen-reader-text">%2$s</h2>
		<div class="nav-links">%3$s</div>
	</nav>
	*/

  return '
    <nav class="navigation %1$s" role="navigation">
      <h2 class="screen-reader-text">%2$s</h2>
      %3$s
    </nav>
	';
}



function reg_post_types()
{
  // https://wp-kama.ru/function/register_post_type
  register_post_type('news', [
    'label'  => null,
    'labels' => [
      'menu_name'          => 'Новости', // название меню
      'name'               => 'Новости', // основное название для типа записи
      'singular_name'      => 'Новость', // название для одной записи этого типа
      'add_new'            => 'Добавить новость', // для добавления новой записи
      'add_new_item'       => 'Добавление новости', // заголовка у вновь создаваемой записи в админ-панели.
      'edit_item'          => 'Редактирование новости', // для редактирования типа записи
      'new_item'           => 'Новая новость', // текст новой записи
      'view_item'          => 'Смотреть новость', // для просмотра записи этого типа.
      'search_items'       => 'Искать новость', // для поиска по этим типам записи
      'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
      'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
      'parent_item_colon'  => '', // для родителей (у древовидных типов)
    ],
    'description'         => '',
    'public'              => true,
    // 'publicly_queryable'  => null, // зависит от public
    // 'exclude_from_search' => false, // зависит от public
    // 'show_ui'             => null, // зависит от public
    // 'show_in_nav_menus'   => null, // зависит от public
    'show_in_menu'        => true, // показывать ли в меню адмнки
    // 'show_in_admin_bar'   => null, // зависит от show_in_menu
    'show_in_rest'        => false, // добавить в REST API. C WP 4.7
    'rest_base'           => false, // $post_type. C WP 4.7
    'menu_position'       => 2,
    'menu_icon'           => 'dashicons-megaphone',
    //'capability_type'   => 'post',
    //'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
    //'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
    'hierarchical'        => false,
    'supports'            => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes'], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
    'taxonomies'          => [],
    'has_archive'         => true,
    'rewrite'             => true,
    'query_var'           => true,
  ]);
}



function reg_sidebar_widgets()
{
  register_sidebar(array(
    'name'          => 'Сайдбар (панель виджетов)',
    'id'            => "sidebar-widgets",
    'description'   => '',
    'class'         => '',
    'before_widget' => '<li id="%1$s" class="widget %2$s">',
    'after_widget'  => "</li>\n",
    'before_title'  => '<h2 class="widgettitle">',
    'after_title'   => "</h2>\n",
    'before_sidebar' => '', // WP 5.6
    'after_sidebar'  => '', // WP 5.6
  ));
}


function reg_taxonomies()
{
  // https://wp-kama.ru/function/register_taxonomy_for_object_type
  // список параметров: wp-kama.ru/function/get_taxonomy_labels
  // register_taxonomy('author', ['news'], [
  //   'label'                 => '', // определяется параметром $labels->name
  //   'labels'                => [
  //     'name'              => 'Автор',
  //     'singular_name'     => 'Автор',
  //     'search_items'      => 'Найти авторов',
  //     'all_items'         => 'Все авторы',
  //     'view_item '        => 'Посмотреть автора',
  //     'parent_item'       => 'Родительский автор',
  //     'parent_item_colon' => 'Родительский автор:',
  //     'edit_item'         => 'Редактировать автора',
  //     'update_item'       => 'Обновить автора',
  //     'add_new_item'      => 'Добавить нового автора',
  //     'new_item_name'     => 'Имя нового автора',
  //     'menu_name'         => 'Автор',
  //     'back_to_items'     => '← Назад к автору',
  //   ],
  //   'description'           => 'Атворы новости', // описание таксономии
  //   'public'                => true,
  //   // 'publicly_queryable'    => null, // равен аргументу public
  //   // 'show_in_nav_menus'     => true, // равен аргументу public
  //   // 'show_ui'               => true, // равен аргументу public
  //   // 'show_in_menu'          => true, // равен аргументу show_ui
  //   // 'show_tagcloud'         => true, // равен аргументу show_ui
  //   // 'show_in_quick_edit'    => null, // равен аргументу show_ui
  //   'hierarchical'          => false,

  //   'rewrite'               => true,
  //   //'query_var'             => $taxonomy, // название параметра запроса
  //   'capabilities'          => array(),
  //   'meta_box_cb'           => null, // html метабокса. callback: `post_categories_meta_box` или `post_tags_meta_box`. false — метабокс отключен.
  //   'show_admin_column'     => false, // авто-создание колонки таксы в таблице ассоциированного типа записи. (с версии 3.5)
  //   'show_in_rest'          => null, // добавить в REST API
  //   'rest_base'             => null, // $taxonomy
  //   // '_builtin'              => false,
  //   //'update_count_callback' => '_update_post_term_count',
  // ]);
}



function reg_taxonomies_for_posts()
{
  // register_taxonomy_for_object_type('author', 'news');
}



function custom_send_mail()
{
  // подразумевается что $to, $subject, $message уже определены...
  // $name = $_POST['name'];
  // $email = $_POST['email'];
  // $subject = $_POST['subject'];
  // $message = $_POST['message'];
  // $to = get_option('admin_email');

  // $message = $message . ' ' . $name . ' ' . $email;

  // // удалим фильтры, которые могут изменять заголовок $headers
  // remove_all_filters('wp_mail_from');
  // remove_all_filters('wp_mail_from_name');

  // $headers = array(
  //   'From: noreply <noreplay@' . $_SERVER['HTTP_HOST'] . '>',
  //   'content-type: text/html',
  //   // 'cc: John 1 Codex <jqc@wordpress.org>',
  //   // 'cc: John 2 Codex <j2qc@wordpress.org>',
  //   // 'bcc: iluvwp@wordpress.org', // тут можно использовать только простой email адрес
  // );

  // wp_mail($to, $subject, $message, $headers);
}
