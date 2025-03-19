<div>
    <div class="content-header">ใบเสร็จรับเงิน</div>
    <div class="content-body">
        <button class="btn-info mr-2" wire:click="openModal">
            <i class="fa-solid fa-plus mr-2"></i>
            เพิ่มรายการ
        </button>
        <button class="btn-success" wire:click="openModal">
            <i class="fa-solid fa-print mr-2"></i>
            พิมพ์ใบแจ้งหนี้ทุกห้อง
        </button>
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
                    <th width="190px">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($billings as $billing )
                <tr>
                    <td class="text-left">{{$billing->room->name}}</td>
                    <td>{{ $billing->customer->name ?? '-' }}</td>
                    <td>{{ $billing->customer->phone ?? '-' }}</td>

                    <td>{{ date('d/m/Y',strtotime($billing->created_at)) }}</td>
                    <td class="text-right">{{ number_format($billing->sumAmount() )}}</td>
                    <td class="text-center">{{ $billing->getStatusName() }}</td>
                    <td>{{ $billing->remark }}</td>
                    <td class="text-center">
                        <button class="btn-edit" wire:click ="printBilling({{$billing->id}})">
                            <i class="fa-solid fa-print"></i>
                        </button>
                        <button class="btn-edit" wire:click ="openModalEdit({{$billing->id}})">
                            <i class="fa-solid fa-edit"></i>
                        </button>
                        <button class="btn-delete" wire:click ="openModalDelete({{$billing->id}},'{{$billing->room->name}}')">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <x-modal title="รายการใบเสร็จ" wire:model=showModal maxWidth="2xl">
        <div class="flex gap-2 justify-between">
            <div class="w-1/3">
            <div>ห้อง</div>
            <select wire:model = "roomId" class="form-control" wire:change="selectedRoom()">
                <option value="">กรุณาเลือกห้อง</option>
                @foreach ($rooms as $room )
                <option value="{{ $room ['id'] }}">{{ $room['name'] }}</option>

                @endforeach
            </select>
        </div>
        <div class="w-1/3">
        <div>วันที่</div>
        <input type="date" wire:model="createdAt" class="form-control">
        </div>
        <div class="w-1/3">
        <div>สถานะ</div>
        <select class="form-control" wire:model="status">
            @foreach ($listStatus as $status)
                <option value="{{ $status['status']}}">{{ $status['name']}}</option>
            @endforeach
        </select>
        </div>
        </div>
        <div class="flex gap-2 mt-3">
            <div class="w-1/2">
                <div>ผู้เข้าพัก</div>
                <input type="text" wire:model="customerName" class="form-control bg-gray-200" readonly>
            </div>
            <div class="w-1/2">
                <div>เบอร์โทร</div>
                <input type="text" wire:model="customerPhone" class="form-control bg-gray-200" readonly>
            </div>
        </div>
        <div class="mt-3">หมายเหตุ</div>
        <input type="text" wire:model="note" class="form-control">

        <table class="table mt-3">
            <thead>
                <tr>
                    <th class="text-left" width="300px">ค่าใช้จ่าย</th>
                    <th class="text-right">จำนวน</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>ค่าเช้าห้อง</td>
                    <td><input type="number" wire:model="amountRent" class="form-control text-right" wire:change="computeSumAmount()"></td>
                </tr>

                <tr>
                    <td>ค่าน้ำ</td>
                    <td><input type="number" wire:model="amountWater" class="form-control text-right" wire:change="computeSumAmount()"></td>
                </tr>

                <tr>
                    <td>ค่าไฟ</td>
                    <td><input type="number" wire:model="amountElectric" class="form-control text-right" wire:change="computeSumAmount()"></td>
                </tr>

                <tr>
                    <td>ค่าอินเตอร์เน็ต</td>
                    <td><input type="number" wire:model="amountInternet" class="form-control text-right" wire:change="computeSumAmount()"></td>
                </tr>

                <tr>
                    <td>ค่าบริการฟิตเนส</td>
                    <td><input type="number" wire:model="amountFitness" class="form-control text-right" wire:change="computeSumAmount()"></td>
                </tr>
                
                <tr>
                    <td>ค่าบริการซักรีด</td>
                    <td><input type="number" wire:model="amountWash" class="form-control text-right" wire:change="computeSumAmount()"></td>
                </tr>

                <tr>
                    <td>ค่าบริการเก็บขยะ</td>
                    <td><input type="number" wire:model="amountBin" class="form-control text-right" wire:change="computeSumAmount()"></td>
                </tr>

                <tr>
                    <td>ค่าบริการอื่นๆ</td>
                    <td><input type="number" wire:model="amountEtc" class="form-control text-right" wire:change="computeSumAmount()"></td>
                </tr>
                {{-- <tr>
                    <td>รวม</td>
                    <td><input type="number" wire:model="sumAmount" class="form-control text-right" readonly></td>
                </tr> --}}
            </tbody>
        </table>
        
        <div class="mt-3 text-center font-bold">รวมค่าใช้จ่าย : {{ number_format($sumAmount)}} บาท </div>

        <div class="text-center mt-3">  
            <button class="btn-success" wire:click="save">    
                <i class="fa-solid fa-save mr-2"></i>
                บันทึก
            </button>
            <button class="btn-danger" wire:click="closeModal">    
                <i class="fa-solid fa-times mr-2"></i>
                ยกเลิก
            </button>
        </div>
    </x-modal>

    <x-modal-confirm title="ยืนยันการลบ" text="คุณต้องการลบรายการห้อง {{ $roomForDelete }} หรือไม่ ?" showModalDelete="showModaldelete" clickConfirm="deleteBilling" clickCancel="closeModalDelete" />
</div>