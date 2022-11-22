<div>
    <a class="text-indigo-600 hover:text-indigo-900 cursor-pointer" wire:click="$set('isOpen',true)">Editar</a>

    <x-jet-dialog-modal wire:model='isOpen'>

        <x-slot name='title'>
            Editar Jefe de departamento
        </x-slot>

        <x-slot name='content'>
            <div class="flex">
                <!----Nombre--->
                <div class="mb-4 flex-1 mr-4">
                    <x-jet-label value='Nombres' />
                    <x-jet-input type='text' class="w-full" wire:model.defer='name' />
                    <x-jet-input-error for='name' />
                </div>

                <!----DNI--->
                <div class="mb-4 flex-1 ml-4">
                    <x-jet-label value='DNI' />
                    <x-jet-input type='text' class="w-full" wire:model.defer='dni' />
                    <x-jet-input-error for='dni' />
                </div>
            </div>

            <!----Email--->
            <div class="mb-4">
                <x-jet-label value='Correo electrónico (Institucional)' />
                <x-jet-input type='email' class="w-full" wire:model.defer='email' />
                <x-jet-input-error for='email' />
            </div>

            <!------Escuelas----->
            <div class="mb-4">
                <x-jet-label value='Escuela' />
                <select name="" id="" wire:model.defer='escuela_id' class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full">
                    @foreach ($escuelas as $escuela)
                    @if ($escuela->id == "{{$escuela_id}}")
                    <option value="{{$escuela->id}}" selected>{{$escuela->descripcion}}</option>
                    @else
                    <option value="{{$escuela->id}}">{{$escuela->descripcion}}</option>
                    @endif
                    @endforeach
                </select>
                <x-jet-input-error for='escuela_id' />
            </div>

            <!-------Status------>
            <div class="">
                <div class="flex justify-start mx-10">
                    <div class="form-check form-switch">
                        <input wire:model.defer='status' class="form-check-input appearance-none w-9 -ml-10 rounded-full float-left h-5 align-top bg-white bg-no-repeat bg-contain focus:outline-none cursor-pointer shadow-sm" type="checkbox" role="switch" id="cboEstado">
                        <label class="form-check-label inline-block text-gray-800" for="cboEstado">Estado</label>
                    </div>
                </div>
            </div>

        </x-slot>

        <x-slot name='footer'>
            <x-jet-action-message class="mr-4" wire:loading on='save'>Cargando....</x-jet-action-message>
            <x-jet-secondary-button class="mr-4" wire:click="$set('isOpen',false)">Cancelar</x-jet-secondary-button>
            <x-jet-button wire:click='save' wire:loading.attr='disabled' wire:target='save'>Actualizar </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

</div>