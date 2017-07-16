<?php

//main tpl deploy
$maintemplate="deploy/deploytpl/deploy.tpl";



//conflict resolution

//"force" to ignore conflict and force deployment even if files are lost or surcharged
//or "keep" to keep all conflict files after a "Deploy" (to check manually differences after deployment)
//or "reverse" to force install complete and to keep story of conflicts and allow revert files when you select "Destroy" for a package

$conflictresolution="reverse";

?>