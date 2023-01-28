<div>
  @push('css')
  <!---script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script------>

  
  <!---link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" /----->
  @endpush

  <!--------Boton ------->
  <x-jet-button wire:click="$set('isOpen',true)">
    Asignar Curso
  </x-jet-button>

  <x-jet-dialog-modal wire:model='isOpen'>
    <x-slot name='title'>
      Asignar curso
    </x-slot>
    <x-slot name='content'>
      <!--Curso--->
      <div class="mb-4">
        <x-jet-label value='Curso' />
        <select wire:model.defer='curso' class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full">
          <option value="" selected>Seleccione:</option>
          @foreach ($cursos as $item)
          <option value="{{$item->id}}">{{$item->nombre}}</option>
          @endforeach
        </select>
        <x-jet-input-error for='curso' />
      </div>



      <!--select class="js-example-basic-single" name="state">
        <option value="AL">Alabama</option>
        <option value="WY">Wyoming</option>
      </select--->



    </x-slot>
    <x-slot name='footer'>

    </x-slot>
  </x-jet-dialog-modal>

  @push('js')
  <!--script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>
  <script type="text/javascript">
    //Inicializar Select2
  </script------>
  <script>
    /* In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
      $('.js-example-basic-single').select2();
    });*/
  </script>
  @endpush
</div>