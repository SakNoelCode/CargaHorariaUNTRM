<x-app-layout>

    @if(session('success'))
    <script>
        Swal.fire(
            'Operación exitosa',
            'Asignación finalizada',
            'success'
        )
    </script>
    @endif

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!------BOX Cabecera Sin Botones---->
            <div class="pt-4">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden sm:rounded-lg">
                        <div class="p-6 sm:px-20 bg-white border-b">
                            <div class="text-2xl">
                                Carga Horaria
                            </div>

                            <div class="mt-3 text-gray-500">
                                En esta sección podrá completar algunos datos sobre los cursos y cargas que se le ha sido asignado.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!---Box Tabla--->
            @livewire('show-carga-horaria-docente')


        </div>
    </div>
</x-app-layout>