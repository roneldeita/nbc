<?php
namespace App\Services;
use App\Notification;
use Auth;
use DB;
/**
*
*/
class Notifications
{

	public function Create ($project, $type) {
		$notification = new Notification;
		$notification->project_id = $project->id;
		$notification->type = $type;
		$notification->from = $project->client_id;
		$notification->to = $project->coordinator_id;
		$notification->content = json_encode(array("id" => $project->id, "name" => $project->name));
		$notification->seen = 2;
		$notification->save();
	}

	public function CreateV2 ($data) {
		$notification = new Notification;
		$notification->project_id = $data['project_id'];
		$notification->type = $data['type'];
		$notification->from = Auth::user()->id;
		$notification->to = $data['to'];
		$notification->content = json_encode($data['content']);
		$notification->seen = 2;
		$notification->save();

	}

	public function All ($id) {
		$notification = Notification::where('to', $id)->orderBy('id', 'desc')->get();
		return $notification;
	}
	public function Unread ($id) {
		$notification = Notification::where('to', $id)->where('seen', 2)->orderBy('id', 'desc')->get();
		return $notification;
	}
	public function UnreadForCoordinator ($id) {
		$notification = Notification::where('to', $id)->where('seen', 2)->where('type', 1)->orderBy('id', 'desc')->get();
		return $notification;
	}
	public function MarkAsRead ($id) {
		DB::table('notifications')->where('to', Auth::user()->id)->where('project_id', $id)->update(['seen' => 1]);
	}

	public function MarkAsReadOld ($id) {
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
