
<?php
function  Navigation()
{
    $activePage = basename($_SERVER['PHP_SELF']);
    $rows = file('../navigation/navigation.txt');
    echo '<ul>';
    foreach($rows as $row)
    {
       $nav = explode(":", $row);
       if (count($nav) == 2)
        {
            $page = trim($nav[0]);
            $link = trim($nav[1]);
            if($link == $activePage)
            {
                echo '<li  class="active">' . $page . '</li>';
            }
            else
            {
                echo '<li><a href="' . $link .  '">' . $page . '</a></li>';
            }
        }
    }
    echo '</ul>';
}
?>
