<?php
    switch ($page)
    {
		case "users":
          include_once("users.php");
          break;        
        case "users_edit":
          include_once("users_edit.php");
          break;
        case "users_details":
          include_once("users_details.php");
          break;
      case "users_add":
          include_once("users_add.php");
          break;
        default:
          break;
    }
?>