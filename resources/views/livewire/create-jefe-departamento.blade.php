<div>
    <x-jet-button wire:click="$set('isOpen',true)">
        Crear nuevo jefe de departamento
    </x-jet-button>

    <x-jet-dialog-modal wire:model='isOpen'>

        <x-slot name='title'>
            Crear nuevo jefe de departamento
        </x-slot>

        <x-slot name='content'>
            <div class="flex">
                <!----Nombre--->
                <div class="mb-4 flex-1 mr-4">
                    <x-jet-label value='Nombre completo' />
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
                    <option value="" selected disabled>Seleccione</option>
                    @foreach ($escuelas as $escuela)
                    <option value="{{$escuela->id}}">{{$escuela->descripcion}}</option>
                    @endforeach
                </select>
                <x-jet-input-error for='escuela_id' />
            </div>

            <div class="flex">
                <!----Contraseña--->
                <div class="mb-4 flex-1 mr-4">
                    <x-jet-label value='Contraseña' />
                    <x-jet-input type='password' class="w-full" wire:model.defer='password' />
                    <x-jet-input-error for='password' />
                </div>

                <!----Confirm Contraseña--->
                <div class="mb-4 flex-1 ml-4">
                    <x-jet-label value='Confirmar contraseña' />
                    <x-jet-input type='password' class="w-full" wire:model.defer='password_confirmation' />
                    <x-jet-input-error for='password_confirmation' />
                </div>
            </div>

        </x-slot>

        <x-slot name='footer'>
            <x-jet-action-message class="mr-4" wire:loading on='save'>Cargando....</x-jet-action-message>
            <x-jet-secondary-button class="mr-4" wire:click="cleanFields" wire:loading.attr='disabled' wire:target='save,cleanFields'>Cancelar</x-jet-secondary-button>
            <x-jet-button wire:click='save' wire:loading.attr='disabled' wire:target='save,cleanFields'>Guardar</x-jet-button>
        </x-slot>

    </x-jet-dialog-modal>
</div>