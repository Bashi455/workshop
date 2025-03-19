<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillingModel extends Model
{
    protected $table = 'billings';

    protected $fillable = [
        'room_id', 'remark', 'status', 'amount_rent', 
        'created_at', 'amount_water', 'amount_electric', 'amount_internet',
        'amount_fitness', 'amount_wash', 'amount_bin', 'amount_etc',
        'money_added', 'payed_date'
    ];

    public $timestamps = false;

    public function room() {
        return $this->belongsTo(RoomModel::class, 'room_id', 'id');
    }

    public function customer() {
        return $this->hasOne(CustomerModel::class, 'room_id', 'room_id');
    }

    public function sumAmount() {
        return ($this->amount_rent ?? 0) + ($this->amount_water ?? 0) 
             + ($this->amount_electric ?? 0) + ($this->amount_internet ?? 0)
             + ($this->amount_fitness ?? 0) + ($this->amount_wash ?? 0) 
             + ($this->amount_bin ?? 0) + ($this->amount_etc ?? 0)
             + ($this->money_added ?? 0);
    }

    public function getStatusName() {
        return match ($this->status) {
            'wait' => 'รอชำระเงิน',
            'paid' => 'ชำระเงินแล้ว',
            'next' => 'ขอค้างจ่าย',
            default => 'ไม่ทราบสถานะ'
        };
    }
}
