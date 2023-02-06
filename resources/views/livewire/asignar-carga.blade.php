<div>
    @push('css')
    <style>
        .large {
            height: 272px;
        }
    </style>
    @endpush

    <!--------Boton ------->
    <x-jet-button wire:click="$set('isOpen',true)">
        Asignar Carga
    </x-jet-button>

    <x-jet-dialog-modal wire:model='isOpen'>
        <x-slot name='title'>
            Asignar carga
        </x-slot>

        <x-slot name='content'>
            <!--Carga--->
            <div class="mb-4">
                <x-jet-label value='Seleccione las cargas:' />
                @if ($cargas->count())
                <select wire:model.defer='cargasSelected' multiple class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full large">
                    @foreach ($cargas as $item)
                    <option value="{{$item->id}}">{{$enumerator}}. {{$item->titulo}}</option>
                    <?php
                    $enumerator++;
                    ?>
                    @endforeach
                </select>
                @else
                <select multiple class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full large">
                    <option value="" disabled>Todas las cargas han sido asignadas</option>
                </select>
                @endif

                <x-jet-input-error for='cargasSelected' />
            </div>
            <x-jet-label value='Ayuda: Para seleccionar más de una carga, debe mantener pulsada la tecla Ctrl' />
        </x-slot>

        <x-slot name='footer'>
            <x-jet-action-message class="mr-4" wire:loading on='save'>Cargando.....</x-jet-action-message>
            <x-jet-secondary-button class="mr-4" wire:click="close" wire:loading.attr='disabled' wire:target='save,close'>Cerrar</x-jet-secondary-button>
            @if ($cargas->count())
            <x-jet-button wire:click='save' wire:loading.attr='disabled' wire:target='save,close'>Guardar</x-jet-button>
            @endif
        </x-slot>
    </x-jet-dialog-modal>

    @push('js')
    @endpush
</div>