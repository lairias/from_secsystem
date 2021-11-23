@extends('adminlte::page')

@section('title', 'Repaldo y Recuperacion')

@section('content_header')
<div class="container-fluid">
    <div class="row">
        <div class="col-6">
            <h1>Repaldo y Recuperacion</h1>
        </div>
        <div class="col-6">
            @if ($errors->any())
            @foreach ($errors->all() as $error)
          <script>

          </script>
            @endforeach
            @endif
        </div>
    </div>
</div>

@stop

@section('content')
<!CONTENIDO************>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-12">

                    <!-- general form elements -->
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Respaldo</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputFile">Realizar Repaldo</label>
                                <div class="input-group">
                                    <a href="http://18.117.164.59:3000/api/respaldo">
                                        <button id="generarDUMP" class="btn btn-warning swalDefaultSuccess">
                                            Descargar</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                    <div id="mensaje" class="alert alert-danger d-none" role="alert">
                        Seleccione unar archivo base de datos
                    </div>
                    <!-- general form elements -->
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Recuperacion</h3>
                        </div>
                        <!-- /.card-header -->

                        <form id='formSQL' method="POST" action="http://18.117.164.59:3000/api/respaldo/upload" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputFile">Subir Archivo</label>

                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input @error('File_SQL') is-invalid @enderror  " name="file" id="File_SQL">
                                            <label class="custom-file-label" for="exampleInputFile">Escoger Archivo</label>
                                        </div>

                                        <div class="input-group mt-2">
                                            <button id="Import-btn" class="btn btn-warning swalDefaultSuccess2" type="submit" disabled>
                                                subir</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- right col -->
        </div>
        <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->


        <script>
            const btn = document.querySelector("#Import-btn");
            const mensaje = document.querySelector("#mensaje")

            const formulario = document.querySelector("#formSQL");


            formulario.addEventListener("change", e => {
                const resultado = getFileExtension1(e.target.value);

                function getFileExtension1(filename) {
                    return (/[.]/.exec(filename)) ? /[^.]+$/.exec(filename)[0] : undefined;
                }
                if (resultado == "sql") {
                    btn.disabled = false;
                } else {
                    btn.disabled = true;
                    mensaje.classList.remove("d-none")
                    setTimeout(() => {
                        mensaje.classList.add("d-none")

                    }, 3000)
                }

            })
        </script>
    </section>
    <!-- /.content -->
    <!TERMINA CONTENIDO************>

@stop

@section('css')

        <!-- DataTables -->
        <link rel="stylesheet" href="{{  asset('vendor/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
        <link rel="stylesheet" href="{{  asset('vendor/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
        <link rel="stylesheet" href="{{  asset('vendor/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
        <!-- daterange picker -->
        <link rel="stylesheet" href="{{  asset('vendor/daterangepicker/daterangepicker.css')}}">
        <!-- Select2 -->
        <link rel="stylesheet" href="{{  asset('vendor/select2/css/select2.min.css')}}">
        <!-- SweetAlert2 -->
        <link rel="stylesheet" href="{{  asset('vendor/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
        <!-- Toastr -->
        <link rel="stylesheet" href="{{  asset('vendor/toastr/toastr.min.css')}}">

        <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">

@stop
@section('js')

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>

        <!-- include FilePond library -->
        <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>

        <!-- include FilePond plugins -->
        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>

        <!-- include FilePond jQuery adapter -->
        <script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>

        <script>
            $(function() {

                // First register any plugins
                $.fn.filepond.registerPlugin(FilePondPluginImagePreview);

                // Turn input element into a pond
                $('.my-pond').filepond();

                // Set allowMultiple property to true
                $('.my-pond').filepond('allowMultiple', true);

                // Listen for addfile event
                $('.my-pond').on('FilePond:addfile', function(e) {
                    console.log('file added event', e);
                });

                // Manually add a file using the addfile method
                $('.my-pond').first().filepond('addFile', 'index.html').then(function(file) {
                    console.log('file added', file);
                });

            });
        </script>

        <script src="http://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Page specific script -->
        <!-- <script>
            //Constantes de ELementos
            const subir_archivo = document.querySelector('#File_SQL');

            //Eventos
            subir_archivo.addEventListener('change', e => {
                alert('funciona')
                const archivo = e.target.files;
                const data = new FormData();
                // console.log(archivo)
                alert('aleeta')
                data.append('archivo', archivo[0]);

                console.log(data.append('archivo', archivo[0]))

                alert('antes del debugger');
                fetch('http://18.117.164.59:3000/api/respaldo/upload', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: {
                        file: data
                    },
                }).then(response => response.json())
            });
            // const input = document.querySelector('#File_SQL');
            // input.addEventListener('change', (e) => {

            //     const fd = new FormData();

            //     // add all selected files
            //     e.target.files.forEach((file) => {
            //         fd.append(e.target.name, file, file.name);
            //         console.log(e.target.name, file, file.name);
            //     });

            //     // create the request
            //     const xhr = new XMLHttpRequest();
            //     xhr.onload = () => {
            //         if (xhr.status >= 200 && xhr.status < 300) {
            //             // we done!
            //         }
            //     };

            //     // path to server would be where you'd normally post the form to
            //     xhr.open('POST', 'http://18.117.164.59:3000/api/respaldo/upload');
            //     xhr.send(fd);
            // });
        </script> -->

        <!-- DataTables  & Plugins -->
        <script src="{{  asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{  asset('vendor/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
        <script src="{{  asset('vendor/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
        <script src="{{  asset('vendor/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
        <script src="{{  asset('vendor/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
        <script src="{{  asset('vendor/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
        <script src="{{  asset('vendor/jszip/jszip.min.js')}}"></script>
        <script src="{{  asset('vendor/pdfmake/pdfmake.min.js')}}"></script>
        <script src="{{  asset('vendor/pdfmake/vfs_fonts.js')}}"></script>
        <script src="{{  asset('vendor/datatables-buttons/js/buttons.html5.min.js')}}"></script>
        <script src="{{  asset('vendor/datatables-buttons/js/buttons.print.min.js')}}"></script>
        <script src="{{  asset('vendor/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
        <!-- Select2 -->
        <script src="{{  asset('vendor/select2/js/select2.full.min.js')}}"></script>
        <!-- InputMask -->
        <script src="{{  asset('vendor/moment/moment.min.js')}}"></script>
        <script src="{{  asset('vendor/inputmask/jquery.inputmask.min.js')}}"></script>
        <!-- date-range-picker -->
        <script src="{{  asset('vendor/daterangepicker/daterangepicker.js')}}"></script>
        <!-- Tempusdominus Bootstrap 4 -->
        <script src="{{  asset('vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
        <!-- Bootstrap Switch -->
        <script src="{{  asset('vendor/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
        <!-- dropzonejs -->
        <script src="{{  asset('vendor/dropzone/min/dropzone.min.js')}}"></script>
        <!-- SweetAlert2 -->
        <script src="{{  asset('vendor/sweetalert2/sweetalert2.min.js')}}"></script>
        <!-- Toastr -->
        <script src="{{  asset('vendor/toastr/toastr.min.js')}}"></script>

        <!-- Page specific script -->
        <script>
            $(function() {
                $("#example1").DataTable({
                    "responsive": true,
                    "lengthChange": true,
                    "autoWidth": false,
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                $("#example2").DataTable({
                    "responsive": true, "lengthChange": true, "autoWidth": false,
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                    }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
                });
        </script>

        <script>
            $(function() {
                //Initialize Select2 Elements
                $('.select2').select2()

                //Initialize Select2 Elements
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                })

                //Datemask dd/mm/yyyy
                $('#datemask').inputmask('yyyy/mm/dd', {
                    'placeholder': 'yyyy/mm/dd'
                })
                //Datemask2 mm/dd/yyyy
                $('#datemask2').inputmask('mm/dd/yyyy', {
                    'placeholder': 'mm/dd/yyyy'
                })
                //Money Euro
                $('[data-mask]').inputmask()

                //Date picker
                $('#reservationdate').datetimepicker({
                    format: 'L'
                });

            })
        </script>

        <script>
            $(function() {
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });

                $('.swalDefaultSuccess').click(function() {
                    Toast.fire({
                        icon: 'success',
                        title: 'Generando Copia de la base de datos.'
                    })
                });

                $('.swalDefaultSuccess2').click(function() {
                    Toast.fire({
                        icon: 'success',
                        title: 'Generando restauracion de la base de datos.'
                    })
                });

            });
        </script>


@stop
