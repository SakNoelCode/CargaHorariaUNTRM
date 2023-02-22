<x-app-layout>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if ($cargaHoraria->estado_terminado == 1)
            <div class="pt-4">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden sm:rounded-lg">
                        <div class="p-6 sm:px-20 bg-white border-b">
                            <div class="text-2xl">
                                Horario semanal
                            </div>
                            <div class="mt-3 text-gray-500">
                                El llenado de su horario ya ha sido terminado, descargue los formatos en la opción DOCUMENTOS 
                                de la pestaña anterior.
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if ($cargaHoraria->estado_terminado == 0)

            @livewire('show-asignar-horario-curso',['id'=>$cargaLectiva->id],key([$cargaLectiva->id]))
            <x-jet-section-border />

            @livewire('show-asignar-horario-carga',['id'=>$cargaLectiva->id],key([$cargaLectiva->id]))
            <x-jet-section-border />

            @endif


            @livewire('show-carga-horaria',['id'=>$cargaLectiva->id],key([$cargaLectiva->id]))



        </div>
    </div>

</x-app-layout>