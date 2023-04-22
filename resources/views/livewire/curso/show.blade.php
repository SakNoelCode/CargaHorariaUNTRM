<div>

    <x-cabecerabox>
        <x-slot name='title'>
            Cursos
        </x-slot>
        <x-slot name='descripcion'>
            En esta sección podrá gestionar los cursos.
        </x-slot>
        <x-slot name='botones'>
            <div class="px-6 py-4 flex justify-center">
                @livewire('curso.create')
            </div>
        </x-slot>
    </x-cabecerabox>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <x-table>
            <!-----Cabecera Tabla----->
            <div class="px-6 py-4 flex items-center">

                <!-----Mostrar registros----->
                <span class="mr-2">Mostrar</span>
                <select wire:model='numRegistros' class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="100">100</option>
                </select>
                <span class="ml-2">registros</span>

                <div class="ml-4" wire:loading.flex wire:target='numRegistros,edit'>cargando...</div>

                <!-----Búsqueda----->
                <x-jet-input class="w-full ml-8" type='text' wire:model='search' placeholder="Busque mediante nombre"></x-jet-input>
            </div>


            @if ($cursos->count())
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            #
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nombre
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tipo
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ciclo
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Especialidad
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($cursos as $item)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium  text-gray-500">
                            {{$item->id}}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium  text-gray-500">
                            {{$item->nombre}}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium  text-gray-500">
                            {{$item->tipo}}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium  text-gray-500">
                            @if ($item->ciclo != null)
                            {{$item->ciclo->descripcion}}
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm font-medium  text-gray-500">
                            {{$item->especialidad->descripcion}}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium  text-gray-500">
                            @if ($item->estado == 1)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100">
                                ACTIVO
                            </span>
                            @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100">
                                INACTIVO
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            <a class="text-indigo-600 hover:text-indigo-900 cursor-pointer" wire:click="edit({{$item}})">Editar</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="px-6 py-4">
                <span>No existen registros!!</span>
            </div>
            @endif

            @if ($cursos->hasPages())
            <div class="px-6 py-4">
                {{ $cursos->links() }}
            </div>
            @endif
        </x-table>
    </div>

    <x-jet-dialog-modal wire:model='isOpenEdit'>
        <x-slot name='title'>
            Editar curso
        </x-slot>
        <x-slot name='content'>
            <div class="mb-4">
                <x-jet-label for='nameCurso' value='Nombre:' />
                <x-jet-input id="nameCurso" type='text' class="w-full" wire:model.defer='nameCurso' />
                <x-jet-input-error for='nameCurso' />
            </div>
            <div class="mb-4">
                <x-jet-label for='tipoCurso' value='Tipo:' />
                <select id="tipoCurso" wire:model.defer='tipoCurso' class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full">
                    <option value="O">Obligatorio</option>
                    <option value="E">Elegible</option>
                </select>
                <x-jet-input-error for='tipoCurso' />
            </div>
            <div class="mb-4">
                <x-jet-label for='cicloCurso' value='Ciclo:' />
                <select id="cicloCurso" wire:model.defer='cicloId' class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full">
                    @foreach ($ciclos as $ciclo)
                    <option value="{{$ciclo->id}}">{{$ciclo->descripcion}}</option>
                    @endforeach
                </select>
                <x-jet-input-error for='cicloId' />
            </div>
            <div class="mb-4">
                <x-jet-label for='especialidadCurso' value='Especialidad:' />
                <select id="especialidadCurso" wire:model.defer='especialidadCurso' class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full">
                    @foreach ($especialidades as $item)
                    <option value="{{$item->id}}">{{$item->descripcion}}</option>
                    @endforeach
                </select>
                <x-jet-input-error for='especialidadCurso' />
            </div>
            <div class="block mb-2">
                <label for="status-{{$idCurso}}" class="flex items-center">
                    <x-jet-checkbox id="status-{{$idCurso}}" wire:model.defer='estadoCurso' />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Estado') }}</span>
                </label>
            </div>
        </x-slot>
        <x-slot name='footer'>
            <x-jet-action-message class="mr-4" wire:loading on='update'>Cargando....</x-jet-action-message>
            <x-jet-secondary-button class="mr-4" wire:click="closeEdit" wire:loading.attr='disabled' wire:target='update,closeEdit'>Cancelar</x-jet-secondary-button>
            <x-jet-button wire:click='update' wire:loading.attr='disabled' wire:target='update,closeEdit'>Guardar</x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>