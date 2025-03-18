<div class="sidebar">
    <div class="sidebar-header">
        <div class="text-center">พี่ดำ หอพัก</div>
    </div>
    <div class="sidebar-body">
        <div class="menu">
            <ul>
                <li wire:click="changeMenu('dashboard')" @if($currentMenu == 'dashboard') class="active" @endif>
                    <i class="fa solid fa-chart-line me-2"></i>
                    Dashboard
                </li>
                <li wire:click="changeMenu('room')" @if($currentMenu == 'room') class="active" @endif>
                    <i class="fa solid fa-home me-2"></i>
                    ห้องพัก
                </li>
                <li wire:click="changeMenu('customer')" @if($currentMenu == 'customer') class="active" @endif>
                    <i class="fa solid fa-users me-2"></i>
                    ผู้เข้าพัก
                </li>
                <li wire:click="changeMenu('pay')" @if($currentMenu == 'pay') class="active" @endif>
                    <i class="fa solid fa-money-bill me-2"></i>
                    บันทึกการชำระเงิน
                </li>
                <li wire:click="changeMenu('user')" @if($currentMenu == 'user') class="active" @endif>
                    <i class="fa solid fa-user-pen me-2"></i>
                    ผู้ใช้งาน
                </li>
                
                <li wire:click="changeMenu('company/index')" @if($currentMenu == 'company/index') class="active" @endif>
                    <i class="fa solid fa-building me-2"></i>
                    ข้อมูลสถานประกอบการ
                </li>
            </ul>
        </div>
    </div>
</div>