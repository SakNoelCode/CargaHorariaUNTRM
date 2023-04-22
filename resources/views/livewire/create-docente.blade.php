<div>
    @push('css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
        /**Estilos personalizados para la caja se select2 */
        .select2-container .select2-selection {
            height: 35px;
        }
    </style>
    @endpush
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
                    <x-jet-label value='Nombre completo' for='name' />
                    <x-jet-input id="name" type='text' class="w-full" wire:model.defer='name' />
                    <x-jet-input-error for='name' />
                </div>

                <!----DNI--->
                <div class="mb-4 flex-1 ml-4">
                    <x-jet-label value='DNI' for='dni' />
                    <x-jet-input id="dni" type='text' class="w-full" wire:model.defer='dni' />
                    <x-jet-input-error for='dni' />
                </div>
            </div>

            <!----Email--->
            <div class="mb-4">
                <x-jet-label value='Correo electrónico (Institucional)' for='email' />
                <x-jet-input id="email" type='email' class="w-full" wire:model.defer='email' />
                <x-jet-input-error for='email' />
            </div>

            <!----Especialidad--->
            <div class="mb-4" wire:ignore>
                <x-jet-label value='Especialidades (máx:3)' for='especialidad' />
                <select name="" id="especialidad" multiple="multiple">
                    @foreach ($especialidades as $item)
                    <option value="{{$item->id}}">{{$item->descripcion}}</option>
                    @endforeach
                </select>
            </div>
         <!-----   @if(is_array($especialidades_id))
            <p>Colores seleccionados: {{ implode(', ', $especialidades_id) }}</p>
            @endif------->

            <div class="flex">
                <!----Escuelas--->
                <div class="mb-4 flex-1 mr-4">
                    <x-jet-label value='Escuela' for='escuela' />
                    <select name="" id="escuela" wire:model.defer='escuela_id' class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full">
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
                    <x-jet-label value='Condicion' for='condicion' />
                    <select name="" id="condicion" wire:model.defer='condicion_id' class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full">
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
                    <x-jet-label value='Categoría' for="categoria" />
                    <select name="" id="categoria" wire:model.defer='categoria_id' class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full">
                        <option value="" disabled selected>Seleccione</option>
                        @foreach ($categorias as $category)
                        <option value="{{$category->id}}">{{$category->descripcion}}</option>
                        @endforeach
                    </select>
                    <x-jet-input-error for='categoria_id' />
                </div>

                <!----Modalidades--->
                <div class="mb-4 flex-1 ml-4">
                    <x-jet-label value='Modalidad' for='modalidad' />
                    <select name="" id="modalidad" wire:model.defer='modalidad_id' class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full">
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
                    <x-jet-label value='Contraseña' for='password' />
                    <x-jet-input id="password" type='password' class="w-full" wire:model.defer='password' />
                    <x-jet-input-error for='password' />
                </div>

                <!----Confirm Contraseña--->
                <div class="mb-4 flex-1 ml-4">
                    <x-jet-label value='Confirmar contraseña' for='confirmPassword' />
                    <x-jet-input id="confirmPassword" type='password' class="w-full" wire:model.defer='password_confirmation' />
                    <x-jet-input-error for='password_confirmation' />
                </div>
            </div>

        </x-slot>

        <x-slot name='footer'>
            <x-jet-action-message class="mr-4" wire:loading on='save'>Cargando....</x-jet-action-message>
            <x-jet-secondary-button class="mr-4" wire:click="cleanFields" wire:loading.attr='disabled' wire:target='save,cleanFields'>Cancelar</x-jet-secondary-button>
            <x-jet-button wire:click='save' wire:loading.attr='disabled' wire:target='save,cleanFields'>Guardar</x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

    @push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/i18n/es.js"></script>
    <script>
        //Funcion para el select Especialidades
        $(document).ready(function() {
            $('#especialidad').select2({
                width: '100%',
                placeholder: "Seleccione:",
                language: "es",
                maximumSelectionLength: 3,
            });
            $('#especialidad').on('change', function(e) {
                Livewire.emit('listenerReferenceEspecialidades',
                    $('#especialidad').select2("val"));
            });
        });

        document.addEventListener('livewire:load', function(event) {
            //escuchar el evento OpenMoal de la clase
            @this.on('openModal', function() {
                //Limpieza de selects
                $("#especialidad").val(null).trigger('change');

            })
        })
    </script>
    @endpush
</div>