<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineAuditLog extends Model
{
    use HasFactory;

    protected $table = 'machine_audit_log';

    protected $fillable = [
        'previous_state',
        'new_state',
        'machine_id',
    ];

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }
}