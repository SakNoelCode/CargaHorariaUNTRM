<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <x-table>
            <!-----Cabecera---->
            <div class="px-6 py-4 flex items-center">
                <span class="font-semibold text-base text-blueGray-700">Cursos Asignados</span>
            </div>

            @if ($cursosAsignados->count())
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Curso
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ciclo
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Seccion
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Opciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($cursosAsignados as $item)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium">
                            {{$item->nombreCurso}}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            {{$item->descripcionCiclo}}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            {{$item->descripcionSeccion}}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            <a class="text-red-600 hover:text-red-900 cursor-pointer" wire:click="deleteId({{$item->id}})">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="px-6 py-4">
                <span>No existen cursos asignados en este momento</span>
            </div>
            @endif
        </x-table>
    </div>

    <x-jet-confirmation-modal wire:model='isOpenModalDelete'>
        <x-slot name='title'>
            Eliminar curso
        </x-slot>
        <x-slot name='content'>
            ¿Esta seguro que quiere eliminar el curso?
        </x-slot>
        <x-slot name='footer'>
            <x-jet-secondary-button class="mr-4" wire:click="$set('isOpenModalDelete',false)">Cancelar</x-jet-secondary-button>
            <x-jet-button wire:click='delete' wire:loading.attr='disabled' wire:target='delete'>Guardar</x-jet-button>
        </x-slot>
    </x-jet-confirmation-modal>

</div>