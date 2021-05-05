<?php

namespace Lacunose\Customer\Models;

use Str, Validator, Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use SoftDeletes;
    public function getConnectionName(){
        if ( Str::is('tenant', config()->get('tswirl.db.tcust')) ) {
            return app(\Hyn\Tenancy\Database\Connection::class)->tenantName();
        }
        return parent::getConnectionName();
    }

    protected $table = 'cust_programs';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'title', 'trigger_event', 'trigger_param', 'trigger_value', 'trigger_loop', 'target_event', 'target_field', 'target_value', 'target_gain'
    ];

    protected $appends = [
        'ux_status',
    ];

    protected $casts = [];
    
    protected $dates = [
        'published_at', 'published_until'
    ];
    
    public function getStatusAttribute() {
        if((!is_null($this->attributes['published_at']) && $this->attributes['published_at'] <= now()) && (is_null($this->attributes['published_until']) || $this->attributes['published_until'] >= now()) ){
            return 'published';
        }
        return 'unpublished';
    }
    
    public function getUxStatusAttribute() {
        if((!is_null($this->attributes['published_at']) && $this->attributes['published_at'] <= now()) && (is_null($this->attributes['published_until']) || $this->attributes['published_until'] >= now()) ){
            return config()->get('tcust.glossary.program.published');
        }
        return config()->get('tcust.glossary.program.unpublished');
    }
    
    public function getUxStatusColorAttribute() {
        if((!is_null($this->attributes['published_at']) && $this->attributes['published_at'] <= now()) && (is_null($this->attributes['published_until']) || $this->attributes['published_until'] >= now()) ){
            return config()->get('tcust.color.program.published');
        }
        return config()->get('tcust.color.program.unpublished');
    }

    public function getUxTriggerEventAttribute() {
        return config()->get('tcust.opsi.trigger')[$this->attributes['trigger_event']];
    }

    public function getUxTriggerParamAttribute() {
        return config()->get('tcust.opsi.param')[$this->attributes['trigger_event']][$this->attributes['trigger_param']];
    }

    public function getUxTargetEventAttribute() {
        return config()->get('tcust.opsi.target')[$this->attributes['target_event']];
    }

    public function getUxTargetFieldAttribute() {
        return config()->get('tcust.opsi.field')[$this->attributes['target_event']][$this->attributes['target_field']];
    }
    /*
     * A helper method to quickly retrieve an program by uuid.
     */
    public static function uuid(string $uuid): ?program
    {
        return static::where('uuid', $uuid)->first();
    }

    /*
     * Scopes to search
     */
    public function scopeSearch($q, $val)
    {
        return $q->where(function($q)use($val){
            $q->where('title', 'like', '%'.$val.'%');
        });
    }

    /*
     * Scopes to search
     */
    public function scopePublish($q, $val)
    {
        return $q->where(function($q)use($val){
            $q->where('published_at', '<=', $val)
            ->where(function($q)use($val){
                $q->where('published_until', '>=', $val)
                ->orwherenull('published_until')
                ;
            })
            ;
        });
    }

    /*
     * Scopes to search
     */
    public function scopeUnPublish($q, $val)
    {
        return $q->where(function($q)use($val){
            $q->where('published_at', '>', $val)
            ->orwhere('published_until', '<', $val)
            ->orwherenull('published_at')
            ;
        });
    }

    /*
     * Scopes to search
     */
    public function scopeStatus($q, $val)
    {
        switch (strtolower($val)) {
            case 'unpublished':
                return $q->unpublish(now());
                break;
            
            default:
                return $q->publish(now());
                break;
        }
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
