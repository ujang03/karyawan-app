<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;

    //
    protected $fillable = [
        'project_id',
        'title',
        'detail',
        'notes',
        'total',
        'issue_date',
        'due_date',
        'paid_date',

    ];

    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
        'paid_date' => 'date',
        'total' => 'decimal:2',
    ];

    public function project()
    {
        return $this->belongsTo(project::class);
    }
}
