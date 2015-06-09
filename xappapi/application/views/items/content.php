<?php
    switch ($page)
    {
		case "items":
          include_once("items.php");
          break;        
        case "items_edit":
          include_once("items_edit.php");
          break;
        case "items_details":
          include_once("items_details.php");
          break;
      case "items_add":
          include_once("items_add.php");
          break;
        default:
          break;
    }
?>