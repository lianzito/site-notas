<?php
function redirect($page)
{
    header('location: ' . URLROOT . '/public/index.php?url=' . $page);
    exit();
}