<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class User extends Component {
    public $showModal = false;
    public $showModalDelete = false;
    public $id;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $level = 'user';
    public $listLevel = ['user', 'admin'];
    public $listUser = [];
    public $error = null;
    public $errorList = [];
    public $nameForDelete = null;

    public function mount() {
        $this->fetchData();
    }

    public function fetchData() {
        $this->listUser = UserModel::all();
    }

    public function openModal() {
        $this->showModal = true;
        $this->name = null;
        $this->email = null;
        $this->password = null;
        $this->password_confirmation = null;
        $this->level = 'user';
    }

    public function closeModal() {
        $this->showModal = false;
    }   

    public function save() {
        // ตรวจสอบว่ารหัสผ่านตรงกันหรือไม่
        if ($this->password !== $this->password_confirmation) {
            $this->error = 'รหัสผ่านไม่ตรงกัน';
            return;
        }
    
        // ถ้ามี ID = แก้ไข, ถ้าไม่มี ID = สร้างใหม่
        if ($this->id) {
            $user = UserModel::find($this->id);
    
            // ถ้าหาไม่เจอให้หยุดการทำงาน
            if (!$user) {
                $this->error = "ไม่พบผู้ใช้ที่ต้องการแก้ไข";
                return;
            }
    
            // อัปเดตข้อมูล
            $user->name = $this->name;
            $user->email = $this->email;
            if ($this->password) {
                $user->password = Hash::make($this->password);
            }
            $user->level = $this->level;
        } else {
            // สร้างผู้ใช้ใหม่
            $user = new UserModel();
            $user->name = $this->name;
            $user->email = $this->email;
            $user->password = Hash::make($this->password);
            $user->level = $this->level;
        }
    
        // บันทึกข้อมูล
        $user->save();
    
        // โหลดข้อมูลใหม่
        $this->fetchData();
        $this->closeModal();
    }
    

    public function openModalEdit($id) {
        $this->id = $id;
        $this->showModal = true;
    
        $user = UserModel::find($id);
        if (!$user) {
            $this->error = "ไม่พบผู้ใช้ที่ต้องการแก้ไข";
            return;
        }
    
        $this->name = $user->name;
        $this->email = $user->email;
        $this->level = $user->level;
    }
    

    public function closeModalEdit() {
        $this->showModal = false;
    }

    public function openModalDelete($id, $name) {
        $this->id = $id;
        $this->nameForDelete = $name;
        $this->showModalDelete = true;
    }

    public function closeModalDelete() {
        $this->showModalDelete = false;
    }

    public function delete() {
        UserModel::find($this->id)->delete();
        $this->fetchData();
        $this->closeModalDelete();
    }

    public function render() {
        return view('livewire.user');
    }
}