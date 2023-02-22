<div>

    @push('css')
    <style>
        #tipoCurso {
            display: none;
        }

        #mensaje {
            display: none;
        }
    </style>
    @endpush

    <x-jet-form-section submit='save' class="mt-4">

        <x-slot name='title'>
            Asignar Horario para el curso
        </x-slot>

        <x-slot name='description'>
            En esta sección va a poder seleccionar un horario para los cursos que se le ha sido asignado.
        </x-slot>

        <x-slot name='form'>

            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for='curso' value='Curso:' />
                <select id="curso" wire:model="idCurso" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                    <option value="" selected>Seleccione</option>
                    @foreach ($cargaLectivaCurso as $item)
                    <option value="{{$item->id}}">{{$item->nombre}}</option>
                    @endforeach
                </select>
                <x-jet-input-error for='idCurso' class="mt-2" />
            </div>

            <div id="tipoCurso" class="col-span-6 sm:col-span-4">
                <x-jet-label for='tipo' value='Seleccione las horas a completar:' />
                <select id="tipo" wire:model="tipoCurso" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                    <option value="" selected>Seleccione</option>
                    <option value="teorico">Teoricas</option>
                    <option value="practico">Practicas</option>
                </select>
                <x-jet-input-error for='tipoCurso' class="mt-2" />
            </div>

            <!--------------Mensaje----------->
            <div id="mensaje" class="col-span-6 sm:col-span-4">
                @if ($tipoCurso == 'teorico')
                @if ($horasTeoriaCurso == 0)
                <div class="text-gray-600">Las horas teóricas ya han sido completadas</div>
                @else
                <div class="text-gray-600">Horas Teoría: {{$horasTeoriaCurso}}</div>
                @endif
                @endif

                @if ($tipoCurso == 'practico')
                @if ($horasPracticaCurso == 0)
                <div class="text-gray-600">Las horas prácticas ya han sido completadas</div>
                @else
                <div class="text-gray-600">Horas Practica: {{$horasPracticaCurso}}</div>
                @endif
                @endif
            </div>


            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for='aulaCurso' value='Local - Aula:' />
                <select disabled id="aulaCurso" wire:model='idAulaCurso' class="bg-gray-100 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                    <option value="" selected>Seleccione</option>
                    @foreach ($aulasCurso as $item)
                    <option value="{{$item->id}}">{{$item->local->descripcion}} - {{$item->descripcion}}</option>
                    @endforeach
                </select>
                <x-jet-input-error for='idAulaCurso' class="mt-2" />
            </div>


            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for='diaCurso' value='Día:' />
                <select disabled id="diaCurso" wire:model='diaCurso' class="bg-gray-100 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                    <option value="" selected>Seleccione</option>
                    <option value="lunes" selected>Lunes</option>
                    <option value="martes" selected>Martes</option>
                    <option value="miercoles" selected>Miercoles</option>
                    <option value="ueves" selected>Jueves</option>
                    <option value="viernes" selected>Viernes</option>
                </select>
                <x-jet-input-error for='diaCurso' class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for='horaInicioCurso' value='Hora Inicio:' />
                <select disabled id="horaInicioCurso" wire:model='horaInicioCurso' class="bg-gray-100 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                    <option value="" selected>Seleccione</option>
                    
                    @if ($arrayHorasCurso != '')
                    @foreach ($arrayHorasCurso as $item)
                    <option value="{{$item->id}}">{{$item->hora_inicio}}&nbsp;{{$item->sistema_horario}}</option>
                    @endforeach    
                    @endif

                </select>
                <x-jet-input-error for='horaInicioCurso' class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for='horaFinal' value='Hora Fin:' />
                <select disabled id="horaFinal" wire:model='horaFinalCurso' class="bg-gray-100 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                    <option value="" selected>Automático</option>
                    @foreach ($horasCurso as $item)
                    <option value="{{$item->id}}">{{$item->hora_fin}}&nbsp;{{$item->sistema_horario}}</option>
                    @endforeach
                </select>
                <x-jet-input-error for='horaFinalCurso' class="mt-2" />
            </div>


        </x-slot>


        <x-slot name='actions'>

            <x-jet-action-message class="mr-3" on='saved'>Guardando</x-jet-action-message>

            <x-jet-button id="btn_submit" wire:loading.attr="disabled">Guardar</x-jet-button>

        </x-slot>

    </x-jet-form-section>

    @push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
    <script>
        //Escuhar evento que vienen del modelo
        Livewire.on('showTipoCurso', event => {
            showTipoCurso();
        })

        Livewire.on('showMensajeCurso', event => {
            showMensajeCurso();
        })

        Livewire.on('activateAulaCurso', event => {
            activateAulaCurso();
        })

        Livewire.on('activateDiaCurso', event => {
            activateDiaCurso();
        })

        Livewire.on('activateHoraInicioCurso', event => {
            activateHoraInicioCurso();
        })

        function showTipoCurso() {
            $('#tipoCurso').css("display", "block");
        }

        function showMensajeCurso() {
            $('#mensaje').css("display", "block");
        }

        function activateAulaCurso() {
            $('#aulaCurso').removeAttr('disabled');
            $('#aulaCurso').removeClass('bg-gray-100');
        }

        function activateDiaCurso() {
            $('#diaCurso').removeAttr('disabled');
            $('#diaCurso').removeClass('bg-gray-100');
        }

        function activateHoraInicioCurso() {
            $('#horaInicioCurso').removeAttr('disabled');
            $('#horaInicioCurso').removeClass('bg-gray-100');
        }
    </script>
    @endpush

</div>