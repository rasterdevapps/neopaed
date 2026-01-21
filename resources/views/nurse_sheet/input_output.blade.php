<div class="col-md-12 pt-0  plr-0">
    <div class="col-md-12 col-lg-6">
      <div class="mt-10 widget box">
        <div class="widget-header">
            <h4><i class="fa fa-reorder"></i> IV Fluids, Parenteral Nutrition And Drug Infusion</h4>
        </div>
        <div class="widget-content">
            <div class="hidden">
                {!! Form::select('temp_drug_solution',$ivfluids,null) !!}
            </div>

            <div class="form-group">
                <table class="drug_infusions table table-add-more full-width-fix">
                    <thead>
                        <tr class="master-add-header">
                            <th>
                                {!! Form::label('solution','Solution:') !!}
                                <a href="javascript:void(0)" class="add_master_data" data-modal_header="Drugs & Iv Fluids" data-destination_elements="drug_solution[],replacement_fluids_solution[]" data-option_value="id" data-option_text="brand_name,generic_pharmacological_name" data-mas_table="mas_drugivfluid">
                                    <i class="fa fa-info-circle bs-tooltip" data-placement="right" data-original-title="Add Drugs & Iv Fluids"></i>
                                </a>
                            </th>
                            <th>{!! Form::label('rate','Rate (ml/h):') !!}</th>
                            <th>{!! Form::label('total','Total (ml):') !!}</th>
                            <th>
                                <span>
                                    <a class="btn btn-success btn-view drug_infusions_add btn_add" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                </span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($iv_fluids_previous) && count($iv_fluids_previous) > 0)
                        @php $i=0; @endphp
                        @foreach($iv_fluids_previous as $iv_fluids)
                        @if (is_object($iv_fluids))
                        @php $iv_fluids = (array)$iv_fluids; @endphp
                        @endif
                        <tr>
                            @if (isset($iv_fluids['drug_id']))
                            <td>{!! Form::select('drug_solution[]',$ivfluids,$iv_fluids['drug_id'],['class'=>'drug-solution input-width-xlarge permanant_saved not_saved','id'=>'drug-solution-'.$i,'data-solution'=>$i]) !!}</td>
                            @else
                            <td>{!! Form::select('drug_solution[]',$ivfluids,$iv_fluids['drug_solution'],['class'=>'drug-solution input-width-xlarge permanant_saved not_saved','id'=>'drug-solution-'.$i,'data-solution'=>$i]) !!}</td>
                            @endif
                            <td>{!! Form::number('drug_rate[]',null,['class'=>'form-control permanant_saved not_saved', 'data-solution'=>$i]) !!}</td>
                            <td>{!! Form::number('drug_total[]',$iv_fluids['drug_total'],['class'=>'form-control drug_total permanant_saved not_saved','id'=>'drug-rate-'.$i, 'readonly']) !!}</td>
                            <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                        </tr>
                        @php $i++; @endphp
                        @endforeach
                        @else 
                        <tr>
                            <td>{!! Form::select('drug_solution[]',$ivfluids,null,['class'=>'drug-solution input-width-xlarge permanant_saved not_saved','id'=>'drug-solution-0','data-solution'=>'0']) !!}</td>
                            <td>{!! Form::number('drug_rate[]',null,['class'=>'form-control permanant_saved not_saved','data-solution'=>'0']) !!}</td>
                            <td>{!! Form::number('drug_total[]',null,['class'=>'form-control drug_total permanant_saved not_saved','id'=>'drug-rate-0', 'readonly']) !!}</td>
                            <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <h3><u><b>Milk Feeds</b></u></h3>
            <div class="form-group">
                @php $milk_feeds['milk_feeds']= isset($milk_feeds['milk_feeds']) ? $milk_feeds['milk_feeds'] : null;   @endphp
                {!! Form::label('milk_feeds','Milk Feeds:') !!} 
                {!! Form::select('milk_feeds',['No'=>'No (NPO)', 'Yes'=> 'Yes'],$milk_feeds['milk_feeds'],['class'=>'form-control not_saved permanant_saved']) !!}
            </div>
            <div class="form-group">
                @php $milk_feeds['type_of_feeds']= isset($milk_feeds['type_of_feeds']) ? $milk_feeds['type_of_feeds'] : null;   @endphp
                {!! Form::label('type_of_feeds','Type Of Feeds:') !!} 
                {!! Form::select('type_of_feeds',ValuelistHelpers::typeoffeeds(),$milk_feeds['type_of_feeds'],['class'=>'form-control not_saved permanant_saved']) !!}
            </div>
            <div class="form-group">
                @php $milk_feeds['route_of_feeds']= isset($milk_feeds['route_of_feeds']) ? $milk_feeds['route_of_feeds'] : null;   @endphp
                {!! Form::label('route_of_feeds','Route of Feeds:') !!}
                {!! Form::select('route_of_feeds',ValuelistHelpers::routeoffeed(),$milk_feeds['route_of_feeds'],['class'=>'form-control']) !!}
            </div>
            <div class="form-group human_milk_fortification">
                @php $milk_feeds['human_milk_fortification']= isset($milk_feeds['human_milk_fortification']) ? $milk_feeds['human_milk_fortification'] : null;   @endphp
                {!! Form::label('human_milk_fortification','Human Milk Fortification:') !!}
                <input id="human_milk_fortification" name="human_milk_fortification" data-on="Yes" data-off="No" @if($milk_feeds['human_milk_fortification'] =='on') checked="true" @endif data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
            </div>          
            <div class="form-group milk_volume">
                <table class="table table-add-more full-width-fix">
                    <thead>
                        <tr>
                            <th>{!! Form::label('milk_volume','Milk Volume:') !!}</th>
                            <th>{!! Form::label('milk_volume_total','Total:') !!}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @php $milk_feeds['milk_volume_total']= isset($milk_feeds['milk_volume_total']) ? $milk_feeds['milk_volume_total'] : null;   @endphp
                            <td>{!! Form::text('milk_volume',null,['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('milk_volume_total',$milk_feeds['milk_volume_total'],['class'=>'form-control']) !!}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="form-group">
                {!! Form::label('Transfusion','Transfusion:') !!}
                {!! Form::select('Transfusion',[''=>'N/A','No' =>"No","Yes"=>"Yes"],'',['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('Transfusion')]) !!}
            </div>
            <div class="hidden">
                {!! Form::select('f_product_temp',[''=>'N/A','Packed RBC'=>'Packed RBC','Whole Blood'=>'Whole Blood','Platelet Concentrate'=>'Platelet Concentrate','Fresh Frozen Plasma'=>'Fresh Frozen Plasma','Cryoprecipitate'=>'Cryoprecipitate','Washed maternal platelets'=>'Washed maternal platelets','NAIT - special platelets'=>'NAIT - special platelets','Immunoglobulin'=>'Immunoglobulin'],null,['class'=>'form-control']) !!} 
            </div>           
            <div class="form-group">
                <table class="product table table-add-more full-width-fix">
                    <thead>
                        <tr class="master-add-header">
                            <th>Product</th>
                            <th>Volume ml/kg</th>
                            <th>
                                <span>
                                    <a class="btn btn-success btn-view product_add btn_add" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                </span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($products) && count($products) > 0)
                        @foreach ($products as $data)
                        <tr>
                            <td class="full-width">{!! Form::select('F_Product[]',[''=>'N/A','Packed RBC'=>'Packed RBC','Whole Blood'=>'Whole Blood','Platelet Concentrate'=>'Platelet Concentrate','Fresh Frozen Plasma'=>'Fresh Frozen Plasma','Cryoprecipitate'=>'Cryoprecipitate','Washed maternal platelets'=>'Washed maternal platelets','NAIT - special platelets'=>'NAIT - special platelets','Immunoglobulin'=>'Immunoglobulin'],$data['Product'],['class'=>'form-control']) !!} </td>
                            <td><input type="number" class="form-control" name="F_Volume[]" value="{!! $data['Volume']; !!}"/></td>
                            <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td class="full-width"> {!! Form::select('F_Product[]',[''=>'N/A','Packed RBC'=>'Packed RBC','Whole Blood'=>'Whole Blood','Platelet Concentrate'=>'Platelet Concentrate','Fresh Frozen Plasma'=>'Fresh Frozen Plasma','Cryoprecipitate'=>'Cryoprecipitate','Washed maternal platelets'=>'Washed maternal platelets','NAIT - special platelets'=>'NAIT - special platelets','Immunoglobulin'=>'Immunoglobulin'],null,['class'=>'form-control']) !!} </td>
                            <td><input type="number" class="form-control" name="F_Volume[]" value=""/></td>
                            <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="form-group">
                @php $replacement_fluids = isset($replacement_fluids->value) ? $replacement_fluids->value : null @endphp 
                {!! Form::label('replacement_fluids_status','Replacement Fluids:') !!}
                {!! Form::select('replacement_fluids_status',[''=>'N/A','No' =>"No","Yes"=>"Yes"],$replacement_fluids,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('Transfusion')]) !!}
            </div>
            <div class="form-group">
                <table class="replacement_fluids table table-add-more full-width-fix">
                    <thead>
                        <tr class="master-add-header">
                            <th>
                                {!! Form::label('replacement_fluids_solution','Solution:') !!}
                                <a href="javascript:void(0)" class="add_master_data" data-modal_header="Drugs & Iv Fluids" data-destination_elements="drug_solution[],replacement_fluids_solution[]" data-option_value="id" data-option_text="brand_name,generic_pharmacological_name" data-mas_table="mas_drugivfluid">
                                    <i class="fa fa-info-circle bs-tooltip" data-placement="right" data-original-title="Add Drugs & Iv Fluids"></i>
                                </a>
                            </th>
                            <th>{!! Form::label('replacement_fluids_rate','Rate:') !!}</th>
                            <th>{!! Form::label('replacement_fluids_total','Total:') !!}</th>
                            <th>
                                <span>
                                    <a class="btn btn-success btn-view replacement_fluids_add btn_add" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                </span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($replacement_previous_fluids) && count($replacement_previous_fluids) > 0)
                        @php $i = 0; @endphp 
                        @foreach($replacement_previous_fluids as $fluids)
                        <tr>
                            <td>{!! Form::select('replacement_fluids_solution[]',$ivfluids,$fluids['replacement_fluids_solution'],['class'=>'replacement-fluids-solution input-width-xlarge', 'id'=>'replacement-fluids-solution-'.$i, 'data-replacement'=>$i]) !!}</td>
                            <td>{!! Form::number('replacement_fluids_rate[]',null,['class'=>'form-control','data-solution'=>$i ]) !!}</td>
                            <td>{!! Form::number('replacement_fluids_total[]',$fluids['replacement_fluids_total'],['class'=>'form-control','id'=>'replacement_fluids_total'.$i]) !!}</td>
                            <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                        </tr>
                        @php $i++; @endphp 
                        @endforeach
                        @else
                        <tr>
                            <td>{!! Form::select('replacement_fluids_solution[]',$ivfluids,null,['class'=>'replacement-fluids-solution input-width-xlarge', 'id'=>'replacement-fluids-solution-0', 'data-replacement'=>'0']) !!}</td>
                            <td>{!! Form::number('replacement_fluids_rate[]',null,['class'=>'form-control','data-solution'=>'0']) !!}</td>
                            <td>{!! Form::number('replacement_fluids_total[]',null,['class'=>'form-control','id'=>'replacement_fluids_total0']) !!}</td>
                            <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="hidden">
                {!! Form::select('a_antibiotic_temp',[''=>'--select--']+ValuelistHelpers::getAntibiotic(),'',['class'=>"input-width-medium form-control"]) !!}
            </div>            
            <div class="form-group hide">
                <table class="antibiotic table table-add-more full-width-fix">
                    <thead>
                        <tr class="master-add-header">
                            <th>
                                Antibiotic
                                <a href="javascript:void(0)" class="add_master_data" data-modal_header="Antibiotics" data-destination_elements="a_antibiotic_temp,A_Antibiotic[]" data-option_value="id" data-option_text="generic_pharmacological_name" data-mas_table="mas_antibiotic">
                                    <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Antibiotics"></i>
                                </a>
                            </th>
                            <th>Day</th>
                            <th>
                                <span>
                                    <a class="btn btn-success btn-view antibiotic_drug_add btn_add" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                </span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($antibiotic_previous) && count($antibiotic_previous) > 0)
                        @php $i = 1; @endphp
                        @foreach ($antibiotic_previous as $data)
                        <tr>
                            <td>{!! Form::select('A_Antibiotic[]',[''=>'--select--']+ValuelistHelpers::getAntibiotic(),$data['A_Antibiotic'],['class'=>'sepsis-antibiotic input-width-xlarge','data-antibiotic'=>$i ,'id'=>'antiboitic'.$i ]) !!}</td>
                            <td><input type="number" class="form-control" name="A_Day[]" value="{!! $data['A_Day']; !!}"/></td>
                            <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                        </tr>
                        @php $i++ @endphp
                        @endforeach
                        @else
                        <tr>
                            <td>{!! Form::select('A_Antibiotic[]',[''=>'--select--']+ValuelistHelpers::getAntibiotic(),null,['class'=>'sepsis-antibiotic input-width-xlarge','data-antibiotic'=>'0' ,'id'=>'antiboitic0' ]) !!}</td>
                            <td><input type="number" class="form-control" name="A_Day[]" value=""/></td>
                            <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="hidden">
                {{ Form::select('temp_drugs', $drugs, null,['class'=>'input-width-xlarge']) }}
            </div>           
            <div class="form-group hide">
                <table class="sep_drugs table table-add-more full-width-fix">
                    <thead>
                        <tr class="master-add-header">
                            <th>Other Drugs</th>
                            <th>
                                <span>
                                    <a class="btn btn-success btn-view nurse_drugs_add btn_add" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                </span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($other_drugs_previous) && count($other_drugs_previous) > 0)
                        @php $i = 0; @endphp
                        @foreach ($other_drugs_previous as $data)
                        <tr>
                            <td class="full-width">{!! Form::select('drugs[]', $drugs, $data['drugs'],['class'=>'full-width other_drugs', 'id'=>'other_drugs_'.$i, 'data-other-drug'=>$i]) !!}</td>
                            <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                        </tr>
                        @php $i++; @endphp
                        @endforeach
                        @else
                        <tr>
                            <td class="full-width">{!! Form::select('drugs[]', $drugs, null,['class'=>'full-width other_drugs', 'id'=>'other_drugs_0', 'data-other-drug'=>'0']) !!}</td>
                            <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12 col-lg-6">
  <div class="mt-10 widget box">
    <div class="widget-header">
        <h4><i class="fa fa-reorder"></i> Output:</h4>
    </div>
    <div class="widget-content">
        <div class="form-group">
            {!! Form::label('gastric_aspirate_volume','Gastric Aspirate Volume (ml):') !!}
            <div class="gastric_aspirate_volume"></div>
        </div>
        <div class="form-group">
            {!! Form::label('gastric_aspirate','Gastric Aspirate (nature):') !!}
            {!! Form::select('gastric_aspirate', ValuelistHelpers::babygastricaspirate(),null,['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('urine_output', 'Urine Output (ml):') !!}
            <div class="urine_output"></div>
        </div>
        <div class="form-group">
            {!! Form::label('blood_volume_out', 'Blood Volume Out (ml):') !!}
            <div class="blood_volume_out"></div>
        </div>
        <div class="form-group">
            {!! Form::label('drain_output_r','Drain Output (R):') !!}
            <div class="drain_output_r"></div>
        </div>
        <div class="form-group">
            {!! Form::label('drain_output_l','Drain Output (L):') !!}
            <div class="drain_output_l"></div>
        </div>
        <div class="form-group">
            {!! Form::label('bowels', 'Bowels Opened:') !!}
            <input id="bowels" name="bowels" data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
        </div>
        <div class="form-group">
            {!! Form::label('bowels_count', 'Number of stools since last entry:') !!}
            <div class="bowels_count"></div>
        </div>
        <div class="form-group">
            {!! Form::label('stools_nature','Stools Nature:') !!}
            {!! Form::select('stools_nature', ValuelistHelpers::nursesheetstoolsnature(),null,['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('kmc','KMC:') !!}
            <input id="kmc" name="kmc" data-on="Yes" data-off="No" data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
        </div>
        <div class="form-group">
            {!! Form::label('nns','NNS:') !!}
            <input id="nns" name="nns" data-on="Yes" data-off="No" data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
        </div>
        <div class="form-group">
            {!! Form::label('stoma_output_hour', 'Stoma Output (ml):') !!}
            <div class="stoma_output_hour"></div>
        </div>
    </div>
</div>
</div>
</div>
