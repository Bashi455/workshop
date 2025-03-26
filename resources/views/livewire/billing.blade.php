<div>
    <div class="content-header">ใบเสร็จรับเงิน</div>
    <div class="content-body">
        <button class="btn-info mr-1 cursor-pointer" wire:click="openModal">
            <i class="fa-solid fa-plus mr-2"></i>
            เพิ่มรายการ
        </button>
        <a href="{{ url('print-all-billings') }}" target="_blank" class=" btn-success cursor-pointer">
            <i class="fa-solid fa-print mr-2"></i> พิมพ์บิลทั้งหมด
        </a>
        
        
        
        <table class="table mt-3">
            <thead>
                <tr>
                    <th class="text-left">ห้อง</th>
                    <th class="text-left">ผู้เข้าพัก</th>
                    <th class="text-left">เบอร์โทร</th>
                    <th class="text-left">วันที่</th>
                    <th class="text-right">ยอดเงิน</th>
                    <th class="text-center">สถานะ</th>
                    <th class="text-left">หมายเหตุ</th>
                    <th width="240px">จัดการ</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($billings as $billing)
                    <tr>
                        <td class="text-left">{{ $billing->room->name }}</td>
                        <td>{{ $billing->getCustomer()->name }}</td>
                        <td>{{ $billing->getCustomer()->phone }}</td>
                        <td class="text-left">{{ date('d/m/Y', strtotime($billing->created_at)) }}</td>
                        <td class="text-right">{{ number_format($billing->sumAmount()+$billing->money_added) }}</td>
                        <td class="text-center">
                            @if ($billing->status == 'paid')
                                <span class="text-green-500">
                                    <i class="fa-solid fa-check mr-1"></i>
                                    {{ $billing->getStatusName()}}
                                </span>
                            @else @if ($billing->status == 'wait')
                            <span class="text-yellow-500">
                                <i class="fa-solid fa-exclamation mr-1"></i>
                                {{ $billing->getStatusName()}}
                            </span>
                            @else
                            <span class="text-red-500">
                                <i class="fa-solid fa-times mr-1"></i>
                                {{ $billing->getStatusName()}}
                            @endif
                            @endif
                        </td>
                        <td>{{ $billing->remark }}</td>
                        <td class="text-center">
                            <button class="btn-print" wire:click="printBilling( {{ $billing->id }})">
                                <i class="fa-solid fa-print mr-2"></i>
                            </button>
                            <button class="btn-dollar" wire:click="openModalGetMoney( {{ $billing->id }})">
                                <i class="fa-solid fa-dollar-sign mr-2"></i>
                            </button>
                            <button class="btn-edit" wire:click="openModalEdit( {{ $billing->id }})">
                                <i class="fa-solid fa-pencil mr-2"></i>
                            </button>
                            <button class="btn-delete"
                                wire:click="openModalDelete( {{ $billing->id }}, '{{ $billing->room->name }}')">
                                <i class="fa-solid fa-trash mr-2"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <x-modal title="รายการบิล" wire:model="showModal" maxWidth="xl">
        <div class="flex gap-2 jsutify-between">
            <div class="w-1/3">
                <div>ห้อง</div>
                @if ($id != null)
                    <input type="text" class="form-control bg-gray-200 read-only" value="{{ $roomNameForEdit }}">
                @else
                    <select wire:model="roomId" class="form-control" wire:change="selectedRoom()">
                        <option value="">กรุณาเลือกห้อง</option>
                        @foreach ($rooms as $room)
                            <option value="{{ $room['id'] }}">{{ $room['name'] }}</option>
                        @endforeach
                    </select>
                @endif

            </div>
            <div class="w-1/3">
                <div>วันที่</div>
                <input type="date" class="form-control" wire:model="createdAt">
            </div>
            <div class="w-1/3">
                <div>สถานะบิล</div>
                <select wire:model="status" class="form-control">
                    @foreach ($listStatus as $status)
                        <option value="{{ $status['status'] }}">{{ $status['name'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex gap-2 mt-3">
            <div class="w-1/2">
                <div>ผู้เข้าพัก</div>
                <input type="text" class="form-control bg-gray-200 read-only" wire:model="customerName">
            </div>
            <div class="w-1/2">
                <div>เบอร์โทร</div>
                <input type="text" class="form-control bg-gray-200 read-only" wire:model="customerPhone">
            </div>
        </div>

        <div>หมายเหตุ</div>
        <input type="text" class="form-control" wire:model="remark">
        <table class="table mt-3">
            <thead>
                <tr>
                    <th class="text-left">ค่าใช้จ่าย</th>
                    <th class="text-right">จำนวน</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>ค่าเช่าห้อง</td>
                    <td><input type="number" class="form-control text-right" wire:model="amountRent"
                            wire:change="computeSumAmount()"></td>
                </tr>
                <tr>
                    <td>
                        <div class="flex gap-2">
                            <div class="w-1/3">ค่าน้ำ</div>
                            <div class="w-1/3">
                                <input type="number" class="form-control text-right" wire:model="waterUnit"
                                    wire:change="computeSumAmount()">
                            </div>
                            <div class="w-1/3">หน่วย</div>
                        </div>
                    </td>
                    <td>
                        <input type="number" class="form-control text-right" wire:model="amountWater"
                            wire:change="computeSumAmount()">
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="flex gap-2">
                            <div class="w-1/3">ค่าไฟ</div>
                            <div class="w-1/3">
                                <input type="number" class="form-control text-right" wire:model="electricUnit"
                                    wire:change="computeSumAmount()">
                            </div>
                            <div class="w-1/3">หน่วย</div>
                        </div>
                    </td>
                    <td>
                        <input type="number" class="form-control text-right" wire:model="amountElectric"
                            wire:change="computeSumAmount()">
                    </td>
                </tr>
                <tr>
                    <td>ค่าอินเตอร์เน็ต</td>
                    <td><input type="number" class="form-control text-right" wire:model="amountInternet"
                            wire:change="computeSumAmount()"></td>
                </tr>
                <tr>
                    <td>ค่าFitness</td>
                    <td><input type="number" class="form-control text-right" wire:model="amountFitness"
                            wire:change="computeSumAmount()"></td>
                </tr>
                <tr>
                    <td>ค่าที่ซักรีด</td>
                    <td><input type="number" class="form-control text-right" wire:model="amountWash"
                            wire:change="computeSumAmount()"></td>
                </tr>
                <tr>
                    <td>ค่าที่เก็บขยะ</td>
                    <td><input type="number" class="form-control text-right" wire:model="amountBin"
                            wire:change="computeSumAmount()"></td>
                </tr>
                <tr>
                    <td>ค่าบริการอื่นๆ</td>
                    <td><input type="number" class="form-control text-right" wire:model="amountEtc"
                            wire:change="computeSumAmount()"></td>
                </tr>
            </tbody>
        </table>
        <div class="mt-3 text-center font-bold">รวมค่าใช้จ่าย : {{ number_format($sumAmount) }} บาท</div>

        <div class="text-center mt-3">
            <button class="btn-primary" wire:click="save">
                <i class="fa-solid fa-check me-2"></i>
                บันทึก
            </button>
            <button class="btn-danger
            " wire:click="closeModal">
                <i class="fa-solid fa-times me-2"></i>
                ยกเลิก
            </button>
        </div>
    </x-modal>
    <x-modal-confirm title="ยืนยันการลบ" text="คุณต้องการลบรายการห้อง {{ $roomForDelete }} หรือไม่ ?"
        showModalDelete="showModalDelete" clickCancel="closeModalDelete" clickConfirm="deleteBilling" />

    <x-modal title="รับเงิน" wire:model="showModalGetMoney">
        <div class="flex gap-2 justify-between">
            <div class="w-2/1">
            <span class="font-bold">ห้อง</span>
            <span class="text-blue-500 ps-3 font-bold text-xl">{{ $roomNameForGetMoney }}</span>
        </div>
        <div class="w-2/1">
            <a href="print-invoice/{{$id}}" target="_blank" class="ms-3 bg-green-500 text-white p-2 rounded-md shadow-md cursor-pointer hover:bg-green-600">
                <i class="fa fa-print mr-2"></i>  
                พิมพ์ใบเสร็จรับเงิน 
            </a>
        </div>
        </div>
        <div class="mt-3">ผู้เข้าพัก : {{ $customerNameForGetMoney }}</div>
        <div class="mt-3">วันที่ชำระ</div>
        <input type="date" class="form-control" wire:model="payedDateForGetMoney">

        <div class="mt-3">ยอดรวมค่าใช้จ่าย :
            <span class="font-bold">{{ number_format($sumAmountForGetMoney) }} บาท</span>
        </div>

        <div class="flex gap-2 mt-3">

            <div class="w-1/2">
                <div>ค่าปรับ</div>
                <input type="number" class="form-control" wire:blur="handleChangeAmountGetForMoney" wire:model="moneyAdded">
            </div>
            <div class="w-1/2">
                <div>ยอดรับเงิน</div>
                <input type="number" class="form-control" wire:model="amountForGetMoney">
            </div>
            
        </div>
        <div class="mt-3">หมายเหตุ</div>
        <input type="text" class="form-control" wire:model="remarkForGetMoney">

        <div class="text-center mt-3">
            <button class="btn-primary" wire:click="saveGetMoney()">
                <i class="fa-solid fa-check mr-2"></i>
                บันทึก
            </button>
            <button class="btn-danger
            " wire:click="closeModalGetMoney()">
                <i class="fa-solid fa-times mr-2"></i>
                ยกเลิก
            </button>
        </div>
    </x-modal>
</div>
