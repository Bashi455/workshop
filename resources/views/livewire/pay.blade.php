<div>
    <div class="content-header">
        <div>
            <div>บันทึกค่าใช้จ่าย</div>
        </div>
    </div>
    <div class="content-body">
        <div class="flex">
            <button class="btn-info mr-2" wire:click="openModalPayLog">
                <i class="fa-solid fa-plus mr-2"></i>
                เพิ่มค่าใช้จ่าย
            </button>
            <button class="btn-info mr-2" wire:click="openModalPay">
                <i class="fa-solid fa-list mr-2"></i>
                รายการค่าใช้จ่าย
            </button>
        </div>

        <table class="table mt-3">
            <thead>
                <tr>
                    <th class="text-left" width="100px">วันที่</th>
                    <th class="text-left" width="300px">รายการ</th>
                    <th class="text-left">หมายเหตุ</th>
                    <th class="text-right" width="100px">ยอดเงิน</th>
                    <th width="130px"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payLogs as $payLog )
                <tr>
                    <td>{{ date('d/m/y',strtotime($payLog->pay_date)) }}</td>
                    <td>{{ $payLog->pay->name }}
                        @if ($payLog->status == 'delete')
                            <span class="text-red-500 ml-5">*** ถูกลบ ***</span>
                        @endif
                    </td>
                    <td>{{ $payLog->pay->remark }}</td>
                    <td class="text-right">{{ number_format($payLog->amount) }}</td>
                    <td>
                        <button class="btn-edit" wire:click="openModalPayLogEdit( {{ $payLog->id}})"><i class="fa-solid fa-pencil mr-2"></i></button>

                        @if ($payLog->status == 'use')
                            <button class="btn-delete" wire:click="openModalPayLogDelete( {{$payLog->id}})"><i class="fa-solid fa-trash mr-2"></i></button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div>
        <x-modal title="รายการค่าใช้จ่าย " wire:model="showModalPayLogEdit" maxwidth="2xl">
            <div>วันที่</div>
            <input type="date" class="form-control" wire:model="payLogEditDate">

            <div class="mt-3">รายการ</div>
            <input type="text" class="form-control bg-gray-100" wire:model="payLogEditName" readonly>
            
            <div class="mt-3">ยอดเงิน</div>
            <input type="text" class="form-control" wire:model="payLogEditAmount"> 
            
            <div class="mt-3">หมายเหตุ</div>
            <input type="text" class="form-control" wire:model="payLogEditRemark">

            <div class="flex justify-center mt-4">
                <button class="btn-info mr-2" wire:click="editPayLogSave()">
                    <i class="fa-solid fa-check mr-2"></i>บันทึก
                </button>

                <button class="btn-info mr-2" wire:click="closeModalPayLogEdit">
                    <i class="fa-solid fa-xmark mr-2"></i>ยกเลิก
                </button>
            </div>
        </x-modal>
        <x-modal-confirm title="ยืนยันการลบรายการ" text="คุณต้องการลบรายการ{{$payLogEditName}}ใช่หรือไม่"
        showModelDelete="showModalPayLogDelete" maxwidth="sm"
        click-confirm="deletePayLog()"
        click-cancel="closeModalPayLogDelete()"/>

        <x-modal-confirm title="ยืนยันการกู้คืน" text="คุณต้องการกู้คืน{{$payLogEditName}}ใช่หรือไม่"
        showModelDelete="showModalPayLogRestore" maxwidth="sm"
        click-confirm="RestorePayLog()"
        click-cancel="closeModalPayLogRestore()" />

        <x-modal title="รายการค่าใช้จ่าย" wire:model="showModalPay" maxwidth="2xl">
            <div>รายการ</div>
            <input type="text" class="form-control" wire:model="payName">

            <div class="mt-2">หมายเหตุ</div>
            <input type="text" class="form-control" wire:model="payRemark">

            <div class="flex justify-center mt-4">
                <button class="btn-info mr-2" wire:click="savePay()">
                    <i class="fa-solid fa-check mr-2"></i>
                    บันทึก
                </button>

                <button class="btn-danger mr-2" wire:click="closeModalPay">
                    <i class="fa-solid fa-times mr-2"></i>
                    ยกเลิก
                </button>
            </div>

            <table class="table mt-3">
                <thead>
                    <tr>
                        <th class="text-left">รายการ</th>
                        <th class="text-left">หมายเหตุ</th>
                        <th width="130px"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pays as $pay)
                        <tr>
                            <td>{{ $pay->name }}</td>
                            <td>{{ $pay->remark }}</td>
                            <td>
                                <button class="btn-edit" wire:click="editPay( {{$pay->id }})">
                                    <i class="fa-solid fa-pencil mr-2"></i>
                                </button>
                                <button class="btn-delete" wire:click="openModalPayDelete( {{$pay->id }} , {{$pay->name }})">
                                    <i class="fa-solid fa-trash mr-2"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </x-modal>
    </div>
</div>
