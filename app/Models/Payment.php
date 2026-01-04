<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'amount', 'currency', 'payment_method', 'transaction_id', 'expiry_date', 'period', 'operating_system_id', 'vm_location', 'vpn_location', 'virtual_machiene_id', 'order_no'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function virtualMachine()
    {
        return $this->belongsTo(VirtualMachiene::class, 'virtual_machiene_id','id');
    }
    public function operatingSystem()
    {
        return $this->belongsTo(OperatingSystem::class);
    }
    public function jsonSerialize()
    {
        return $this->only(
            [
                'user_id',
                'amount',
                'currency',
                'payment_method',
                'transaction_id',
                'expiry_date',
                'vm_location',
                'vpn_location',
                'virtual_machiene_id',
                'user',
                'virtualMachine',
                'operating_system_id',
                'period',
                'order_no',
                'operatingSystem'
            ]
        );
    }
}
