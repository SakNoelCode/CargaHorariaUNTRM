<div>

    @push('css')
    <style>

    </style>
    @endpush

    <x-jet-form-section submit='updateCurso' class="mt-4">

        <x-slot name='title'>
            Asignar Horario para el curso
        </x-slot>

        <x-slot name='description'>
            En esta sección va a poder seleccionar un horario para los cursos que se le ha sido asignado.
        </x-slot>

        <x-slot name='form'>

            <!----Curso--->
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for='curso' value='Curso:' />
                <select id="curso" wire:model.defer="idCurso" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                    <option value="null" selected>Seleccione</option>
                    @foreach ($cargaLectivaCurso as $item)
                    <option value="{{$item->id}}">{{$item->nombre}}</option>
                    @endforeach
                </select>
                <x-jet-input-error for='idCurso' class="mt-2" />
            </div>

            <!---Horas Curso--->
            <div class="col-span-6 sm:col-span-4" id="horasCurso">
                <div class="mb-2 text-gray-600">Seleccione la hora que va a completar:</div>
                <div class="flex justify-between">
                    <div class="mr-3">
                        <x-jet-label for='horasTeoria' id="horasTeoriaLabel" value='Horas de Teoría' class="cursor-pointer" />
                        <x-jet-input disabled id="horasTeoria" type='text' class="mt-1 bg-gray-100" wire:model.defer='horasTeoriaCurso' />
                    </div>
                    <div class="ml-3">
                        <x-jet-label for='horasPractica' id="horasPracticaLabel" value='Horas de Práctica' class="cursor-pointer" />
                        <x-jet-input disabled id="horasPractica" type='text' class="mt-1 bg-gray-100" wire:model.defer='horasPracticaCurso' />
                    </div>
                </div>
            </div>

            <!-----Local--->
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for='aula' value='Local - Aula:' />
                <select disabled id="aula" wire:model.defer='idAula' class="bg-gray-100 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                    <option value="" selected>Seleccione</option>
                    @foreach ($aulas as $item)
                    <option value="{{$item->id}}">{{$item->local->descripcion}} - {{$item->descripcion}}</option>
                    @endforeach
                </select>
            </div>

            <!------------Día------------------->
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for='dia' value='Día:' />
                <select disabled id="dia" wire:model.defer='dia' class="bg-gray-100 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                    <option value="" selected>Seleccione</option>
                </select>
            </div>

            <!----------------Hora Inicio------------------>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for='horaInicio' value='Hora Inicio:' />
                <select disabled id="horaInicio" wire:model.defer='horaInicio' class="bg-gray-100 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                    <option value="" selected>Seleccione</option>
                </select>
            </div>

            <!----------------Hora Fin------------------>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for='horaFin' value='Hora Fin:' />
                <select disabled id="horaFin" wire:model.defer='horaFin' class="bg-gray-100 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                    <option value="" selected>Seleccione</option>
                </select>
            </div>

            <!----Curso--->
            <!---div class="col-span-6 sm:col-span-4">
                <x-jet-label for='cursoExample' value='Seleccione un curso:' />
                <x-jet-input id="cursoExample" type='text' class="mt-1 block w-full" wire:model.defer="nameCurso" autocomplete="curso" />
                <x-jet-input-error for='nameCurso' class="mt-2" />
            </div---------------------->

        </x-slot>

        <x-slot name='actions'>

            <x-jet-action-message class="mr-3" on='saved'>Guardando</x-jet-action-message>

            <x-jet-button wire:loading.attr="disabled">Guardar</x-jet-button>

        </x-slot>

    </x-jet-form-section>

    @push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
    <script>
        //Variables globales
        elementHorasCurso = document.getElementById('horasCurso');
        let horaSelected = '';

        let diasDeLaSemana = [{
                text: 'Lunes',
                id: '1'
            },
            {
                text: 'Martes',
                id: '2'
            },
            {
                text: 'Miércoles',
                id: '3'
            },
            {
                text: 'Jueves',
                id: '4'
            },
            {
                text: 'Viernes',
                id: '5'
            },
        ]

        $(document).ready(function() {

            hideHorasCurso();

            $("#curso").change(function() {
                var selectedOption = $(this).val();
                if (selectedOption != 'null') {
                    //console.log(selectedOption);
                    Livewire.emit('CursoSeleccionado', selectedOption)
                    showHorasCurso();
                } else {
                    hideHorasCurso();
                }
            });

            $("#horasTeoriaLabel").click(function() {
                $('#horasTeoria').addClass('bg-green-300');
                $('#horasPractica').removeClass('bg-green-300');
                activateInputAula();
                activateInputDia();
                llenarDias();
                horaSelected = 'teorica';
            });

            $("#horasPracticaLabel").click(function() {
                $('#horasPractica').addClass('bg-green-300');
                $('#horasTeoria').removeClass('bg-green-300');
                activateInputAula();
                activateInputDia();
                llenarDias();
                horaSelected = 'practica';
            });

        });

        function showHorasCurso() {
            elementHorasCurso.style.display = 'block';
        }

        function hideHorasCurso() {
            elementHorasCurso.style.display = 'none';
        }

        function activateInputAula() {
            $('#aula').removeAttr('disabled');
            $('#aula').removeClass('bg-gray-100');
        }

        function activateInputDia() {
            $('#dia').removeAttr('disabled');
            $('#dia').removeClass('bg-gray-100');
        }

        function llenarDias() {
            $.each(diasDeLaSemana, function(index, value) {
                $("#dia").append($("<option>", {
                    value: value.id,
                    text: value.text
                }));
            });
        }
    </script>
    @endpush

</div>