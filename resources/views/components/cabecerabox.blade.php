<!------BOX Cabecera---->
<div class="pt-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden sm:rounded-lg">
            <div class="p-6 sm:px-20 bg-white border-b">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="max-md:text-center">
                        <div class="text-2xl">
                            {{ $title }}
                        </div>

                        <div class="mt-3 text-gray-500">
                            {{ $descripcion }}
                        </div>
                    </div>
                    <div class="">
                        {{ $botones }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>