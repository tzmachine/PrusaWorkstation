<?php
$temp = (int)$_GET['temp'];
$action = $_GET['setTemp'];

echo "$temp";
echo "$action";

if ($action === 'setTemp') {
    $command = "set chamber temp to $temp";
    //shell_exec($command);
    echo "$command";
} else {
    echo "unallowed action";
}
?>
