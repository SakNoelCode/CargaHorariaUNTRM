<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!------BOX Cabecera Sin Botones---->
            <div class="pt-4">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden sm:rounded-lg">
                        <div class="p-6 sm:px-20 bg-white border-b">
                            <div class="text-2xl">
                                Declaraciones Juradas
                            </div>

                            <div class="mt-3 text-gray-500">
                                En esta sección podrá revisar y gestionar las declaraciones juradas hechas por los docentes.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!---Box Tabla--->
            @livewire('show-declaracion-jurada-jefe')


        </div>

    </div>
</x-app-layout>