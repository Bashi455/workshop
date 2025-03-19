<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\RoomModel;
use App\Models\CustomerModel;
use App\Models\BillingModel;

class Billing extends Component {
    public $showModal = false;
    public $showModalDelete = false;
    public $rooms = [];
    public $billings = [];
    public $id ;
    public $roomId;
    public $remark;
    public $createdAt;
    public $status;
    public $amountRent;
    public $amountWater;
    public $amountElectric;
    public $amountInternet;
    public $amountFitness;
    public $amountWash;
    public $amountBin;
    public $amountEtc;
    public $customerName;
    public $customerPhone;
    public $listStatus = [
        ['status' => 'wait', 'name' => 'รอชำระ'],
        ['status' => 'paid', 'name' => 'ชำระแล้ว'],
        ['status' => 'next', 'name' => 'ค้างชำระ']
    ];
    public $sumAmount = 0;
    public $roomForDelete;

    public function mount() {
        $this->fetchData();
        $this->createdAt = date('Y-m-d');
        $this->status = 'wait';
    }

   public function fetchData() {
        $customers = CustomerModel :: where('status', 'use')->get();
        $rooms = [];

        $this->billings = BillingModel::orderBy('created_at','desc')->get();

        foreach($customers as $customer) {
            $isBilling = false;

            foreach($this->billings as $billing) {
                if($customer->room_id == $billing->room_id) {
                    $isBilling = true;
                    break;
                }
            }

            if(!$isBilling) {
                $rooms[] = [
                    'id'=>$customer->room_id,
                    'name'=>$customer->room->name
                ];
            }
        }

        $this->rooms = $rooms;

        if(count($this->rooms) > 0) {
            $this->roomId = $this->rooms[0]['id'];
            $this->selectedRoom();
        }
        
   }

    public function render() {
        return view('livewire.billing');
    }

    public function openModal() {
        $this->showModal = true;
    }

    public function closeModal() {
        $this->showModal = false;
    }

    public function selectedRoom() {
        $room = RoomModel::find($this->roomId);
        $customer = CustomerModel::where('room_id', $room->id)->first();

        $this->customerName = optional($customer)->name ?? 'ไม่พบข้อมูล';
        $this->customerPhone = optional($customer)->phone ?? '-';

        $this->amountRent = $room->price_per_month;

        $this->computeSumAmount();
    }

    public function computeSumAmount() {
        $this->sumAmount = $this->amountRent + $this->amountWater + $this->amountElectric + $this->amountInternet + $this->amountFitness + $this->amountWash + $this->amountBin + $this->amountEtc;
    }

    public function save(){
        $billing = new BillingModel();

        if($this->id 
        != null) {
            $billing = BillingModel::find($this->id);
        }

        $billing->room_id = $this->roomId;
        $billing->created_at = $this->createdAt;
        $billing->status = $this->status;
        $billing->remark = $this->remark;
        $billing->amount_rent = $this->amountRent ?? 0;
        $billing->amount_water = $this->amountWater ?? 0;
        $billing->amount_electric = $this->amountElectric ?? 0;
        $billing->amount_internet = $this->amountInternet ?? 0;
        $billing->amount_fitness = $this->amountFitness ?? 0;
        $billing->amount_wash = $this->amountWash ?? 0;
        $billing->amount_bin = $this->amountBin ?? 0;
        $billing->amount_etc = $this->amountEtc ?? 0;
        $billing->save();

        $this->closeModal();
        $this->fetchData();

        $this->id = null;
    }

    public function openModalEdit($id) {
        $this->showModal = true;
        $this->billings = BillingModel::find($id);
    }
    
    public function closeModalEdit() {
        $this->showModal = false;
    }

    public function openModalDelete($id,$name) {
        $this->showModalDelete = true;
        $this->id = $id;
        $this->roomForDelete = $name;
    }

    public function closeModalDelete() {
        $this->showModalDelete = false;
    }

    public function deleteBilling(){
        $billing = BillingModel::find($this->id);
        $billing->delete();

        $this->closeModalDelete();
        $this->fetchData();
    }
}