<x-app-layout>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!--div class="pt-4">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden sm:rounded-lg">
                        <div class="p-6 sm:px-20 bg-white border-b">
                            <div class="text-2xl">
                                Asignación de Horario semanal
                            </div>
                            <div class="mt-3 text-gray-500">
                                En esta sección deberá registrar un horario para sus cursos y cargas.
                            </div>

                        </div>
                    </div>
                </div>
            </div---->

            @livewire('show-carga-horaria',['id'=>$cargaLectiva->id],key([$cargaLectiva->id]))

        
            <x-jet-section-border />

            @livewire('show-asignar-horario-carga',['id'=>$cargaLectiva->id],key([$cargaLectiva->id]))

        </div>
    </div>

</x-app-layout>