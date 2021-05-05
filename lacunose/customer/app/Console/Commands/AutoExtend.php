<?php

namespace Lacunose\Customer\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\Console\Exception\RuntimeException;

use DB, Exception, Log, Str, Storage;
use Carbon\Carbon;

use Lacunose\Customer\Models\Account;

use Lacunose\Customer\Aggregates\AccountAggregateRoot;

class AutoExtend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tcust:extend {--website_id=} {--date=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perpanjangan otomatis - Tenant Aware';

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var WebsiteRepository
     */
    private $websites;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        if ( Str::is('tenant', config()->get('tswirl.db.tcust')) ) {
            $this->websites = app(\Hyn\Tenancy\Contracts\Repositories\WebsiteRepository::class);
            $this->connection = app(\Hyn\Tenancy\Database\Connection::class);
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ( Str::is('tenant', config()->get('tswirl.db.tcust')) ) {
            $website_id = $this->option('website_id');
            try{
                $website = $this->websites->query()->where('id', $website_id)->firstOrFail();
                $this->connection->set($website);
                $this->info('Running Command on website_id: ' . $website_id);

                $this->doit();

                $this->connection->purge();
            } catch (ModelNotFoundException $e) {
                throw new RuntimeException(
                    sprintf(
                        'The tenancy website_id=%d does not exist.',
                        $website_id
                    )
                );
            }
        }else{
            $this->doit();
        }
    }
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function doit()
    {
        $date       = now()->startOfDay()->addDays(config()->get('tcust.setting.due_days'));

        if(!is_null($this->option('date'))){
            $date   = Carbon::parse($this->option('date'))->startOfDay()->addDays(config()->get('tcust.due_days'));
        }
        $next       = Carbon::parse($date)->addDays(1);
        $subs       = Account::where('is_extendable', true)->where('ended_at', $date)->get();

        foreach ($subs as $sub) {
           try {
                $url    =  route('tcust.account.show', ['mode' => $sub->mode, 'id' => $sub->uuid]);
                $data   = AccountAggregateRoot::retrieve($sub->uuid)->customer($next, $url)->persist();   
            } catch (Exception $e) {
                Log::info('CONSOLE CUSTOMER EXTEND');
                Log::info($e);
            }
        }
    }
}
