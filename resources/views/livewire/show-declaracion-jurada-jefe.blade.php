<div>

    @push('css')

    <style>
        .ocultar {
            display: none;
        }

        textarea {
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
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-300">
                                pendiente
                            </span>
                            @endif
                            @if ($item->estado == 'observado')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-300">
                                {{$item->estado}}
                            </span>
                            @endif
                            @if ($item->estado == 'rechazado')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-300">
                                {{$item->estado}}
                            </span>
                            @endif
                            @if ($item->estado == 'aprobado')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-300">
                                {{$item->estado}}
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            <!---button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="openModal()"><i class="fa-solid fa-eye"></i></button---->
                            <a title="Ver documento" class="cursor-pointer bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" wire:click='openModalViewDocument({{$item}})'><i class="fa-solid fa-eye"></i></a>
                            <a title="Descargar documento" class="cursor-pointer bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" wire:click='download({{$item}})'><i class="fa fa-download"></i></a>
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
                <select wire:model.defer='estado' name="" id="" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full">
                    <option selected value="">Seleccionar</option>
                    <option value="aprobado">Aprobar</option>
                    <option value="observado">Observar</option>
                    <option value="rechazado">Rechazar</option>
                </select>
                <x-jet-input-error for='estado'></x-jet-input-error>
            </div>

            <!--------CheckBox------->
            <div class="mb-4">
                <label for="check" class="mr-2">Incluir observaciones</label>
                <input type="checkbox" wire:model.defer='checkBoxObservaciones' id="check" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" onchange="javascript:showContent()">
            </div>

            <!------Observaciones------>
            <div class="mb-4">
                <textarea wire:model.defer='observaciones' name="" id="content" rows="3" placeholder="Escriba aquí sus observaciones" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full ocultar"></textarea>
            </div>

        </x-slot>

        <x-slot name='footer'>

            <!-----Mensaje de acción----->
            <x-jet-action-message class="mr-4" wire:loading on='update'>Cargando.....</x-jet-action-message>

            <!------Cancelar----->
            <x-jet-secondary-button class="mr-4" wire:click='cancelar' wire:loading.attr='disabled' wire:target='update,cancelar'>Cancelar</x-jet-secondary-button>

            <!---------Guardar------Para más información mirar la función edit de la clase---->
            <x-jet-button wire:click='update' wire:loading.attr='disabled' wire:target='update,cancelar'>Guardar</x-jet-button>

        </x-slot>
    </x-jet-dialog-modal>


    <!-- Modal para la visualización del documento-->
    <div class="fixed z-50 inset-0 overflow-y-auto hidden" id="modalDocument">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

            <!-- Fondo oscuro detrás del modal -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <!-- Contenido del modal -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <iframe class="w-full h-screen" srcdoc="{{$htmlContent}}" frameborder="0"></iframe>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm" onclick="closeModal()">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!------------------Modal para mostrar ----------------->
    <x-jet-dialog-modal wire:model='showModalView'>
        <x-slot name='title'>
            Declaración Jurada Evaluada
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

            <!-----Estado------->
            <div class="mb-4">
                <x-jet-label value='Estado' />
                <x-jet-input disabled type='text' wire:model='estado' class="bg-gray-100 w-full" />
            </div>

            <!------Observaciones------>
            <div class="mb-4">
                <x-jet-label value='Observaciones' />
                <textarea disabled wire:model='observaciones' rows="3" class="bg-gray-100 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full"></textarea>
            </div>

        </x-slot>

        <x-slot name='footer'>
            <!-----Mensaje de acción----->
            <x-jet-action-message class="mr-4" wire:loading on='cancelar'>Cargando.....</x-jet-action-message>

            <!------Cancelar----->
            <x-jet-secondary-button class="mr-4" wire:click="closeModalView" wire:loading.attr='disabled' wire:target='closeModalView'>Cerrar</x-jet-secondary-button>
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

        Livewire.on('removeHidden', event => {
            document.getElementById('modalDocument').classList.remove('hidden');
        })

        function closeModal() {
            document.getElementById('modalDocument').classList.add('hidden');
        }
    </script>
    @endpush

</div>