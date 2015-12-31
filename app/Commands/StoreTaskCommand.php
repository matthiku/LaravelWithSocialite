<?php 

namespace App\Commands;

use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;

use App\Task;


class StoreTaskCommand extends Command implements SelfHandling {

	public $name;

	public function __construct($name) {
		$this->name = $name;
	}


	public function handle() {
		return Task::create([
			'name'	=> $this->name;
		])
	}
}