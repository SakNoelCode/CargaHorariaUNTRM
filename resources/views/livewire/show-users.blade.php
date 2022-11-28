<div>

    <div class="pt-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b">
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <div>
                            <div class="text-2xl">
                                Usuarios
                            </div>

                            <div class="mt-3 text-gray-500">
                                En esta sección podrá gestionar a los docentes y jefes de
                                departamentos.
                            </div>
                        </div>
                        <div>
                            <div class="px-6 py-4 flex">
                                <div class="mr-4 flex-1">
                                    @livewire('create-docente')
                                </div>

                                <div class="ml-4 flex-1">
                                    @livewire('create-jefe-departamento')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <x-table>

            <!-----Cabecera Tabla----->
            <div class="px-6 py-4 flex items-center">

                <!-----Mostrar registros----->
                <span class="mr-2">Mostrar</span>
                <select wire:model='numberOfRecords' class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="100">100</option>
                </select>
                <span class="ml-2">registros</span>

                <div class="ml-4" wire:loading.flex wire:target='numberOfRecords'>cargando...</div>

                <!-----Búsqueda----->
                <x-jet-input class="w-full ml-8" type='text' wire:model='search' placeholder="Busque mediante nombre o correo"></x-jet-input>

            </div>

            @if ($users->count())
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nombre
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Identificación
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Rol
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($users as $user)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    @if ($user->profile_photo_path)
                                    <img class="h-10 w-10 rounded-full" src="/storage/{{$user->profile_photo_path }}" alt="{{ $user->name }}" />
                                    @else
                                    <?php
                                    $name = substr($user->name, 0, 1);
                                    ?>
                                    <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{$name}}&color=7F9CF5&background=EBF4FF" alt={{$name}} />
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{$user->name}}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{$user->email}}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">DNI</div>
                            <div class="text-sm text-gray-500">{{$user->dni}}</div>
                        </td>
                        <td class="px-6 py-4">
                            @if ($user->status != 'ACTIVO')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-300">
                                {{$user->status}}
                            </span>
                            @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100">
                                {{$user->status}}
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{$user->descripcion}}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            @if($user->descripcion=="docente")
                            @livewire('edit-docente',['id'=>$user->id],key($user->id))
                            @endif
                            @if ($user->descripcion=="jefe departamento")
                            @livewire('edit-jefe-departamento',['id'=>$user->id],key($user->id))
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="px-6 py-4">
                <span>No existen resultados que coinciden con su busqueda!!</span>
            </div>
            @endif

            @if ($users->hasPages())
            <div class="px-6 py-4">
                {{ $users->links() }}
            </div>
            @endif

        </x-table>

    </div>

</div>