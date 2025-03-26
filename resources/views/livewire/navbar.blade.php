<div class="navbar">
    <div class="flex items-center justify-between">
        <div>
            <i class="fa fa-solid fa-user me-2"></i>
            <span class="username ">{{ $user_name }}</span>
        </div>

       <div>
        <button wire:click="editProfile" class="border border-red-400 text-red-400 px-6 py-3 rounded-2xl hover:text-white mr-2">
            <i class="fa-solid fa-user mr-2"></i>
            แก้ไขข้อมูลส่วนตัว

        </button>
        <button wire:click="showModal = true" class="border border-purple-400 text-purple-400 px-6 py-3 rounded-2xl  hover:text-white mr-2">
            <span>ออกจากระบบ</span>
            <i class="fa fa-solid fa-sign-out ms-3"></i>
        </button>
        </div>
    </div>

    <x-modal wire:model="showModal" maxWidth="lg" title="ออกจากระบบ">
        <div class="text-center">
            <div><i class="fa-solid fa-question text-red-500 text-xl"></i></div>
            <div class="text-3xl font-bold text-gray-800 mt-3">ออกจากระบบ</div>
            <div class="mt-3 text-2xl text-gray-800">คุณต้องการออกจากระบบใช่หรือไม่?</div>
        </div>
        <div class="flex justify-center mt-6 pb-4">
            <button wire:click="logout" class="btn-danger mr-3">
                <i class="fa fa-solid fa-check me-2"></i>
                ยืนยัน
            </button>
            <button  class="btn-secondary" wire:click="showModal = false">
                <i class="fa fa-solid fa-times me-2"></i>
                ยกเลิก
            </button>
        </div>
    </x-modal>

    <x-modal wire:model="showModalEdit" maxWidth="lg" title="แก้ไขข้อมูลส่วนตัว">
        @if ($errors->any())
            <div class="alert-danger">
                @foreach ( $errors->all() as $error )
                   <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div>username</div>
        <input type="text" class="form-control" wire:model="username">

        <div class="mt-3"> Password ใหม่</div>
        <input type="password" class="form-control" wire:model="password">

        <div class="mt-5">ยืนยัน Password </div>
        <input type="password" class="form-control" wire:model="password_confirm">

        <div class="mt-5 text-center pd-5">
            <button class="btn-success mr-2" wire:click="updateProfile">
                <i class="fa-solid fa-check mr-2"></i>
                บันทึก
            </button>
            <button class="btn-secondary mr-2" wire:click="showModalEdit = false">
                <i class="fa-solid fa-xmark mr-1"></i>
                ยกเลิก
            </button>
        </div>
        @if ($saveSuccess)
             <div class="alert-success alert">
                <i class="fa-solid fa-check mr-2"></i>
                บันทึกสำเร็จ
             </div>
        @endif


    </x-modal>
</div>
