<div>

    @push('css')

    <style>
        .ocultar {
            display: none;
        }

        textarea{
            resize: none;
        }
    </style>

    @endpush


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
                            Docente
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Periodo
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Declaración
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Opciones
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
                            {{$item->docente->user->name}}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            {{$item->periodo->descripcion}}
                        </td>
                        <td class="px-6 py-4">
                            @if ($item->estado == 'enviado')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100">
                                pendiente
                            </span>
                            @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100">
                                {{$item->estado}}
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            <a class="cursor-pointer" wire:click='download({{$item}})'><i class="fa fa-download"></i></a>
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


    <!------------------------Modal Editar------------------->
    <x-jet-dialog-modal wire:model='showModalEdit'>
        <x-slot name='title'>
            Evaluar Declaración Jurada
        </x-slot>

        <x-slot name='content'>
            <!-----Nombre Docente---->
            <div class="mb-4">
                <x-jet-label value='Docente: ' />
                <x-jet-input disabled type='text' wire:model='nameDocente' class="bg-gray-100 w-full" />
            </div>

            <!-----Periodo------->
            <div class="mb-4">
                <x-jet-label value='Periodo' />
                <x-jet-input disabled type='text' wire:model='periodo' class='bg-gray-100 w-full' />
            </div>

            <!------Estado------->
            <div class="mb-4">
                <x-jet-label value='Estado' />
                <select wire:model='estado' name="" id="" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full">
                    <option selected value="">Seleccionar</option>
                    <option value="aprobado">Aprobar</option>
                    <option value="observado">Observar</option>
                    <option value="rechazado">Rechazar</option>
                </select>
            </div>

            <!--------CheckBox------->
            <div class="mb-4">
                <label for="check" class="mr-2">Incluir observaciones</label>
                <input type="checkbox" name="" id="check" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" onchange="javascript:showContent()">
            </div>

            <!------Observaciones------>
            <div class="mb-4">
                <textarea wire.model='observaciones' name="" id="content" rows="3" placeholder="Escriba aquí sus observaciones" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full ocultar"></textarea>
            </div>

        </x-slot>

        <x-slot name='footer'>

        </x-slot>
    </x-jet-dialog-modal>

    @push('js')
    <script type="text/javascript">
        //Función para mostrar u ocultar las observaciones
        function showContent() {
            element = document.getElementById("content");
            check = document.getElementById("check");
            if (check.checked) {
                element.style.display = 'block';
            } else {
                element.style.display = 'none';
            }
        }
    </script>
    @endpush

</div>