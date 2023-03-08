<div>
  @push('css')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <style>
    /**Estilos personalizados para la caja se select2 */
    .select2-container .select2-selection {
      height: 35px;
    }
  </style>
  @endpush

  <!--------Boton ------->
  <x-jet-button wire:click="$set('isOpen',true)">
    Asignar Curso
  </x-jet-button>

  <x-jet-dialog-modal wire:model='isOpen' id="modalCurso">
    <x-slot name='title'>
      Asignar curso
    </x-slot>
    <x-slot name='content'>

      <!--Curso--->
      <div class="mb-4" wire:ignore>
        <x-jet-label value='Curso' />
        <select id='select2Curso'>
          <option value=""></option>
          @foreach ($cursos as $item)
          <option value="{{$item->id}}">{{$item->nombre}}</option>
          @endforeach
        </select>
      </div>

      <!--Ciclo--->
      <div class="mb-4" wire:ignore>
        <x-jet-label value='Ciclo' />
        <select class='select2Ciclo'>
          <option value=""></option>
          @foreach ($ciclos as $item)
          <option value="{{$item->id}}">{{$item->descripcion}}</option>
          @endforeach
        </select>
      </div>

      <!--Sección--->
      <div class="mb-4" wire:ignore>
        <x-jet-label value='Seccion' />
        <select class='select2Seccion'>
          <option value=""></option>
          @foreach ($secciones as $item)
          <option value="{{$item->id}}">{{$item->descripcion}}</option>
          @endforeach
        </select>
      </div>


    </x-slot>

    <x-slot name='footer'>
      <x-jet-action-message class="mr-4" wire:loading.delay on='save'>Cargando.....</x-jet-action-message>
      <x-jet-secondary-button class="mr-4" wire:click='closeModal' wire:loading.attr='disabled' wire:target='save,closeModal'>Cerrar</x-jet-secondary-button>
      <x-jet-button wire:click='save' wire:loading.attr='disabled' wire:target='save,closeModal'>Guardar</x-jet-button>
    </x-slot>

  </x-jet-dialog-modal>

  @push('js')
  <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/i18n/es.js"></script>
  <script>
    //Funcion para el select Curso
    $(document).ready(function() {
      $('#select2Curso').on('change', function(e) {
        Livewire.emit('listenerReferenceCurso',
          $('#select2Curso').select2("val"));
        //console.log($('#select2Curso').select2('val'));
      });
    });

    //Funcion para el select Ciclo
    $(document).ready(function() {
      $('.select2Ciclo').select2({
        width: '100%',
        placeholder: "Seleccione:",
        language: "es"
      });
      $('.select2Ciclo').on('change', function(e) {
        Livewire.emit('listenerReferenceCiclo',
          $('.select2Ciclo').select2("val"));
      });
    });

    //Funcion para el select Seccion
    $(document).ready(function() {
      $('.select2Seccion').select2({
        width: '100%',
        placeholder: "Seleccione:",
        language: "es"
      });
      $('.select2Seccion').on('change', function(e) {
        Livewire.emit('listenerReferenceSeccion',
          $('.select2Seccion').select2("val"));
      });
    });



    document.addEventListener('livewire:load', function(event) {

      //escuchar el evento OpenMoal de la clase
      @this.on('openModal', function() {

        let cursos = [];

        $.each(@this.arrayCursos, function(key, value) {
          cursos.push({
            id: key,
            text: value
          });
        });

        //Inicializacion del select Curso
        $('#select2Curso')
          .empty()
          .append('<option value=""></option>')
          .select2({
            width: '100%',
            placeholder: "Seleccione:",
            minimumInputLength: 3,
            language: "es",
            data: cursos
          });

        //Limpieza de selects
        $("#select2Curso").val(null).trigger('change');
        $(".select2Ciclo").val(null).trigger('change');
        $(".select2Seccion").val(null).trigger('change');

      })
    })
  </script>
  @endpush
</div>