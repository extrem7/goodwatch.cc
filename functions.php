<?

require_once "app/Theme.php";

function watch()
{
    return Theme::getInstance();
}

watch();

add_action( 'comment_post', 'action_function_name_11', 10, 2,true);
function action_function_name_11( $comment_ID, $comment_approved ) {
    $value = 1;
    setcookie("isComment", $value);
    //wc_add_notice( $value, 'success');
}

if ( !is_admin() ) wp_deregister_script('jquery');






