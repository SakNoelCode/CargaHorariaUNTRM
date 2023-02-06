<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <x-table>
            <!-----Cabecera---->
            <div class="px-6 py-4 flex items-center">
                <span class="font-semibold text-base text-blueGray-700">Cargas Asignadas</span>
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
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Opciones
                        </th>
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
                        <td class="px-6 py-4 text-sm font-medium">
                            <a class="text-red-600 hover:text-red-900 cursor-pointer" wire:click="deleteId({{$item->id}})">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
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
</div>