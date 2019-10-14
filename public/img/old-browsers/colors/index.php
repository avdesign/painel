<?php
/**
 *	   ___ _    __   ____            _           
*     /   | |  / /  / __ \___  _____(_)___ _____ 
*    / /| | | / /  / / / / _ \/ ___/ / __ `/ __ \
*   / ___ | |/ /  / /_/ /  __(__  ) / /_/ / / / /
*  /_/  |_|___/  /_____/\___/____/_/\__, /_/ /_/ 
*                                  /____/        
 * ------------ By Anselmo Velame --------------- 
 *
 * Página retorno
 */

/* Events list */
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
    
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
    
header("Location: ../");
exit;