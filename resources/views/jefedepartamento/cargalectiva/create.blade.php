<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if ($cargaLectiva->estado_asignado == 0)
            <!------BOX Cabecera con Botones---->
            <div class="pt-4">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden sm:rounded-lg">
                        <div class="p-6 sm:px-20 bg-white border-b">
                            <div class="grid grid-cols-1 md:grid-cols-2">
                                <div>
                                    <div class="text-2xl">
                                        Crear Asignación para la carga Horaria
                                    </div>

                                    <div class="mt-3 text-gray-500">
                                        En esta sección podrá asignar cursos y cargas para el horario del docente.
                                    </div>
                                </div>
                                <div>
                                    <div class="px-8 py-4 flex">
                                        <div class="mr-1 flex-1">
                                            @livewire('asignar-curso',['id'=>$cargaLectiva->id,'idEscuela'=>$docente->escuela->id],key([$cargaLectiva->id,$docente->escuela->id]))
                                        </div>

                                        <div class="ml-1 flex-1">
                                            @livewire('asignar-carga',['id'=>$cargaLectiva->id],key([$cargaLectiva->id]))
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <!------BOX Cabecera Sin Botones---->
            <div class="pt-4">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden sm:rounded-lg">
                        <div class="p-6 sm:px-20 bg-white border-b">
                            <div class="text-2xl">
                                Ver asignación para la carga horaria
                            </div>

                            <div class="mt-3 text-gray-500">
                                La carga horaria ya ha sido asignada, puede revisar los detalles en esta vista.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif


            <div class="pt-4">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden sm:rounded-lg">
                        <div class="p-6 sm:px-20 bg-white border-b">
                            <x-jet-action-section>
                                <x-slot name='title'>
                                    Datos generales del docente
                                </x-slot>
                                <x-slot name='description'>
                                    Información relevante sobre la situación del profesor y el periodo
                                </x-slot>
                                <x-slot name='content'>
                                    <dl>
                                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="text-base font-medium text-gray-500">Facultad</dt>
                                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{$docente->escuela->facultad->descripcion}}</dd>
                                        </div>
                                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="text-base font-medium text-gray-500">Escuela</dt>
                                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{$docente->escuela->descripcion}}</dd>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="text-base font-medium text-gray-500">Nombre completo</dt>
                                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{$docente->user->name}}</dd>
                                        </div>
                                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="text-base font-medium text-gray-500">Condición</dt>
                                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{$docente->condicione->descripcion}}</dd>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="text-base font-medium text-gray-500">Categoría</dt>
                                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{$docente->categoria->descripcion}}</dd>
                                        </div>
                                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="text-base font-medium text-gray-500">Modalidad</dt>
                                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{$docente->modalidade->descripcion}} : {{$docente->modalidade->horas}} horas semanales</dd>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="text-base font-medium text-gray-500">Periodo</dt>
                                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{$declaracionJurada->periodo->descripcion}}</dd>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="text-base font-medium text-gray-500">Especialidades</dt>
                                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                                @foreach ($docente->especialidades->toArray() as $item)
                                                <p> {{ '- '.ucfirst($item['descripcion'])}} </p>
                                                @endforeach
                                            </dd>
                                        </div>
                                    </dl>
                                </x-slot>
                            </x-jet-action-section>
                        </div>
                    </div>
                </div>
            </div>

            <!-----Tabla Cursos Asignados---->
            @livewire('show-carga-lectiva-curso',['id'=>$cargaLectiva->id,'isDocente'=>false],key([$cargaLectiva->id]))

            <!-----Tabla Cargas Asignadas---->
            @livewire('show-carga-lectiva-carga',['id'=>$cargaLectiva->id,'isDocente'=>false],key([$cargaLectiva->id]))

            <!-----Botón Finalizar Asignación---->
            @if ($cargaLectiva->estado_asignado == 0)
            @livewire('button-finalizar-asignacion',['id'=>$cargaLectiva->id],key([$cargaLectiva->id]))
            @else
            <div class="pt-4">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="bg-gray-100 overflow-hidden sm:rounded-lg">
                        <div class="p-6 sm:px-20 bg-gray-100 border-b flex justify-center">
                            <form action="{{ route('cargasLectivasJefeDepartamento') }}">
                                <x-jet-button>
                                    Volver
                                </x-jet-button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>