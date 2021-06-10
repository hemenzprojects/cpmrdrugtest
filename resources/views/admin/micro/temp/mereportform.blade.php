<div class="243123" style="display: none">
    <div class="card">
        <div class="card-header d-block">
        </div>
        <div class="card-body p-0 table-border-style">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-warning">
                        <tr>
                            <th>#</th>
                            <th>Pathogen</th>
                            <th>Product IZone</th>
                            <th>Ciprofloxacin IZone</th>
                            <th>Fluconazole IZone</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($MicrobialEfficacyform as $metest)
                        <tr>
                            <td class="font">
                                
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" name="metestform_id[]" value="{{$metest->id}}" class="custom-control-input" checked="true">
    
                                    <span class="custom-control-label">&nbsp;</span>
                                </label> 
                                
                            </td>
                            <td class="font">{{$metest->pathogen}}</td>
                            <input type="hidden" class="form-control" name="pathogen_form_{{$metest->id}}" value="{{$metest->pathogen}}">

                            <td class="font">
                                <input type="text" class="form-control" required name="pi_zoneform_{{$metest->id}}" placeholder="PI Zone" value="{{$metest->pi_zone}}">
                            </td>
                            <td class="font" class="form-control">                                                    
                                <input type="text" class="form-control" name="ci_zoneform_{{$metest->id}}" value="{{$metest->ci_zone}}">

                            </td>
                            <td class="font">
                                <input type="hidden" class="form-control" name="reference_{{$metest->id}}"  value="{{$metest->reference}}">
                                <input type="text" class="form-control" name="fi_zoneform_{{$metest->id}}"  value="{{$metest->fi_zone}}">
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- @include('admin.micro.temp.meconclusioninput')  --}}

    </div>
</div> 