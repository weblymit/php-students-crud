<?php
function debug($array)
{
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

// verifie si user islogin
function init_php_session()
{
    if (!session_id()) {
        session_start();
        session_regenerate_id();
        return true;
    }

    return false;
}


function clean_php_session()
{
    session_unset();
    session_destroy();
}
