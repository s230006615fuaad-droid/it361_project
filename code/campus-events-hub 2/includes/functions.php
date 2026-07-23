<?php
function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function format_event_date($date)
{
    return date('d M Y', strtotime($date));
}

function format_event_time($time)
{
    return date('g:i A', strtotime($time));
}

function old_value($name, $default = '')
{
    return isset($_POST[$name]) ? e($_POST[$name]) : e($default);
}

function active_page($file)
{
    return basename($_SERVER['PHP_SELF']) === $file ? 'active' : '';
}
?>
