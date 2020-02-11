<?

require_once "app/Theme.php";

function watch()
{
    return Theme::getInstance();
}

watch();
