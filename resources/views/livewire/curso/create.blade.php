<div>
    <!--------Boton ------->
    <x-jet-button wire:click="openModal" wire:loading.attr='disabled' wire:target='openModal'>
        Crear nuevo Curso
    </x-jet-button>

    <x-jet-dialog-modal wire:model='isOpen'>
        <x-slot name='title'>
            Crear nuevo curso
        </x-slot>

        <x-slot name='content'>
            <div class="mb-4">
                <x-jet-label for='nombreCurso' value='Nombre:' />
                <x-jet-input id="nombreCurso" type='text' class="w-full" wire:model.defer='nombreCurso' placeholder='Ingrese un nombre para el curso' />
                <x-jet-input-error for='nombreCurso' />
            </div>

            <div class="mb-4">
                <x-jet-label for='tipoCurso' value='Tipo:' />
                <select id="tipoCurso" wire:model.defer='tipoCurso' class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full">
                    <option value="" selected>Seleccione:</option>
                    <option value="O">Obligatorio</option>
                    <option value="E">Elegible</option>
                </select>
                <x-jet-input-error for='tipoCurso' />
            </div>

            <div class="mb-4">
                <x-jet-label for='cicloCurso' value='Ciclo:' />
                <select id="cicloCurso" wire:model.defer='cicloCurso' class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full">
                    <option value="" selected>Seleccione:</option>
                    @foreach ($ciclos as $ciclo)
                    <option value="{{$ciclo->id}}">{{$ciclo->descripcion}}</option>
                    @endforeach
                </select>
                <x-jet-input-error for='cicloCurso' />
            </div>

            <div class="mb-4">
                <x-jet-label for='especialidadCurso' value='Especialidad:' />
                <select id="especialidadCurso" wire:model.defer='especialidadCurso' class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full">
                    <option value="" selected>Seleccione:</option>
                    @foreach ($especialidades as $item)
                    <option value="{{$item->id}}">{{$item->descripcion}}</option>
                    @endforeach
                </select>
                <x-jet-input-error for='especialidadCurso' />
            </div>

        </x-slot>

        <x-slot name='footer'>
            <x-jet-action-message class="mr-4" wire:loading on='save'>Cargando....</x-jet-action-message>
            <x-jet-secondary-button class="mr-4" wire:click="closeModal" wire:loading.attr='disabled' wire:target='save,closeModal'>Cancelar</x-jet-secondary-button>
            <x-jet-button wire:click='save' wire:loading.attr='disabled' wire:target='save,closeModal'>Guardar</x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>