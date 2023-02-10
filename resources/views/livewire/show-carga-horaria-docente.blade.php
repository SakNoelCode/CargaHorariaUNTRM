<div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <x-table>
            <!-----Cantidad de registros por mostrar---->
            <div class="px-6 py-4 flex items-center">
                <span class="mr-2">Mostrar</span>
                <select wire:model='registros' class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="100">100</option>
                </select>
                <span class="ml-2">registros</span>

                <div class="ml-4" wire:loading.delay wire:target='registros'>cargando...</div>
            </div>

            @if ($cargasLectiva->count())
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            #
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Asignado
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Periodo
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Carga
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Horario
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Opcciones
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Documentos
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($cargasLectiva as $item)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium">
                            {{$enumerator}}
                        </td>
                        <td class="px-6 py-4">
                            @if ($item->estado_asignado == 0)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-300">
                                Pendiente
                            </span>
                            @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-300">
                                Asignado
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            {{$item->descripcion}}
                        </td>
                        <td class="px-6 py-4">
                            @if ($item->estado_terminado == 0)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-300">
                                Pendiente
                            </span>
                            @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-300">
                                Terminado
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-300">
                                Pendiente
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('cargalectiva.llenar',$item->id) }}">
                                <x-jet-secondary-button>Asignacion carga</x-jet-secondary-button>
                            </a>
                            <a href="{{route('cargalectiva.horario',$item->id)}}">
                                <x-jet-secondary-button>Declaracion carga</x-jet-secondary-button>
                            </a>
                        </td>
                        <td class="px-6 py-4 flex justify-center">
                            <a class="cursor-pointer text-gray-600 mr-4">
                                <i class="fa-solid fa-file"></i>
                            </a>
                            <a class="cursor-pointer text-gray-600 ml-4">
                                <i class="fa-solid fa-calendar-days"></i>
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
                <span>No existen cargas horarias en este momento</span>
            </div>
            @endif

            @if ($cargasLectiva->hasPages())
            <div class="px-6 py-4">
                {{ $cargas->links() }}
            </div>
            @endif

        </x-table>
    </div>

</div>