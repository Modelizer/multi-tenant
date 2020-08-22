<?php

namespace Modelizer\MultiTenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hostname extends Model
{
    use SoftDeletes;

    /** @var string $connection */
    protected $connection = 'default';

    /** @var string[] $dates */
    protected $dates = ['under_maintenance_since'];

    /** @var string[] $fillable */
    protected $fillable = [
        'fqdn',
        'partner_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }
}
