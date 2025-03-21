<?php
namespace App\Livewire;

use App\Models\CustomerModel;
use App\Models\RoomModel;
use Livewire\Component;

class Customer extends Component {
    public $customers = [];
    public $rooms = [];
    public $showModal = false;
    public $showModalDelete = false;
    public $showModalMove = false;
    public $id;
    public $name;
    public $phone;
    public $address;
    public $remark;
    public $roomId;
    public $createdAt;
    public $stayType = 'd';
    public $roomIdMove;

    public function mount() {
        $this->fetchData();
        $this->createdAt = date('y-m-d');
    }

    public function fetchData() {
        $this->customers = CustomerModel::where('status','use')->orderBy('id','desc')->get();

        $this->rooms = RoomModel::where('status','use')->where('is_empty','yes')->orderBy('name','asc')->get();
    }

    public function openModal() {
        $this->showModal = true;
    }

    public function closeModal() {
        $this->showModal=false;
    }
    public function save(){
        $customer = new CustomerModel();

        if ($this->id) {
            $customer = CustomerModel::find($this->id);
        } else {
            $customer->room_id = $this->roomId;
        }

        // update room status
        $room = RoomModel::find($this->roomId);
        $room -> is_empty = 'no';
        $room->save();

        $price = $room->price_per_day;

        if ($this->stayType == 'm') {
            $price = $room->price_per_month;
        }

        $customer->name = $this->name;
        $customer->phone = $this->phone;
        $customer->address = $this->address;
        $customer->remark = $this->remark;
        $customer->created_at = $this->createdAt;
        $customer->status = 'use';
        $customer->stay_type = $this->stayType;
        $customer->price = $price;
        $customer->save();

        $this->showModal = false;
        $this->id = null;

        $this->fetchData();        
    }

    public function openModalEdit($id) {
        $this->showModal = true;
        $this->id = $id;

        $customer = CustomerModel::find($id);
            $this->name = $customer->name;
            $this->phone = $customer->phone;
            $this->address = $customer->address;
            $this->remark = $customer->remark;
            $this->roomId = $customer->room_id;
            $this->createdAt = date('Y-m-d',strtotime($customer->created_at));
            $this->stayType = $customer->stay_type;
    }

    public function openModalDelete($id){
        $this->showModalDelete = true;
        $this->id = $id;
    }

    public function delete() {
        $customer = CustomerModel::find($this->id);
        $customer->status = 'delete';
        $customer->save();

        $room = RoomModel::find($customer->room_id);
        $room->is_empty = 'yes';
        $room->save();

        $this->showModalDelete = false;
        $this->fetchData();
    }

    public function closeModalDelete() {
        $this->showModalDelete = false;
    }

    // move room

    public function openModalMove($id) {
        $this->showModalMove = true;
        $this->id = $id;
    }

    public function move() {

        // old room
        $customer = CustomerModel::find($this->id);
        $room = RoomModel::find($customer->room_id);
        $room->is_empty = 'yes';
        $room->save();


        // update room id
        $customer->room_id = $this->roomIdMove;
        $customer->save();

        // new room
        $room = RoomModel::find($this->roomIdMove);
        $room->is_empty = 'no';
        $room->save();

        

        $this->showModalMove = false;
        $this->fetchData();
    }
    public function closeModalMove() {
        $this->showModalMove = false;
    }

    public function render() {
        return view('livewire.customer');
    }
}