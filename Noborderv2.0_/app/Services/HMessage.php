<?php

namespace App\Services;

use Auth;
use DB;

use App\Message;

class HMessage
{
	public function Create ($request){
		$message = new Message;
		$message->project_id = $request->get('projectId');
		$message->message = $request->get('message');
		$message->to = $request->get('receiver');
		$message->from = Auth::user()->id;
		$message->type = $request->get('status');
		$message->seen = 2;
		$message->save();
	}

	public function Static ($data) {
		$message = new Message;
		$message->project_id =$data["projectId"];
		$message->message = $data["message"];
		$message->to = Auth::user()->id;
		$message->from = $data["from"];
		$message->type = $data["status"];
		$message->seen = 2;
		$message->save();
	}

	public function Seen ($request) {
		DB::table('messages')
			->where('project_id',$request->get('projectId'))
			->where('to', Auth::user()->id)
			->where('type', $request->get('status'))
			->update(['seen' => 1]);
	}

	public function seenChat () {
		DB::table('messages')
			->where('project_id',$request->get('projectId'))
			->where('to', Auth::user()->id)
			->where('type', $request->get('status'))
			->update(['seen' => 1]);
	}

	public function All () {
		//$messages = Message::select('project_id',DB::raw('* as something'))->where('to', Auth::user()->id)->groupBy('project_id')->get();
		$messages = DB::select("
			select max(a.created_at) as date, max(a.id) as id, projects.name,
			(select message from messages where created_at = max(a.created_at)) message,
			(select seen from messages where created_at = max(a.created_at)) seen,
			(select messages.from from messages where created_at = max(a.created_at)) as sender
			from messages a join projects ON projects.id = a.project_id
			WHERE a.from != 2
			group by projects.name
			");

		$seen = collect($messages)->pluck('seen');
		$unseen = array_diff($seen->all(), array(1));
		return array("messages" => $messages, "unseen" => $unseen);
	}

	public function ProjectChat ($project_id, $status) {
		$messages = Message::where('to', Auth::user()->id)->where('project_id', $project_id)->where('type', $status)->get();
		return $messages;
	}
}
?>