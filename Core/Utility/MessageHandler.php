<?php

namespace Core\Utility;

/**
* Validator
*/
class MessageHandler
{
    
	const STATUS_SUCCESS = 0;
	const STATUS_INFO = 1;
	const STATUS_WARNING = 2;
	const STATUS_DANGER = 3;

	public static function add(string $message, int $status)
	{
		$_SESSION["messages"][] = ["message" => $message, "status" => $status];
	}

	public static function display()
	{
		if(!is_null($_SESSION["messages"])) {
			foreach($_SESSION["messages"] as $message) {
				$alertClass = "alert-success";
				switch($message["status"]) {
					case MessageHandler::STATUS_SUCCESS:
						$alertClass = "alert-success";
						break;

					case MessageHandler::STATUS_INFO:
						$alertClass = "alert-info";
						break;

					case MessageHandler::STATUS_WARNING:
						$alertClass = "alert-warning";
						break;

					case MessageHandler::STATUS_DANGER:
						$alertClass = "alert-danger";
						break;

					default:
						$alertClass = "alert-success";
						break;
				}

				echo "<div class='alert " . $alertClass . "'><a href='#' class='close' data-dismiss='alert'>&times;</a>" . $message["message"] . "</div>";
			}
		}
		self::clear();
	}

	private static function clear()
	{
		$_SESSION["messages"] = null;
	}
}