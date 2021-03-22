<h6 style="margin-top: 2%">C. {{\App\PhytoTestConducted::find(3)->name}}</h6>
<input type="hidden" name="phyto_testconducted_3" value="{{\App\PhytoTestConducted::find(3)->id}}">
<div class="form-group">
  
    <select class="form-control select2" name="chemicalconst[]" multiple="multiple">
        
        @foreach ($phyto_chemicalconstsreport as $pchemconst_item)
        @foreach ($phyto_chemicalconsts->where('id',$pchemconst_item->name) as $item)
        <option value="{{$item->id}}" selected>{{$item->name}}</option>
        @endforeach
       @endforeach

        @foreach ($phyto_chemicalconsts as $item)
        <option value="{{$item->id}}">{{$item->name}}</option>  
        @endforeach
        <p> 
           @error('chemicalconst')
           <small style="margin:15px" class="form-text text-danger" role="alert">
               <strong>{{$message}}</strong>
           </small>
           @enderror
        </p>
    </select>

</div>