<div>
    <div class="content-header">
        <h3>ข้อมูลสถานประกอการ</h3>
    </div>
    <form wire:submit="save">
        <div class="flex gap-3">
            <div class="w-1/3">
                <div>
                    <label for="name">ชื่อสถานประกอบการ</label>
                    <input type="text" class="form-control" wire:model="name">
                </div>
            </div>
            <div class="w-1/3">
                <div>
                    <label for="address">ที่อยู่</label>
                    <input type="text" class="form-control" wire:model="address">
                </div>
            </div>
            <div class="w-1/3">
                <div>
                    <label for="tel">เบอร์โทร</label>
                    <input type="text" class="form-control" wire:model="phone">
                </div>
            </div>
        </div>

        <div class="mt-3">
            <label for="tax_code">เลขประจำตัวผู้เสียภาษี</label>
            <input type="text" class="form-control" wire:model="tax_code">
        </div>

        <div class="mt-3">
            @if ($logoUrl)
                <img src="{{ $logoUrl }}" alt="logo" class="w-16 h-16 mb-3 rounded-md shadow-lg">
            @endif

            <label for="logo">โลโก้</label>
            <input type="file" class="form-control bg-white" wire:model="logo">
        </div>
        <div class="flex gap-3 mt-3">
            <div class="w-1/5">
                <div>
                    <div class="text-left" for="amount_water">ค่าน้ำ/เดือน</div>
                    <input type="number" class="form-control" wire:model="amount_water">
                </div>
            </div>
            <div class="w-1/5">
                <div>
                    <div class="text-left" for="amount_water_per_unit">ค่าน้ำ/หน่วย</div>
                    <input type="number" class="form-control" wire:model="amount_water_per_unit">
                </div>
            </div>
            <div class="w-1/5">
                <div>
                    <div class="text-left" for="amount_electric_per_unit">ค่าไฟ/หน่วย</div>
                    <input type="number" class="form-control" wire:model="amount_electric_per_unit">
                </div>
            </div>
            <div class="w-1/5">
                <div>
                    <div class="text-left" for="amount_internet">ค่าอินเทอร์เน็ต</div>
                    <input type="number" class="form-control" wire:model="amount_internet">
                </div>
            </div>
            <div class="w-1/5">
                <div>
                    <div class="text-left" for="amount_etc">ค่าอื่นๆ</div>
                    <input type="number" class="form-control" wire:model="amount_etc">
                </div>
            </div>
        </div>
        <button type="submit" class="btn-primary mt-3">
            <i class="fa fa-check mr-2"></i>
            บันทึกข้อมูล
        </button>

        @if ($flashMessage)
            <div class="alert alert-success mt-3">
                <i class="fa fa-check mr-2"></i>
                {{ $flashMessage }}
            </div>
        @endif
    </form>
</div>
