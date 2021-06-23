
    <div class=""> 
        <h4 class="font" style="font-size:18px; margin:20px; margin-top:15px"><strong> RESULTS: </strong></h4>

        <p class="font" style="font-size:14px; margin:20px; margin-top:10px"> Table Showing Results of {{\App\PharmTestConducted::find(1)->name}} on {{$pharmreports->code}} in 
            {{$pharm_finalreports->pharm_animal_model}}
        </p>
    </div>

    <table class="table">
        <tbody>
            <tr>
              

                <td class="font"><strong>Animal Model</strong></td>
                <td class="font">
                <input type="text" required class="" name="animal_model" value="{{$pharm_finalreports->pharm_animal_model}}" placeholder="None">
                </td>
            </tr>
            <tr>
            <td class="font"><strong>No. of Animals</strong></td>
                <td class="font">
                    <input type="text" required class="" name="num_of_animals" value="{{$pharm_finalreports->num_of_animals}}" placeholder="None">
                </td>
            </tr>
            <tr>
                <td class="font"><strong>Sex</strong></td> 
                <td  class="font">
                    <input type="text" required class="" name="animal_sex" value="{{$pharm_finalreports->animal_sex}}" placeholder="None">

            </td>
            </tr>
            <tr>
                <td class="font"><strong>No. of Groups</strong></td> 
                <td  class="font">
                    <input type="text" required class="" name="no_group" value="{{$pharm_finalreports->no_group}}" placeholder="None">

                </td>
            </tr>
            <tr>
                <td class="font"><strong>Route of Administration</strong></td> 
                <td  class="font">
                    <input type="text" required class="" name="method_of_admin" value="{{$pharm_finalreports->method_of_admin}}" placeholder="None">

                </td>
            </tr>
            <tr>
                <td class="font"><strong>Formulation</strong></td> 
                <td  class="font"><input type="text" required name="formulation" value="{{$pharm_finalreports->formulation}}" placeholder="None"></td>
                
            </tr>
            <tr>
                <td class="font"><strong>Preparation</strong></td> 
            <td  class="font">
                <textarea name="preparation" id="" cols="30" rows="2"  placeholder="None">{{$pharm_finalreports->preparation}}</textarea>
            </td>
            </tr>
            <tr>
                <td class="font"><strong>Dose Administered</strong></td> 
                <td  class="font">
                    <input type="text" required name="dosage" value="{{$pharm_finalreports->dosage}}" placeholder="None">
                </td>
            </tr>
            <tr>
                <td class="font"><strong>Period of Observation</strong></td> 
                <td  class="font">
                    <input type="text" required name="no_days" value="{{$pharm_finalreports->no_days}}" placeholder="None">
               </td>
            </tr>
            <tr>
                <td class="font"><strong>No. of Deaths Recorded</strong></td> 
                <td  class="font">
                    <input type="text" required name="no_death" value="{{$pharm_finalreports->no_death}}" placeholder="None">

                </td>
            </tr>
            <tr>
                <td class="font"><strong>Estimated Median Lethal Dose (LD<sub>50</sub>)</strong></td> 
                <td  class="font">
                    <input type="text" required name="estimated_dose" value="{{$pharm_finalreports->estimated_dose}}" placeholder="None">
            </td>
            </tr>
            <tr>
                <td class="font"><strong>Physical Sign of Toxicity</strong></td> 
                <td  class="font">
                   
                     <textarea name="signs_toxicity" id="" cols="30"   placeholder="None" rows="3">{{$pharm_finalreports->signs_toxicity}}</textarea>
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>  