<div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <x-table>
            <!-----Cabecera---->
            <div class="px-6 py-4 flex items-center">
                <span class="font-bold text-base text-gray-600">Registro de Horario Semanal</span>
            </div>

            @if ($detalle_carga_horaria->count())
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Día
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Horario
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Curso/Carga
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Local - Aula
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tipo
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Horas
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Opcciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($detalle_carga_horaria as $item)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium">
                            @if ($item->dia == 'ueves')
                            jueves
                            @else
                            {{$item->dia}}
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            {{$item->hora_inicio}}&nbsp;{{$item->sistema_horario}}&nbsp; - &nbsp;{{$item->hora_fin}}&nbsp;{{$item->sistema_horario}}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            @if ($item->cargalectiva_carga_id != null)

                            @foreach ($cargas as $c)
                            @if ($c->id == $item->cargalectiva_carga_id)
                            <span class="text-gray-400">{{$c->titulo}}</span>
                            @break
                            @endif
                            @endforeach

                            @endif


                            @if ($item->cargalectiva_curso_id != null)

                            @foreach ($cursos as $c)
                            @if ($c->id == $item->cargalectiva_curso_id)
                            <span class="text-gray-800">{{$c->nombre}}</span>
                            @break
                            @endif
                            @endforeach

                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            {{$item->descripcionLocal}}&nbsp; - &nbsp;{{$item->descripcionAula}}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            {{$item->tipo}}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            @if ($item->hora_inicio_id == $item->hora_fin_id)
                            1
                            <?php
                            $totalHoras++;
                            ?>
                            @else
                            {{$item->hora_fin_id - $item->hora_inicio_id + 1}}
                            <?php
                            $totalHoras += $item->hora_fin_id - $item->hora_inicio_id + 1;
                            ?>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-sm font-medium">
                            <a class="text-red-600 hover:text-red-900 cursor-pointer" wire:click="deleteId({{$item->idDetalle}})">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium" colspan="7">
                            <div class="text-right">
                                <span class="font-bold mr-3">Total de Horas: {{$totalHoras}}</span>
                            </div>
                        </td>

                    </tr>
                </tbody>
            </table>
            @else
            <div class="px-6 py-4">
                <span>No existen un horario en este momento</span>
            </div>
            @endif
        </x-table>
    </div>


    <!----------Modal delete-------------->
    <x-jet-confirmation-modal wire:model='isOpenModalDelete'>
        <x-slot name='title'>
            Eliminar registro de horario
        </x-slot>
        <x-slot name='content'>
            ¿Esta seguro que quiere eliminar el registro de su horario?
        </x-slot>
        <x-slot name='footer'>
            <x-jet-secondary-button class="mr-4" wire:click="close" wire:loading.attr='disabled' wire:target='delete,close'>Cancelar</x-jet-secondary-button>
            <x-jet-button wire:click='delete' wire:loading.attr='disabled' wire:target='delete,close'>Guardar</x-jet-button>
        </x-slot>
    </x-jet-confirmation-modal>

</div>