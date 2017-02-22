<?php
/**
 * Created by PhpStorm.
 * User: george
 * Date: 2/5/17
 * Time: 12:37 AM
 */
echo(file_get_contents('http://numbersapi.com/'.$_GET["m"].'/'.$_GET["d"].'/date'));