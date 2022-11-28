<div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <x-table>
            <!-----mostrar registros----->
            <div class="px-6 py-4 flex items-center">
                <span class="mr-2">Mostrar</span>
                <select wire:model='numberOfRecords' class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="100">100</option>
                </select>
                <span class="ml-2">registros</span>

                <div class="ml-4" wire:loading.flex wire:target='numberOfRecords'>cargando...</div>
            </div>
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
                            @if ($item->estado == 'generado')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100">
                                {{$item->estado}}
                            </span>
                            @endif
                            @if ($item->estado == 'enviado')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100">
                                {{$item->estado}}
                            </span>
                            @endif

                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            <form action="{{ route('declaracionJurada.dowload',['id' => $item->id])}}" method="post">
                                @csrf
                                <button type="submit"><i class="fa fa-download"></i></button>
                            </form>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            <a class="cursor-pointer" wire:click="edit({{$item}})"><i class="fa-solid fa-magnifying-glass"></i></a>
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

            @if ($declaraciones->hasPages())
            <div class="px-6 py-4">
                {{ $declaraciones->links() }}
            </div>
            @endif
        </x-table>

    </div>


    <!-----------------------------Modal Editar--------------------->
    <x-jet-dialog-modal wire:model='isOpenEdit'>
        <x-slot name='title'>
            Detalles de la declaracion jurada
        </x-slot>

        <x-slot name='content'>
            <!-----Descripcion------->
            <div class="mb-4">
                @if($estado == 'generado')
                <x-jet-label value='Suba su declaración firmada y envíelo para su revisión' />
                @endif

                @if($estado == 'enviado')
                <x-jet-label value='Espere a que su documento se revise' />
                @endif
            </div>

            <!----Nombre Docente--->
            <div class="mb-4">
                <x-jet-label value='Docente:' />
                <x-jet-input disabled type='text' class="w-full bg-gray-100" wire:model='nameDocente' />
            </div>

            <!--Periodo-->
            <div class="mb-4">
                <x-jet-label value='Periodo: ' />
                <x-jet-input disabled type='text' class="w-full bg-gray-100" wire:model='periodo' />
            </div>

            <!------Documento------>
            @if ($estado != 'enviado')
            <div class="mb-4">
                <x-jet-label value='Documento: ' />
                <x-jet-input id="{{$idDocumento}}" type='file' accept=".doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" class="w-full cursor-pointer" wire:model.defer='documento' />
                <x-jet-input-error for='documento' />
            </div>
            @else
            <div class="mb-4">
                <x-jet-label value='Documento enviado: (descargar)' />
                {{---{{var_export($documento)}}---}}
                <a class="cursor-pointer" wire:click='download'><i class="fa fa-download"></i></a>
            </div>
            @endif


        </x-slot>

        <x-slot name='footer'>
            <x-jet-action-message class="mr-4" wire:loading on='update'>Cargando....</x-jet-action-message>
            <x-jet-secondary-button class="mr-4" wire:click="$set('isOpenEdit',false)">Cancelar</x-jet-secondary-button>

            @if ($estado == 'enviado')
            <x-jet-button disabled>Enviar</x-jet-button>
            @else
            <x-jet-button wire:click='update' wire:loading.attr='disabled' wire:target='update,documento'>Enviar</x-jet-button>
            @endif
        </x-slot>
    </x-jet-dialog-modal>


    @push('js')
    <script>
        
    </script>
    @endpush
</div>