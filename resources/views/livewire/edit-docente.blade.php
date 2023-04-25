<div>
    @push('css')
    @endpush

    <a class="text-indigo-600 hover:text-indigo-900 cursor-pointer" wire:click="$set('IsOpen',true)">Editar</a>

    <x-jet-dialog-modal wire:model='IsOpen'>
        <x-slot name='title'>
            Editar docente
        </x-slot>

        <x-slot name='content'>

            <div class="flex">
                <!----Nombre--->
                <div class="mb-4 flex-1 mr-4">
                    <x-jet-label value='Nombres' />
                    <x-jet-input type='text' class="w-full" wire:model.defer='name' />
                    <x-jet-input-error for='name' />
                </div>

                <!----DNI--->
                <div class="mb-4 flex-1 ml-4">
                    <x-jet-label value='DNI' />
                    <x-jet-input type='text' class="w-full" wire:model.defer='dni' />
                    <x-jet-input-error for='dni' />
                </div>
            </div>

            <!----Email--->
            <div class="mb-4">
                <x-jet-label value='Correo electrónico (Institucional)' />
                <x-jet-input type='email' class="w-full" wire:model.defer='email' />
                <x-jet-input-error for='email' />
            </div>

            <div class="flex">
                <!----Escuelas--->
                <div class="mb-4 flex-1 mr-4">
                    <x-jet-label value='Escuela' />
                    <select name="" id="" wire:model.defer='escuela_id' class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full">
                        @foreach ($escuelas as $escuela)
                        @if ($escuela->id == "{{$escuela_id}}")
                        <option value="{{$escuela->id}}" selected>{{$escuela->descripcion}}</option>
                        @else
                        <option value="{{$escuela->id}}">{{$escuela->descripcion}}</option>
                        @endif
                        @endforeach
                    </select>
                    <x-jet-input-error for='escuela_id' />
                </div>
                <!----Condiciones--->
                <div class="mb-4 flex-1 ml-4">
                    <x-jet-label value='Condicion' />
                    <select name="" id="" wire:model.defer='condicion_id' class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full">
                        @foreach ($condiciones as $condicion)
                        @if ($condicion->id == "{{$condicion_id}}")
                        <option value="{{$condicion->id}}" selected>{{$condicion->descripcion}}</option>
                        @else
                        <option value="{{$condicion->id}}">{{$condicion->descripcion}}</option>
                        @endif
                        @endforeach
                    </select>
                    <x-jet-input-error for='condicion_id' />
                </div>
            </div>

            <div class="flex">
                <!----Categorías--->
                <div class="mb-4 flex-1 mr-4">
                    <x-jet-label value='Categoría' />
                    <select name="" id="" wire:model.defer='categoria_id' class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full">
                        @foreach ($categorias as $categoria)
                        @if ($categoria->id == "{{$categoria_id}}")
                        <option value="{{$categoria->id}}" selected>{{$categoria->descripcion}}</option>
                        @else
                        <option value="{{$categoria->id}}">{{$categoria->descripcion}}</option>
                        @endif
                        @endforeach
                    </select>
                    <x-jet-input-error for='categoria_id' />
                </div>

                <!----Modalidades--->
                <div class="mb-4 flex-1 ml-4">
                    <x-jet-label value='Modalidad' />
                    <select name="" id="" wire:model.defer='modalidad_id' class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full">
                        @foreach ($modalidades as $modalidad)
                        @if ($modalidad->id == "{{$modalidad_id}}")
                        <option value="{{$modalidad->id}}" selected>{{$modalidad->descripcion}}</option>
                        @else
                        <option value="{{$modalidad->id}}">{{$modalidad->descripcion}}</option>
                        @endif
                        @endforeach
                    </select>
                    <x-jet-input-error for='modalidad_id' />
                </div>
            </div>

            <!-------Status------>
            <div class="block mb-2">
                <label for="status-{{$idUser}}" class="flex items-center">
                    <x-jet-checkbox id="status-{{$idUser}}" wire:model.defer='status' />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Estado') }}</span>
                </label>
            </div>

        </x-slot>

        <x-slot name='footer'>
            <x-jet-action-message class="mr-4" wire:loading on='save'>Cargando....</x-jet-action-message>
            <x-jet-secondary-button class="mr-4" wire:click="closeEditDocente" wire:loading.attr='disabled' wire:target='save,closeEditDocente'>Cancelar</x-jet-secondary-button>
            <x-jet-button wire:click='save' wire:loading.attr='disabled' wire:target='save,closeEditDocente'>Actualizar </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

    @push('js')
    @endpush

</div>