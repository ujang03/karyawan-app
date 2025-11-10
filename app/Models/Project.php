<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;
    //
    protected $table = 'projects';
    protected $fillable = [
        'nama',
        'client_id',
        'description',
        'price',
        'start_date',
        'end_date',

    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'price' => 'decimal:2',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(client::class);
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
