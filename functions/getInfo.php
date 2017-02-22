<?php
include("../info.php");
echo "Copyright";
echo $info->getPrettyCopyright();
echo "\n";
echo "Version";
echo $info->getPrettyVersion();
echo "\n";