<div>
    <a class="text-indigo-600 hover:text-indigo-900 cursor-pointer" wire:click="$set('isOpen',true)">Ver</a>


    <x-jet-dialog-modal wire:model='isOpen'>
        <x-slot name='title'>
            Editar especialidades del docente
        </x-slot>

        <x-slot name='content'>

            <div class="mb-4">
                <x-jet-label class="font-bold" value='Docente: {{$docente_name}}' />
            </div>

            <!----Especialidades actuales--->
            <div class="mb-4">
                <x-jet-label class="font-bold" value='Especialidades actuales: ' />
                <ol class="list-decimal list-inside">
                    @foreach ($especialidadesActuales as $i)
                    <li>{{$i}}</li>
                    @endforeach
                </ol>
            </div>

            <div class="mb-4">
                <x-jet-label class="font-semibold" value='Seleccionar las nuevas especialidades para el docente: 
                (Nota:las especialidades seleccionadas reemplazarán a las actuales, sólo puedes seleccionar 3)' />
                @foreach ($especialidades as $item)
                <label for="{{$item->id}}" class="inline-flex items-center">
                    <x-jet-checkbox wire:model.defer='nuevasEspecialidades' value='{{$item->id}}' />
                    <span class="ml-2 text-gray-700">{{$item->descripcion}}</span>
                </label>
                <br>
                @endforeach
                <x-jet-input-error for='nuevasEspecialidades' />
            </div>

        </x-slot>

        <x-slot name='footer'>
            <x-jet-action-message class="mr-4" wire:loading on='save'>Cargando....</x-jet-action-message>
            <x-jet-secondary-button class="mr-4" wire:click='closeModal' wire:loading.attr='disabled' wire:target='save,closeModal'>Cancelar</x-jet-secondary-button>
            <x-jet-button wire:click='save' wire:loading.attr='disabled' wire:target='save,closeModal'>Actualizar</x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>