<?php
namespace App\Services;
use App\Notification;
use Auth;
/**
* 
*/
class Notifications
{
	
	public function Create ($project, $type) {
		$notification = new Notification;
		$notification->type = $type;
		$notification->from = $project->client_id;
		$notification->to = $project->coordinator_id;
		$notification->content = json_encode(array("id" => $project->id, "name" => $project->name));
		$notification->seen = 2;
		$notification->save();
	}

	public function CreateV2 ($data) {
		$notification = new Notification;
		$notification->type = $data['type'];
		$notification->from = Auth::user()->id;
		$notification->to = $data['to'];
		$notification->content = json_encode($data['content']);
		$notification->seen = 2;
		$notification->save();

	}

	public function All ($id) {
		$notification = Notification::where('to', $id)->get();
		return $notification;
	}
	public function Unread ($id) {
		$notification = Notification::where('to', $id)->where('seen', 2)->get();
		return $notification;
	}

	public function MarkAsRead ($id) {
		$notification = Notification::find($id);
		$result;
		if (empty($notification)) {
			$result = 0; // false
		} else {
			$notification->seen = 1;
			$notification->save();
			$result = 1; // true
		}
		return $result;
	}
	
}
?>