<?php

namespace Lacunose\Customer\Projectors;

use Arr, Auth, DB, Str;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

use App\Customer;

use Lacunose\Customer\Models\Account;
use Lacunose\Customer\Models\AccountLog;

use Lacunose\Customer\Events\Account\Opened;
use Lacunose\Customer\Events\Account\Issued;
use Lacunose\Customer\Events\Account\Verified;
use Lacunose\Customer\Events\Account\Closed;

use Spatie\EventSourcing\EventHandlers\Projectors\Projector;
use Illuminate\Validation\ValidationException;

final class AccountProjector extends Projector{

    public function onOpened(Opened $event, string $aggregateUuid){
        $acct   = Account::firstornew(['uuid' => $aggregateUuid]);
        $acct->fill($event->attr);
        if(is_null($acct->no)){
            $acct->no   = Account::generateNo();
        }
        //RESET
        $tm = Carbon::parse($event->when);
        switch ($acct->reset_period) {
            case 'daily':
                $tm->startofyear()->startofday()->addDays(1);
                break;
            case 'monthly':
                $tm->startofyear()->startofday()->addMonthsNoOverflow(1);
                break;
            case 'yearly':
                $tm->startofyear()->startofday()->addYears(1);
                break;
            default:
                $tm = null;
                break;
        }
        $acct->resetted_at  = $tm;
        $acct->uuid         = $aggregateUuid;
        $acct->status       = $event->status;
        $acct->save();
    }

    public function onIssued(Issued $event, string $aggregateUuid){
        $acct   = Account::uuid($aggregateUuid);
        $log    = AccountLog::where('account_id', $acct->id)->where('no_ref', $event->attr['no_ref'])->first();
        if(!$log) {
            $log= new AccountLog;
            $log->fill($event->attr);
            $log->account_id        = $acct->id;
            $log->save();
            $acct->pending_balance  = $acct->pending_balance + $log->amount;
            $acct->save();
        }
    }

    public function onVerified(Verified $event, string $aggregateUuid){
        $acct   = Account::uuid($aggregateUuid);
        $amt    = 0;

        foreach ($event->nos as $no) {
            $prev   = AccountLog::where('account_id', $acct->id)->where('verified_at', '<=', $event->when)->sum('amount');
            $log    = AccountLog::where('account_id', $acct->id)->where('no_ref', $no)->wherenull('verified_at')->firstorfail();
            $log->verified_at       = $event->when;
            $log->previous_balance  = $prev;
            $log->save();
            $amt    = $amt + $log->amount;
        }

        $acct->pending_balance  = $acct->pending_balance - $amt;
        $acct->verified_balance = $acct->verified_balance + $amt;
        $acct->save();
    }
    public function onClosed(Closed $event, string $aggregateUuid){
        $acct   = Account::uuid($aggregateUuid);
        $acct->status   = $event->status;
        $acct->save();
        // Account::uuid($aggregateUuid)->delete();
    }
}
