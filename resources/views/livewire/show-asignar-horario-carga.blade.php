<div>

    @push('css')
    <style>
        #mensajeCarga {
            display: none;
        }

        #inputHorasSeleccionadas {
            display: none;
        }
    </style>
    @endpush

    <x-jet-form-section submit='save' class="mt-4">

        <x-slot name='title'>
            Asignar Horario para la carga
        </x-slot>

        <x-slot name='description'>
            En esta sección va a poder seleccionar un horario para las cargas que se le ha sido asignado.
        </x-slot>

        <x-slot name='form'>

            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for='carga' value='Carga:' />
                <select id="carga" wire:model="idCarga" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                    <option value="" selected>Seleccione</option>
                    @foreach ($cargaLectivaCarga as $item)
                    <option value="{{$item->id}}">{{$item->titulo}}</option>
                    @endforeach
                </select>
                <x-jet-input-error for='idCarga' class="mt-2" />
            </div>


            <div id="mensajeCarga" class="col-span-6 sm:col-span-4">
                <div class="text-gray-600">Horas de la carga por completar: {{$horasCarga}}</div>
            </div>

            @if ($horasCarga > 0)
            <div id="inputHorasSeleccionadas" class="col-span-6 sm:col-span-4">
                <x-jet-label value='Seleccione las horas que desee completar:' />
                <x-jet-input wire:model='horasCargaSeleccionadas' type='number' class=" mt-1 block w-full" max={{$horasCarga}} min=1 />
            </div>
            @else
            <div id="inputHorasSeleccionadas" class="col-span-6 sm:col-span-4">
                <div class="text-gray-600">Las horas de la carga ya han sido completadas</div>
            </div>
            @endif


            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for='aulaCarga' value='Local - Aula:' />
                <select disabled id="aulaCarga" wire:model='idAulaCarga' class="bg-gray-100 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                    <option value="" selected>Seleccione</option>
                    @foreach ($aulas as $item)
                    <option value="{{$item->id}}">{{$item->local->descripcion}} - {{$item->descripcion}}</option>
                    @endforeach
                </select>
                <x-jet-input-error for='idAulaCarga' class="mt-2" />
            </div>


            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for='diaCarga' value='Día:' />
                <select disabled id="diaCarga" wire:model='diaCarga' class="bg-gray-100 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                    <option value="" selected>Seleccione</option>
                    <option value="lunes" selected>Lunes</option>
                    <option value="martes" selected>Martes</option>
                    <option value="miercoles" selected>Miercoles</option>
                    <option value="ueves" selected>Jueves</option>
                    <option value="viernes" selected>Viernes</option>
                </select>
                <x-jet-input-error for='diaCarga' class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for='horaInicioCarga' value='Hora Inicio:' />
                <select disabled id="horaInicioCarga" wire:model='horaInicioCarga' class="bg-gray-100 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                    <option value="" selected>Seleccione</option>
                    @if ($haveHorasOcupadasCarga)
                    @foreach ($arrayHorasCarga as $item)
                    <option value="{{$item->id}}">{{$item->hora_inicio}}&nbsp;{{$item->sistema_horario}}</option>
                    @endforeach
                    @endif
                    @if ($haveHorasLibresCarga)
                    @foreach ($arrayHorasCarga as $item)
                    <option value="{{$item->id}}">{{$item->hora_inicio}}&nbsp;{{$item->sistema_horario}}</option>
                    @endforeach
                    @endif
                </select>
                <x-jet-input-error for='horaInicioCarga' class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for='horaFinalCarga' value='Hora Fin:' />
                <select disabled id="horaFinalCarga" wire:model='horaFinalCarga' class="bg-gray-100 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                    <option value="" selected>Automático</option>
                    @foreach ($horas as $item)
                    <option value="{{$item->id}}">{{$item->hora_fin}}&nbsp;{{$item->sistema_horario}}</option>
                    @endforeach
                </select>
                <x-jet-input-error for='horaFinalCarga' class="mt-2" />
            </div>

        </x-slot>

        <x-slot name='actions'>

            <x-jet-action-message class="mr-3" on='saved'>Guardando</x-jet-action-message>

            <x-jet-button wire:loading.attr="disabled">Guardar</x-jet-button>

        </x-slot>

    </x-jet-form-section>

    @push('js')
    <script>
        Livewire.on('showMensajeCarga', event => {
            showMensajeCarga();
        })

        Livewire.on('showInputHorasSeleccionadas', event => {
            showInputHorasSeleccionadas();
        })

        Livewire.on('activateAulaCarga', event => {
            activateAulaCarga();
        })

        Livewire.on('activateDiaCarga', event => {
            activateDiaCarga();
        })

        Livewire.on('activateHoraInicioCarga', event => {
            activateHoraInicioCarga();
        })


        function showMensajeCarga() {
            $('#mensajeCarga').css("display", "block");
        }

        function showInputHorasSeleccionadas() {
            $('#inputHorasSeleccionadas').css("display", "block");
        }
        
        function activateAulaCarga(){
            $('#aulaCarga').removeAttr('disabled');
            $('#aulaCarga').removeClass('bg-gray-100');
        }

        function activateDiaCarga(){
            $('#diaCarga').removeAttr('disabled');
            $('#diaCarga').removeClass('bg-gray-100');
        }

        function activateHoraInicioCarga(){
            $('#horaInicioCarga').removeAttr('disabled');
            $('#horaInicioCarga').removeClass('bg-gray-100');
        }
    </script>
    @endpush
</div>