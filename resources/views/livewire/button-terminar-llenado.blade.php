<div>

    <div class="pt-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-100 overflow-hidden sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-gray-100 border-b flex">
                    <x-jet-button style="margin: auto;" wire:click="$set('isOpenModalConfirm',true)" wire:loading.attr='disabled'>
                        Terminar llenado
                    </x-jet-button>
                </div>
            </div>
        </div>
    </div>

    <x-jet-confirmation-modal wire:model='isOpenModalConfirm'>
        <x-slot name='title'>
            Terminar llenado
        </x-slot>
        <x-slot name='content'>
            ¿Esta seguro que quiere terminar el llenado? No se podrán aplicar más cambios depués de esta acción.
        </x-slot>
        <x-slot name='footer'>
            <x-jet-secondary-button class="mr-4" wire:click="close" wire:loading.attr='disabled' wire:target='confirm,close'>Cancelar</x-jet-secondary-button>
            <x-jet-button wire:click='confirm' wire:loading.attr='disabled' wire:target='confirm,close'>Guardar</x-jet-button>
        </x-slot>
    </x-jet-confirmation-modal>

</div>