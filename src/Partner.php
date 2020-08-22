<?php

namespace Modelizer\MultiTenant;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    /** @var string $connection */
    protected $connection = 'default';

    /** @var string[] $fillable */
    protected $fillable = [
        'uuid',
        'name'
    ];

    /** @var string[] $casts */
    protected $casts = [
        'config' => 'array',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hostnames()
    {
        return $this->hasMany(Hostname::class);
    }
}
