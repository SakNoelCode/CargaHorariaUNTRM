<div>
    <x-jet-button wire:click="$set('isOpen',true)">
        Generar nueva declaración jurada
    </x-jet-button>

    <x-jet-dialog-modal wire:model='isOpen'>
        <x-slot name='title'>
            Generar declaracion jurada
        </x-slot>

        <x-slot name='content'>
            <!----Nombre Docente--->
            <div class="mb-4">
                <x-jet-label value='Docente: ' />
                <x-jet-input disabled type='text' class="w-full bg-gray-100" wire:model='nameDocente' />
            </div>

            <!--Periodo-->
            <div class="mb-4">
                <x-jet-label value='Periodo: ' />
                <select name="" id="" wire:model.defer='periodo_id' class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full">
                    <option value="" disabled selected>Seleccione</option>
                    @foreach ($periodos as $item)
                    <option value="{{$item->id}}">{{$item->descripcion}}</option>
                    @endforeach
                </select>
                <x-jet-input-error for='periodo_id' />
            </div>

        </x-slot>

        <x-slot name='footer'>
            <x-jet-action-message class="mr-4" wire:loading on='save'>Cargando....</x-jet-action-message>
            <x-jet-secondary-button class="mr-4" wire:click="cleanFields">Cancelar</x-jet-secondary-button>
            <x-jet-button wire:click='save' wire:loading.attr='disabled' wire:target='save'>Generar</x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>