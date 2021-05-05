<?php

namespace Lacunose\Customer\Models;

use Str, Validator, Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class CustomerMark extends Model
{
    public function getConnectionName(){
        if ( Str::is('tenant', config()->get('tswirl.db.tcust')) ) {
            return app(\Hyn\Tenancy\Database\Connection::class)->tenantName();
        }
        return parent::getConnectionName();
    }

    protected $table = 'cust_customer_marks';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id', 'type', 'catalog_code', 'catalog_name'
    ];

    protected $appends = [];

    protected $casts = [];
    
    protected $dates = [];

    public $timestamps = false;

    public function getUxTypeAttribute() {
        return config()->get('tcust.opsi.mark')[$this->attributes['type']];
    }

    public function customer() {
        return $this->belongsTo(Customer::class);
    }
    /*
     * Scopes to search
     */
    public function scopeSearch($q, $val)
    {
        return $q->where(function($q)use($val){
            $q->where('catalog_code', 'like', '%'.$val.'%')
            ->orwhere('catalog_name', 'like', '%'.$val.'%');
        });
    }

    public function scopeFilter($q, Array $filters)
    {
        /*----------  Validate  ----------*/
        $rules = [
            'search'    => ['nullable', 'string'],
        ];

        Validator::make($filters, [$rules])->validate();

        /*----------  Query  ----------*/
        foreach ($filters as $field => $val)
        {
            switch (strtolower($field))
            {
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
            $q = $q->orderby($field, $val);
        }

        return $q;
    }

}
