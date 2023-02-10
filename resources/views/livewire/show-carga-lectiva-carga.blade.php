<div>

    @push('css')
    <style>
        textarea {
            resize: none;
        }
    </style>
    @endpush

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
        <x-table>
            <!-----Cabecera---->
            <div class="px-6 py-4 flex items-center">
                <span class="font-bold text-base text-gray-900">Cargas Asignadas</span>
                @json($totalHoras)
                @json($isCompletoCargas)
            </div>

            @if ($cargasAsignadas->count())
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            #
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Titulo de carga
                        </th>
                        @if ($estadoCargaLectiva == 0)
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Opciones
                        </th>
                        @endif
                        @if ($isDocente)
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Descripcion
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Horas
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                        @endif
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($cargasAsignadas as $item)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium">
                            {{$enumerator}}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            {{$item->tituloCarga}}
                        </td>
                        @if ($estadoCargaLectiva == 0)
                        <td class="px-6 py-4 text-sm font-medium">
                            <a class="text-red-600 hover:text-red-900 cursor-pointer" wire:click="deleteId({{$item->id}})">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                        @endif
                        @if ($isDocente)
                        <td class="px-6 py-4 text-sm font-medium">
                            {{$item->descripcion}}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            {{$item->cantHoras}}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            <a class="text-indigo-600 hover:text-indigo-900 cursor-pointer" wire:click="edit({{$item->id}})">{{$item->cantHoras==0 ? 'Completar' : 'Editar'}}</a>
                        </td>
                        @endif
                    </tr>
                    <?php
                    $enumerator++;
                    ?>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="px-6 py-4">
                <span>No existen cargas asignadas en este momento</span>
            </div>
            @endif
        </x-table>
    </div>

    <x-jet-confirmation-modal wire:model='isOpenModalDelete'>
        <x-slot name='title'>
            Eliminar carga
        </x-slot>
        <x-slot name='content'>
            ¿Esta seguro que quiere eliminar la carga?
        </x-slot>
        <x-slot name='footer'>
            <x-jet-secondary-button class="mr-4" wire:click="close" wire:loading.attr='disabled' wire:target='delete,close'>Cancelar</x-jet-secondary-button>
            <x-jet-button wire:click='delete' wire:loading.attr='disabled' wire:target='delete,close'>Guardar</x-jet-button>
        </x-slot>
    </x-jet-confirmation-modal>

    <!------Modal editar----->
    <x-jet-dialog-modal wire:model='isOpenModalEdit'>
        <x-slot name='title'>
            Completar datos
        </x-slot>
        <x-slot name='content'>

            <div class="mb-4">
                <x-jet-label value='Descripción' />
                <textarea wire:model.defer='descripcion' rows="3" placeholder="Escriba una descripción para la carga" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full"></textarea>
                <x-jet-input-error for='descripcion' />
            </div>

            <div class="mb-4">
                <x-jet-label value='Cantidad de Horas:' />
                <x-jet-input type='number' min='1' class="w-full" wire:model.defer='cantHoras' />
                <x-jet-input-error for='cantHoras' />
            </div>

        </x-slot>
        <x-slot name='footer'>
            <x-jet-action-message class="mr-4" wire:loading on='update'>Cargando.....</x-jet-action-message>
            <x-jet-secondary-button class="mr-4" wire:click='closeFormEdit' wire:loading.attr='disabled' wire:target='update,closeFormEdit'>Cerrar</x-jet-secondary-button>
            <x-jet-button wire:click='update' wire:loading.attr='disabled' wire:target='update,closeFormEdit'>Guardar</x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

    @push('js')
    <script>
        /*
        document.addEventListener('livewire:load', function(event) {

            if (@this.isDocente) {
                Livewire.emit('passingParametrosCarga', @this.totalHoras, @this.isCompletoCargas);
            }
        });*/
    </script>
    @endpush
</div>