<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
   // protected $signature = 'app:test-command';
    protected $signature = 'user:test {data} {--a} {--b=} {--O|options=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
      $this->line($this->argument('data'));
      $this->info($this->option('a'));
      $this->warn($this->option('b'));
      $this->error($this->option('options'));
      $this->newLine();
      /*
		$data = $this->ask('Введите данные: ');
		$this->comment($data);
		if ($this->confirm('Уверены?: ')) {
			$this->line('yes');
		}else{
			$this->line('no');
		}
		*/
		//$this->call('list');
    }
}
