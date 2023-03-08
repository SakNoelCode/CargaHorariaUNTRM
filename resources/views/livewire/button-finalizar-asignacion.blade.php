<div>
    <div class="pt-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-100 overflow-hidden sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-gray-100 border-b flex justify-center">
                    <x-jet-button wire:click="$set('isOpenModalConfirm',true)">
                        Finalizar asignación
                    </x-jet-button>
                </div>
            </div>
        </div>
    </div>

    <x-jet-confirmation-modal wire:model='isOpenModalConfirm'>
        <x-slot name='title'>
            Finalizar asignación
        </x-slot>
        <x-slot name='content'>
            ¿Esta seguro que quiere finalizar la asignación? No se podrán modificar los cursos ni las cargas más adelante.
        </x-slot>
        <x-slot name='footer'>
            <x-jet-secondary-button class="mr-4" wire:click="close" wire:loading.attr='disabled' wire:target='confirm,close'>Cancelar</x-jet-secondary-button>
            <x-jet-button wire:click='confirm' wire:loading.attr='disabled' wire:target='confirm,close'>Guardar</x-jet-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>