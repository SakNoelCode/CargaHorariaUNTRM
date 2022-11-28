<div>
    <!--------Boton ------->
    <x-jet-button wire:click="$set('IsOpen',true)">
        Crear nuevo Docente
    </x-jet-button>

    <!--------Modal------->
    <x-jet-dialog-modal wire:model='IsOpen'>
        <x-slot name='title'>
            Crear nuevo docente
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
                        <option value="" disabled selected>Seleccione</option>
                        @foreach ($escuelas as $escuela)
                        <option value="{{$escuela->id}}">{{$escuela->descripcion}}</option>
                        @endforeach
                    </select>
                    <x-jet-input-error for='escuela_id' />
                </div>
                <!--div>Escuela: @json($escuela_id)</div---->

                <!----Condiciones--->
                <div class="mb-4 flex-1 ml-4">
                    <x-jet-label value='Condicion' />
                    <select name="" id="" wire:model.defer='condicion_id' class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full">
                        <option value="" disabled selected>Seleccione</option>
                        @foreach ($condiciones as $condicion)
                        <option value="{{$condicion->id}}">{{$condicion->descripcion}}</option>
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
                        <option value="" disabled selected>Seleccione</option>
                        @foreach ($categorias as $category)
                        <option value="{{$category->id}}">{{$category->descripcion}}</option>
                        @endforeach
                    </select>
                    <x-jet-input-error for='categoria_id' />
                </div>

                <!----Modalidades--->
                <div class="mb-4 flex-1 ml-4">
                    <x-jet-label value='Modalidad' />
                    <select name="" id="" wire:model.defer='modalidad_id' class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full">
                        <option value="" disabled selected>Seleccione</option>
                        @foreach ($modalidades as $modalidad)
                        <option value="{{$modalidad->id}}">{{$modalidad->descripcion}}</option>
                        @endforeach
                    </select>
                    <x-jet-input-error for='modalidad_id' />
                </div>
            </div>

            <div class="flex">
                <!----Contraseña--->
                <div class="mb-4 flex-1 mr-4">
                    <x-jet-label value='Contraseña' />
                    <x-jet-input type='password' class="w-full" wire:model.defer='password' />
                    <x-jet-input-error for='password' />
                </div>

                <!----Confirm Contraseña--->
                <div class="mb-4 flex-1 ml-4">
                    <x-jet-label value='Confirmar contraseña' />
                    <x-jet-input type='password' class="w-full" wire:model.defer='password_confirmation' />
                    <x-jet-input-error for='password_confirmation' />
                </div>
            </div>

        </x-slot>

        <x-slot name='footer'>
            <x-jet-action-message class="mr-4" wire:loading on='save'>Cargando....</x-jet-action-message>
            <x-jet-secondary-button class="mr-4" wire:click="cleanFields">Cancelar</x-jet-secondary-button>
            <x-jet-button wire:click='save' wire:loading.attr='disabled' wire:target='save'>Guardar</x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>