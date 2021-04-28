@extends('admin.layout.main')
@section('content')
<div class="row">
    <div class="card">
        <div class="card-header"><h3>All signs of Toxicity</h3></div>
        <div class="card-body">
            <div class="row">
          
            <div class="col-md-8">
                <form  class="forms-sample" action="{{route('admin.pharm.animalexperimentation.config.update')}}" method="post">
                    {{ csrf_field() }}
                <div class="card-body p-0 table-border-style">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Added By</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($toxicity as $item)
                                <tr>
                                    <td class="font">
                                        <input type="hidden" name="pharm_toxicity_id[]" value="{{$item->id}}">
                                    <input type="text" class="form-control" name="name[]" value="{{$item->name}}">
                                    </td>
                                    <td class="font">
                                        {{\App\Admin::find($item->added_by_id)? \App\Admin::find($item->added_by_id)->full_name:'null'}}
                                    </td>
                                </tr>
                    
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
                <button type="submit" class="btn btn-primary mr-2">Save Changes</button>
                </form>
            </div>
            <div class="col-md-4">
             <form  class="forms-sample" action="{{route('admin.pharm.animalexperimentation.config.create')}}" method="post">
                    {{ csrf_field() }}           
                  <div class="form-group">
                    <label for="exampleInputName1">Name</label>
                    <input type="text" required class="form-control" name="name" placeholder="Name">
                </div>
          
                <button type="submit" class="btn btn-primary mr-2">Save</button>
            </form>
            </div>
        </div>
    </div>
</div>
</div>


@endsection