<?php
if(count($_COOKIE) > 0) {
    echo "Cookie check: Cookies are enabled.";
} else {
    echo "Cookie check: Cookies are disabled.";
}