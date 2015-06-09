<?php
    switch ($page)
    {
		case "medias":
          include_once("medias.php");
          break;        
        case "medias_edit":
          include_once("medias_edit.php");
          break;
        case "medias_details":
          include_once("medias_details.php");
          break;
      case "medias_add":
          include_once("medias_add.php");
          break;
        default:
          break;
    }
?>