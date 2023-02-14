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
                <select id="tipo" wire:model="tipo" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                    <option value="" selected>Seleccione</option>
                    <option value="teorico">Teoricas</option>
                    <option value="practico">Practicas</option>
                </select>
                <x-jet-input-error for='tipo' class="mt-2" />
            </div>

            <!---div id="hola" class="col-span-6 sm:col-span-4">
                <div class="mb-2 text-gray-600">Completar Horas Teóricas:</div>
            </div--->
            <div id="mensaje" class="col-span-6 sm:col-span-4">
                @if ($tipo == 'teorico')
                <div class="mb-2 text-gray-600">Horas Teoría: {{$horasTeoriaCurso}}</div>
                @endif
                @if ($tipo == 'practico')
                <div class="mb-2 text-gray-600">Horas Practica: {{$horasPracticaCurso}}</div>
                @endif
            </div>


            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for='aula' value='Local - Aula:' />
                <select id="aula" wire:model='idAula' class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                    <option value="" selected>Seleccione</option>
                    @foreach ($aulas as $item)
                    <option value="{{$item->id}}">{{$item->local->descripcion}} - {{$item->descripcion}}</option>
                    @endforeach
                </select>
                <x-jet-input-error for='idAula' class="mt-2" />
            </div>


            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for='dia' value='Día:' />
                <select id="dia" wire:model='dia' class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                    <option value="" selected>Seleccione</option>
                    @foreach ($dias as $item)
                    <option value="{{$item['value']}}">{{$item['name']}}</option>
                    @endforeach
                </select>
                <x-jet-input-error for='dia' class="mt-2" />
            </div>


            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for='horaInicio' value='Hora Inicio:' />
                <select id="horaInicio" wire:model='horaInicio' class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                    <option value="" selected>Seleccione</option>
                    @foreach ($horas as $item)
                    <option value="{{$item->id}}">{{$item->hora_inicio}}&nbsp;{{$item->sistema_horario}}</option>
                    @endforeach
                </select>
                <x-jet-input-error for='horaInicio' class="mt-2" />
            </div>


            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for='horaFinal' value='Hora Fin:' />
                <select disabled id="horaFinal" wire:model='horaFinal' class="bg-gray-100 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                    <option value="" selected>Automático</option>
                    @foreach ($horas as $item)
                    <option value="{{$item->id}}">{{$item->hora_fin}}&nbsp;{{$item->sistema_horario}}</option>
                    @endforeach
                </select>
                <x-jet-input-error for='horaFinal' class="mt-2" />
            </div>


        </x-slot>


        <x-slot name='actions'>

            <x-jet-action-message class="mr-3" on='saved'>Guardando</x-jet-action-message>

            <x-jet-button id="btn_submit" wire:loading.attr="disabled">Guardar</x-jet-button>

        </x-slot>

    </x-jet-form-section>

    @push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
    <!---script>
        /*
        elementHorasCurso = document.getElementById('horasCurso');
        let horaSelected = '';
        let valuehoraSelected;

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
                    Livewire.emit('refreshAula')
                    Livewire.emit('refreshHoraInicio')
                    showHorasCurso();
                } else {
                    hideHorasCurso();
                    desactivateInputAula();
                    desactivateInputDia();
                    desactivateHoraInicio();
                }
            });

            $("#horasTeoriaLabel").click(function() {
                $('#horasTeoria').addClass('bg-green-300');
                $('#horasPractica').removeClass('bg-green-300');
                activateInputAula();
                //resetInputDia();
                resetHoraInicio();
                resetHoraFin();
                desactivateInputDia()
                desactivateHoraInicio();
                desactivateSubmit();
                llenarDias();
                horaSelected = 'teorica';
                valuehoraSelected = $('#horasTeoria').val();
            });

            $("#horasPracticaLabel").click(function() {
                $('#horasPractica').addClass('bg-green-300');
                $('#horasTeoria').removeClass('bg-green-300');
                activateInputAula();
                //resetInputDia();
                resetHoraInicio();
                resetHoraFin();
                desactivateInputDia();
                desactivateHoraInicio();
                desactivateSubmit();
                llenarDias();
                horaSelected = 'practica';
                valuehoraSelected = $('#horasPractica').val();
            });

            $("#aula").change(function() {
                var selectedOption = $(this).val();
                activateInputDia();
                resetHoraFin();
                desactivateSubmit();
            });


            $("#dia").change(function() {
                var selectedOption = $(this).val();
                activateHoraInicio();
                resetHoraFin();
                desactivateSubmit();
            });


            $("#horaInicio").change(function() {
                var selectedOption = $(this).val();
                calculateHoraFinal(selectedOption);
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
            resetInputAula();
        }

        function desactivateInputAula() {
            $('#aula').attr('disabled', 'disabled');
            $('#aula').addClass('bg-gray-100');
            resetInputAula();
        }

        function resetInputAula() {
            $('#aula').val('null');
        }

        function activateInputDia() {
            $('#dia').removeAttr('disabled');
            $('#dia').removeClass('bg-gray-100');
            resetInputDia();
        }

        function desactivateInputDia() {
            $('#dia').attr('disabled', 'disabled');
            $('#dia').addClass('bg-gray-100');
            resetInputDia();
        }

        function resetInputDia() {
            $('#dia').val('null');
        }

        function activateHoraInicio() {
            $('#horaInicio').removeAttr('disabled');
            $('#horaInicio').removeClass('bg-gray-100');
            resetHoraInicio();
        }

        function desactivateHoraInicio() {
            $('#horaInicio').attr('disabled', 'disabled');
            $('#horaInicio').addClass('bg-gray-100');
            resetHoraInicio();
        }

        function resetHoraInicio() {
            $('#horaInicio').val('null');
        }

        function resetHoraFin() {
            $('#horaFin').val('null');
        }

        function activateSubmit() {
            $('#btn_submit').removeAttr('disabled');
        }

        function desactivateSubmit() {
            $('#btn_submit').attr('disabled', 'disabled');
        }

        function llenarDias() {

            if ($("#dia").children().length == 1) {
                //console.log('Select Vacio');
                $.each(diasDeLaSemana, function(index, value) {
                    $("#dia").append($("<option>", {
                        value: value.id,
                        text: value.text
                    }));
                });
            }
        }

        function calculateHoraFinal(selectedOption) {
            let cantHoras = parseInt(valuehoraSelected);
            let horaSeleccionada = parseInt(selectedOption);

            //Se resta -1 para compensar que tiene el valor del ID es 1
            $('#horaFin').val((cantHoras + horaSeleccionada - 1));
            //console.log($('#aula').val());
            activateSubmit();

        }*/
    </script----->

    <script>
        //Escuhar evento que vienen del modelo
        Livewire.on('showTipoCurso', event => {
            showTipoCurso();
        })

        Livewire.on('hideTipoCurso', event => {
            hideTipoCurso();
        })

        Livewire.on('showMensaje', event => {
            showMensaje();
        })

        Livewire.on('hideMensaje', event => {
            hideMensaje();
        })

        function hideTipoCurso() {
            $('#tipoCurso').css("display", "none");
        }

        function showTipoCurso() {
            $('#tipoCurso').css("display", "block");
        }

        function hideMensaje() {
            $('#mensaje').css("display", "none");
        }

        function showMensaje() {
            $('#mensaje').css("display", "block");
        }
    </script>
    @endpush

</div>