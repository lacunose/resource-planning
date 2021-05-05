<?php

namespace Lacunose\Customer\Models;

use Str, Validator, Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use App\Customer;

class AccountLog extends Model
{
    public function getConnectionName(){
        if ( Str::is('tenant', config()->get('tswirl.db.tcust')) ) {
            return app(\Hyn\Tenancy\Database\Connection::class)->tenantName();
        }
        return parent::getConnectionName();
    }

    protected $table = 'cust_account_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_id', 'issued_at', 'verified_at', 'no_ref', 'description', 'amount', 'previous_balance',
    ];

    protected $appends = [
    ];

    protected $casts = [];
    
    protected $dates = [
        'issued_at',
        'verified_at',
    ];

    /*
     * relationship belongs to account
     */
    public function account() {
        return $this->belongsTo(Account::class);
    }
   
    /*
     * Scopes to search
     */
    public function scopeSearch($q, $val)
    {
        return $q->where(function($q)use($val){
            $q->where('description', 'like', '%'.$val.'%')
            ;
        });
    }

    public function scopeFilter($q, Array $filters)
    {
        /*----------  Validate  ----------*/
        $rules = [
            'date_gte'  => ['nullable', 'date'],
            'date_lte'  => ['nullable', 'date'],
            'date_gt'   => ['nullable', 'date'],
            'date_lt'   => ['nullable', 'date'],
            'search'    => ['nullable', 'string'],
        ];

        Validator::make($filters, [$rules])->validate();

        /*----------  Query  ----------*/
        foreach ($filters as $field => $val)
        {
            switch (strtolower($field))
            {
                case 'except_ids'   : $q = $q->whereNotIn('id', is_array($val) ? $val : [$val]); break;
                case 'date_gte'     : $q = $q->where('verified_at', '>=', Carbon::parse($val)->endofday()); break;
                case 'date_lte'     : $q = $q->where('verified_at', '<=', Carbon::parse($val)->endofday()); break;
                case 'date_gt'      : $q = $q->where('verified_at', '>', $val); break;
                case 'date_lt'      : $q = $q->where('verified_at', '<', $val); break;
                case 'search'       : $q = $q->search($val); break;
            }
        }

        return $q;
    }

    public function scopeSort($q, Array $sorts)
    {
        /*----------  Validate  ----------*/
        // $rules = [
        //     'field'   => ['nullable', 'in:name,code,type,drafted_at,submitted_at'],
        //     'desc'    => ['nullable', 'boolean'],
        // ];

        // Validator::make($sorts, [$rules])->validate();

        /*----------  Query  ----------*/
        foreach ($sorts as $field => $val)
        {
            $q = $q->accountby($field, $val);
        }

        return $q;
    }

    /*
     * Scopes to search
     */
    public function scopeMode($q, $val) {
        switch (strtolower($val)) {
            case 'verified':
                return $q->wherenotnull('verified_at');
                break;
            
            default:
                return $q->wherenull('verified_at');
                break;
        }
    }
    public static function generateNo() {
        $prefix     = 'CLOG.'.now()->format('ym');
        $idx        = self::where('no_ref', 'like', $prefix.'%')->count() + 1;
        do{
            $no     = $prefix.'.'.str_pad($idx, 4, '0', STR_PAD_LEFT);
            $exists = self::where('no_ref', $no)->first();
            $idx++;
        }while ($exists);
        
        return $no;
    }
}
