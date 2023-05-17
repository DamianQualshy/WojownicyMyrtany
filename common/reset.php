<?php


function resets ()
{
    mysqli_query($GLOBALS['db'], 'UPDATE `hp`=`max_hp`, `zmeczenie`=0');  
}
?> 