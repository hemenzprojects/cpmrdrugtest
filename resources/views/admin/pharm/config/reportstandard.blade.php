@extends('admin.layout.main')
@section('content')
<div class="row">
    <div class="card">
        <div class="card-header"><h3>Default standards for report preparation</h3></div>
        <div class="card-body">
          
            <div class="row">
          
         
                
                    <div class="table-responsive">
                        <table id="" class="table" >

                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Latest Update by</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reportstandards as $item)
                                <tr>
                                    <td class="font">
                                        <input type="hidden" name="pharm_toxicity_id[]" value="{{$item->id}}">
                                    {{$item->description}}
                                    </td>
                                    <td class="font">
                                        {{\App\Admin::find($item->added_by_id)? \App\Admin::find($item->added_by_id)->full_name:'null'}}
                                    </td>
                                    <td>
                                    <a class="btn btn-outline-info"  data-toggle="modal" data-target="#demoModal{{$item->id}}">
                                            Edit template
                                        </a>

                                    </td>
                                </tr>
                                <div class="modal fade" id="demoModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel{{$item->id}}" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog" role="document" >
                                        <div class="modal-content" style="width: 650px">
                                            <form  class="forms-sample" action="{{route('admin.pharm.reportconfig.update')}}" method="post">
                                                {{ csrf_field() }}
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="demoModalLabel">Default Template {{$item->description}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            </div>
                                            <div class="modal-body">
                                             <textarea name="reportdefault" id="summernote{{$item->id}}" cols="30" rows="10" >{{$item->default}}</textarea>
                                            <input type="hidden" name="default_id" value="{{$item->id}}">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" onclick="return confirm('Please comfirm the edited content is correct.')" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
               
                
        </div>
    </div>
</div>
</div>


@endsection