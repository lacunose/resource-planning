<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Validation\ValidationException;
use DB, Validator;

/*----------  Tenancy  ----------*/
use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;

use App\User;

class CreateWebsite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'web:create {fqdn}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create New Website';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        DB::transaction(function () {

            $fqdn = $this->argument('fqdn');

            /*----------  Create Website  ----------*/
            $website = new Website;
            app(WebsiteRepository::class)->create($website);

            /*----------  Link Website to Hostname  ----------*/
            $hostname = new Hostname;
            $hostname->fqdn = $fqdn;
            try {
                $hostname = app(HostnameRepository::class)->create($hostname);
            } catch (ValidationException $e) {
                dd($e->errors());
                throw $e;
            }
            app(HostnameRepository::class)->attach($hostname, $website);

            $this->info("New Website created in $fqdn");
        });
    }
}
