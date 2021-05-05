<?php

namespace Lacunose\Customer\Models;

use Str, Validator;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model {
    
    public function getConnectionName(){
        if ( Str::is('tenant', config()->get('tswirl.db.tcust')) ) {
            return app(\Hyn\Tenancy\Database\Connection::class)->tenantName();
        }
        return parent::getConnectionName();
    }

    protected $table = 'cust_customers';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'code', 'pid', 'name', 'phone', 'email', 'address'
    ];
 
    public function getUxNameAttribute() {
        return $this->attributes['name'].' ('.$this->attributes['phone'].')';
    }

    public function getUxStatusAttribute() {
        return config()->get('tcust.glossary.customer.'.$this->attributes['status']);
    }
   
    public function getUxStatusColorAttribute() {
        return config()->get('tcust.color.customer.'.$this->attributes['status']);
    }

    public function user() {
        return $this->setConnection(config()->get('tswirl.db.tacl'))->belongsTo(User::class, 'email', 'email');
    }

    public function marks() {
        return $this->hasMany(CustomerMark::class);
    }

    public function programs() {
        return $this->belongsToMany(Program::class, 'cust_customer_program')->publish(now());
    }

    /*
     * A helper method to quickly retrieve an Customer by uuid.
     */
    public static function uuid(string $uuid): ?Customer
    {
        return static::where('uuid', $uuid)->first();
    }

    /*
     * Scopes to search
     */
    public function scopeSearch($q, $val) {
        return $q->where(function($q)use($val){
            $q->where('name', 'like', '%'.$val.'%')
            ->orwhere('code', 'like', '%'.$val.'%')
            ;
        });
    }

    /*
     * Scopes to search
     */
    public function scopeStatus($q, $val) {
        return $q->where('status', $val);
    }

    public function scopeFilter($q, Array $filters)
    {
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
            $q = $q->orderby($field, $val);
        }

        return $q;
    }

}
