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

                <div class="ml-4" wire:loading.flex wire:target='registros'>cargando...</div>
            </div>

            @if ($cargas->count())
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            #
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Docente
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Periodo
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Opciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($cargas as $item)
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium">
                                {{$item->id}}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium">
                                {{$item->declaracionJurada->docente->user->name}}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium">
                                {{$item->declaracionJurada->periodo->descripcion}}
                            </td>
                            <td class="px-6 py-4">
                                @if ($item->estado_asignado == 0)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-300">
                                    Pendiente
                                </span>
                                @endif
                            </td>
                            <td>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="px-6 py-4">
                <span>No existen cargas horarias en este momento</span>
            </div>
            @endif

            @if ($cargas->hasPages())
            <div class="px-6 py-4">
                {{ $cargas->links() }}
            </div>
            @endif
        </x-table>
    </div>


</div>
