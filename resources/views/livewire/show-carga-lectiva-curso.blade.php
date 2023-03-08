<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
        <x-table>
            <!-----Cabecera---->
            <div class="px-6 py-4 flex items-center">
                <span class="font-bold text-base text-blue-900">Cursos Asignados</span>
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
                        @if ($estadoCargaLectiva == 0)
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Opciones
                        </th>
                        @endif
                        @if ($isDocente)
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            N° de alummnos
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Hrs. teoría
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Hrs. práctica
                        </th>
                        @if ($estadoCargaLectivaTerminado == 0)
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                        @endif
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Total horas
                        </th>
                        @endif
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
                        @if ($estadoCargaLectiva == 0)
                        <td class="px-6 py-4 text-sm font-medium">
                            <a class="text-red-600 hover:text-red-900 cursor-pointer" wire:click="deleteId({{$item->id}})">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                        @endif
                        @if ($isDocente)
                        <td class="px-6 py-4 text-sm font-medium">
                            {{$item->numAlumnos}}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            {{$item->horasTeoria}}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            {{$item->horasPractica}}
                        </td>
                        @if ($estadoCargaLectivaTerminado == 0)
                        <td class="px-6 py-4 text-sm font-medium">
                            <a class="text-indigo-600 hover:text-indigo-900 cursor-pointer" wire:click="edit({{$item->id}})">{{$item->totalHoras==0 ? 'Completar' : 'Editar'}}</a>
                        </td>
                        @endif
                        <td class="px-6 py-4 text-sm font-medium">
                            <span>{{$item->totalHoras}}</span>
                        </td>
                        @endif
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

    <!----------Modal delete-------------->
    <x-jet-confirmation-modal wire:model='isOpenModalDelete'>
        <x-slot name='title'>
            Eliminar curso
        </x-slot>
        <x-slot name='content'>
            ¿Esta seguro que quiere eliminar el curso?
        </x-slot>
        <x-slot name='footer'>
            <x-jet-secondary-button class="mr-4" wire:click="closeModalDelete" wire:loading.attr='disabled' wire:target='delete,closeModalDelete'>Cancelar</x-jet-secondary-button>
            <x-jet-button wire:click='delete' wire:loading.attr='disabled' wire:target='delete,closeModalDelete'>Guardar</x-jet-button>
        </x-slot>
    </x-jet-confirmation-modal>

    <!------Modal editar----->
    <x-jet-dialog-modal wire:model='isOpenModalEdit'>
        <x-slot name='title'>
            Completar datos
        </x-slot>
        <x-slot name='content'>

            <div class="mb-4">
                <x-jet-label value='Numero de alumnos:' />
                <x-jet-input type='number' step="1" pattern="\d+" class="w-full" wire:model.defer='numAlumnos' />
                <x-jet-input-error for='numAlumnos' />
            </div>

            <div class="mb-4">
                <x-jet-label value='Horas de teoría:' />
                <x-jet-input type='number' min='1' class="w-full" wire:model.defer='horasTeoria' />
                <x-jet-input-error for='horasTeoria' />
            </div>

            <div class="mb-4">
                <x-jet-label value='Horas de práctica:' />
                <x-jet-input type='number' min='1' class="w-full" wire:model.defer='horasPractica' />
                <x-jet-input-error for='horasPractica' />
            </div>

        </x-slot>
        <x-slot name='footer'>
            <x-jet-action-message class="mr-4" wire:loading on='update'>Cargando.....</x-jet-action-message>
            <x-jet-secondary-button class="mr-4" wire:click='close' wire:loading.attr='disabled' wire:target='update,close'>Cerrar</x-jet-secondary-button>
            <x-jet-button wire:click='update' wire:loading.attr='disabled' wire:target='update,close'>Guardar</x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

</div>