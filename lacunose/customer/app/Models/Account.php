<?php

namespace Lacunose\Customer\Models;

use Str, Validator, Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public function getConnectionName(){
        if ( Str::is('tenant', config()->get('tswirl.db.tcust')) ) {
            return app(\Hyn\Tenancy\Database\Connection::class)->tenantName();
        }
        return parent::getConnectionName();
    }

    protected $table = 'cust_accounts';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'customer_id', 'currency', 'exchange_rate_to_idr', 'reset_period'
    ];

    protected $appends  = [
    ];

    protected $casts    = [];
    
    protected $dates    = [];

    /*
     * relationship has many chats
     */
    public function logs() {
        return $this->hasMany(AccountLog::class)->orderby('issued_at', 'desc');
    }

    /*
     * relationship belongs to customer
     */
    public function customer() {
        return $this->belongsTo(Customer::class)->select(['id', 'uuid', 'name', 'email', 'phone']);
    }
 
    public function getUxStatusAttribute() {
        return config()->get('tcust.glossary.account.'.$this->attributes['status']);
    }
   
    public function getUxStatusColorAttribute() {
        return config()->get('tcust.color.account.'.$this->attributes['status']);
    }

    public function getUxResetPeriodAttribute() {
        return config()->get('tcust.opsi.period.'.$this->attributes['reset_period']);
    }

    /*
     * A helper method to quickly retrieve an account by uuid.
     */
    public static function uuid(string $uuid): ?account {
        return static::where('uuid', $uuid)->first();
    }

    /*
     * Scopes to search
     */
    public function scopeSearch($q, $val) {
        return $q->where(function($q)use($val){
            $q->where('no', 'like', '%'.$val.'%')
            ;
        });
    }

    /*
     * Scopes to search
     */
    public function scopeStatus($q, $val) {
        return $q->where('status', $val);
    }

    public function scopeFilter($q, Array $filters) {
        /*----------  Validate  ----------*/
        $rules = [
            'search'    => ['nullable', 'string'],
            'status'    => ['nullable', 'string'],
        ];

        Validator::make($filters, [$rules])->validate();

        /*----------  Query  ----------*/
        foreach ($filters as $field => $val)
        {
            switch (strtolower($field))
            {
                case 'except_ids'   : $q = $q->whereNotIn('id', is_array($val) ? $val : [$val]); break;
                case 'search'       : $q = $q->search($val); break;
                case 'status'       : $q = $q->status($val); break;
            }
        }

        return $q;
    }

    public function scopeSort($q, Array $sorts) {
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

    public function scopeNo($q, $val) {
        return $q->where(function($q)use($val){
            $q->where('no', $val);
        });
    }

    public static function generateNo() {
        $prefix     = now()->format('ym');
        $idx        = self::where('no', 'like', $prefix.'%')->count() + 1;
        do{
            $no     = $prefix.'.C'.str_pad($idx, 3, '0', STR_PAD_LEFT);
            $exists = self::where('no', $no)->first();
            $idx++;
        }while ($exists);
        
        return $no;
    }
}
