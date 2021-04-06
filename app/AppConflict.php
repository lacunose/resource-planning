<?php

namespace App;

use Str, Validator, Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppConflict extends Model {
    use SoftDeletes;
    
    public function getConnectionName(){
        if ( Str::is('tenant', config()->get('twh.mode')) ) {
            return app(\Hyn\Tenancy\Database\Connection::class)->tenantName();
        }
        return parent::getConnectionName();
    }

    protected $table = 'app_conflicts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'topic', 'code', 'audiences', 'histories', 'stakes'
    ];

    protected $appends = [
    ];

    protected $casts = [
        'audiences' => 'array',
        'histories' => 'array',
        'stakes'    => 'array',
    ];
    
    protected $dates = [
    ];

    /*
     * Scopes to search
     */
    public function scopeSearch($q, $val){
        return $q->where(function($q)use($val){
            $q->where('code', 'like', '%'.$val.'%')
            ->orwhere('audiences', 'like', '%'.$val.'%')
            ;
        });
    }

    public function scopeFilter($q, Array $filters) {
        /*----------  Validate  ----------*/
        $rules = [
            'search'        => ['nullable', 'string'],
        ];

        Validator::make($filters, [$rules])->validate();

        /*----------  Query  ----------*/
        foreach ($filters as $field => $val)
        {
            switch (strtolower($field))
            {
                case 'except_ids'   : $q = $q->whereNotIn('id', is_array($val) ? $val : [$val]); break;
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
