<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <x-table>
            <!-----Busqueda----->
            <!---div class="px-6 py-4">
                <x-jet-input class="w-full" type='text' wire:model='search' placeholder=""></x-jet-input>
            </div---->
            @if ($declaraciones->count())
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            #
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Periodo
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Documento Generado
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ver detalles
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($declaraciones as $item)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium">
                            {{$numeracion}}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            {{$item->periodo->descripcion}}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100">
                                {{$item->estado}}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            <form action="{{ route('declaracionJurada.dowload',['id' => $item->id])}}" method="post">
                                @csrf
                                <button type="submit"><i class="fa fa-download"></i></button>
                            </form>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            <a href="#"><i class="fa-solid fa-magnifying-glass"></i></a>
                        </td>
                    </tr>
                    <?php $numeracion++; ?>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="px-6 py-4">
                <span>No existen declaraciones juradas en este momento</span>
            </div>
            @endif
        </x-table>

    </div>
</div>