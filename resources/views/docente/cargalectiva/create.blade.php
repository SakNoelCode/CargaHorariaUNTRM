<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="pt-4">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden sm:rounded-lg">
                        <div class="p-6 sm:px-20 bg-white border-b">
                            <div class="text-2xl">
                                Declaracion de carga horaria
                            </div>

                            <div class="mt-3 text-gray-500">
                                En esta sección deberá llenar el total de alumnos por curso, además de las horas de los cursos y cargas que se le ha sido asignado.
                                Recuerde que deberá completar el total de horas según su modalidad.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
                                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{$docente->modalidade->descripcion}}: {{$docente->modalidade->horas}} horas</dd>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="text-base font-medium text-gray-500">Periodo</dt>
                                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{$declaracionJurada->periodo->descripcion}}</dd>
                                        </div>
                                    </dl>
                                </x-slot>
                            </x-jet-action-section>
                        </div>
                    </div>
                </div>
            </div>

            <!-----Tabla Cursos Asignados---->
            @livewire('show-carga-lectiva-curso',['id'=>$cargaLectiva->id,'isDocente'=>true],key([$cargaLectiva->id]))

            <!-----Tabla Cargas Asignados---->
            @livewire('show-carga-lectiva-carga',['id'=>$cargaLectiva->id,'isDocente'=>true],key($cargaLectiva->id))

            <!-----Botón Terminar llenado---->
            @livewire('button-terminar-llenado',['id'=>$cargaLectiva->id],key([$cargaLectiva->id]))

        </div>
    </div>
</x-app-layout>