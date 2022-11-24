<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!------BOX Cabecera---->
            <x-cabecerabox>
                <x-slot name='title'>
                    Declaraciones Juradas
                </x-slot>
                <x-slot name='descripcion'>
                    En esta sección podrá generar y gestionar sus declaraciones juradas.
                </x-slot>
                <x-slot name='botones'>
                    <div class="px-6 py-4 flex justify-end">
                        @livewire('create-declaracion-jurada')
                    </div>
                </x-slot>
            </x-cabecerabox>

            <!---Box Tabla--->
            @livewire('show-declaracion-jurada')

        </div>

    </div>
</x-app-layout>