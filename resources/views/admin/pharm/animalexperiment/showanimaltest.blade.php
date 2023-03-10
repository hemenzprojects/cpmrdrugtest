@extends('admin.layout.main')

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-server bg-blue"></i>
                    <div class="d-inline">
                        <h5>Experiment Details</h5>
                        <span>Pharmacology product experimentation on {{$editexperiment->code}} </span>
                        
                    </div>
                </div>
                
            </div>
            <div class="col-lg-4">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="../index.html"><i class="ik ik-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Experiment</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header"><h3 class="d-block w-100">{{$editexperiment->code}} <small class="float-right"> 
            @foreach($editexperiment->animalExperiment as $temp)
            @if($editexperiment->animalExperiment->first() == $temp)
            {{$temp->created_at->format('d/m/y')}}
            @endif
            @endforeach</small></h3></div>
        <div class="card-body">
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    Experiment By
                    <address>
                        <strong>{{\App\Admin::find($editexperiment->pharm_experiment_by)? \App\Admin::find($editexperiment->pharm_experiment_by)->full_name:'null'}}
                            </strong><br>

                        Phone: {{\App\Admin::find($editexperiment->pharm_experiment_by)? \App\Admin::find($editexperiment->pharm_experiment_by)->tell:'null'}}<br>
                        Email: {{\App\Admin::find($editexperiment->pharm_experiment_by)? \App\Admin::find($editexperiment->pharm_experiment_by)->email:'null'}}
                    </address>
                </div>
             
            </div>

            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped" >
                        <thead>
                            <tr>
                                <thead>
                                    <tr>   
                                <th>Animal Model</th>
                                <th>Weight</th>
                                <th>Dosage</th>
                                <th>Route of Administration </th>
                                <th>Time of Administration</th>
                                <th>Signs of Toxicity</th>
                                <th>Death</th>
                                <th>Time of Death</th>
                                <th> Sex</th>
                                        
                                    </tr>
                                </thead>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($editexperiment->animalExperiment()->orderBy('id','ASC')->get();  as $product)

                            <tr>
                                <td class="font">
                                    {{App\PharmAnimalModel::find($product->animal_model)->name}}
                                </td>
                                <td class="font">{{$product->weight}}</td>
                                <td class="font">{{$product->dosage}}</td>
                                <td class="font">{{$product->animal_method}}</td>
                                <td class="font">{{$product->time_administration}}</td>
                                <td class="font">
                      
                                @foreach ($product['toxicity'] as $itm)             
                                <li class="">{{$itm}}</li>
                                @endforeach
                                </td>
                                <td class="font">{{$product->no_death}}</td>
                                <td class="font">{{$product->time_death}}</td>
                                <td class="font">{{$product->animal_sex}}</td>
                                 
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row" style="margin-top:20px">
                <div class="col-md-3">
                    <label for=""> Total Number of Days</label>
                    @foreach ($editexperiment->animalExperiment as $product)
                    @if($editexperiment->animalExperiment->first() == $product)
                    <p> {{$product->total_days}} </p>
                    @endif
                    @endforeach
                </div>
            
                <div class="col-md-3" >
                    <label for=""> Group</label>
                    @foreach ($editexperiment->animalExperiment as $product)
                    @if($editexperiment->animalExperiment->first() == $product)
                <p> {{$product->group}} </p>
                @endif
                @endforeach
                </div>

                <div class="col-md-6" >
                    <label for=""> Experiment Comment</label>
                    @foreach ($editexperiment->animalExperiment as $product)
                    @if($editexperiment->animalExperiment->first() == $product)
                <p> {{$product->expcomment}} </p>
                @endif
                @endforeach
                </div>

            </div>
        </div>
    </div>


</div>
@endsection



