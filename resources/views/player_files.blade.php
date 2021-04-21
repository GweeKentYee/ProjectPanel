@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <h3><a href ="/game/{{$games->id}}">{{$games->game_name}}</a>{{' / '.$players->player_name}}</h3>
            <div style = "text-align:right" class = "pb-1">
                <button class = "btn btn-primary"  data-toggle="modal" data-target="#addfile">Add File</button>
            </div>
            <table class = "table" id = "datatable">
                <thead>
                    <tr>
                        <th>JSON/Txt file</th>
                        <th>Type</th>
                        <th>Api</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            
        </div>
    </div>

    <div class = "modal fade" id = "addfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalCenterTitle">Add File</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <form action="/playerfile/add/{{$players->id}}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="modal-body">
                        <div class="playerfile">
                            <label> JSON/Txt file:</label>
                            <input type = "file" name = "json/txt" id = "playerjson" class = "form-control-file @error('json/txt') is-invalid @enderror" accept = "application/JSON, text/plain"> 
                                @error('json/txt')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <br>
                                <label>Type:</label>
                                <input id="filetype" name = "file_type" type="text" class="form-control @error('file_type') is-invalid @enderror" value = "{{ old('file_type') }}" autocomplete="off" autofocus>
                                @error('file_type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                        <input type="submit" class="btn btn-outline-success" id = "AddSubmit" value="Add">
                    </div>
               </form>
            </div>
         </div>
    </div>

    <div class = "modal fade" id = "url" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalCenterTitle">File URL</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
                <div class="modal-body">
                    <div class="file">
                            <input id="fileURL" name = "file_URL" type="text" class="form-control" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-outline-success" onclick="copy()">Copy URL</button>
                </div>
            </div>
         </div>
    </div>

</div>
@endsection

@section('footer-scripts')

    <script>

    function copy(){
        var copyText = document.getElementById("fileURL");
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");
    }

    </script>

    <script>

        $(document).ready(function () { 
            $('#datatable').DataTable({
                "columnDefs": [{
                    "defaultContent": "-",
                    "targets": "_all"
                }], 
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('api.playerFile', $players->id)}}",
                "columns": [
                    {"data": "JSON_file"},
                    {"data": "type"},
                    {"data": "Api", orderable: false, searchable: false},
                    {"data": "Action", orderable: false, searchable: false}
                ]
            });

        });

        $(document).ready(function () { 
            $('#datatable').on('click', '.delete', function () { 

                var confirmation = confirm('Delete the record?');
    
                if (confirmation == false){
                return false;
                }
            });

            $('#datatable').on('click','.path', function(){
                var modal = $('#url');
                modal.find('#fileURL').val("http://188.166.221.242/api/playerfile/read/" + $(this).data('path'));
            })
        });
    </script>
    @include('scripts.JScript')
@endsection



