<?php 

namespace App\Services;

use Auth;



class HUser
{
	public static function getRoleId () {
		$role;
		switch (Auth::user()->role) {
			case 1:
				$role = 'client_id';
				break;
			case 2:
				$role = 'worker_id';
				break;
			case 3:
				$role = 'coordinator_id';
				break;
		}
		return $role;
	}


}
?>