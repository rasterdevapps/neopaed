<style type="text/css">
    .label-mild {
        background-color: #ffb848;
        padding: 5px;
    }
    .bg-warningg {
        padding: 5px;        
    }
</style>
<div class="row">
    <div class="col-xs-12 text-right back-to-screeening">
        <button type="button" class="btn btn-success back_to_screening"><i class="fa fa-chevron-circle-left"></i> BACK TO SCREENING</button>
    </div>
</div>
<div class="col-md-12 mt-20">
    <table class="table table-bordered table-responsive table-fixed" style="margin: auto; width: auto;">
        <thead>
            <tr>
                <td>Domains</td>
                <td>Total Score</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-left">Relating to People</td>
                <td>{!! Form::text('relating_to_people', null,['class'=>'form-control input-width-small']) !!}</td>
            </tr>
            <tr>
                <td class="text-left">Imitation</td>
                <td>{!! Form::text('imitation', null,['class'=>'form-control input-width-small']) !!}</td>
            </tr>
            <tr>
                <td class="text-left">Emotional Response</td>
                <td>{!! Form::text('emotional_response', null,['class'=>'form-control input-width-small']) !!}</td>
            </tr>
            <tr>
                <td class="text-left">Body Use</td>
                <td>{!! Form::text('body_use', null,['class'=>'form-control input-width-small']) !!}</td>
            </tr>
            <tr>
                <td class="text-left">Object Use</td>
                <td>{!! Form::text('object_use', null,['class'=>'form-control input-width-small']) !!}</td>
            </tr>
            <tr>
                <td class="text-left">Adaptation to Change</td>
                <td>{!! Form::text('adaptation_to_change', null,['class'=>'form-control input-width-small']) !!}</td>
            </tr>
            <tr>
                <td class="text-left">Visual Response</td>
                <td>{!! Form::text('visual_response', null,['class'=>'form-control input-width-small']) !!}</td>
            </tr>
            <tr>
                <td class="text-left">Listening Response</td>
                <td>{!! Form::text('listening_response', null,['class'=>'form-control input-width-small']) !!}</td>
            </tr>
            <tr>
                <td class="text-left">Taste, Smell and Touch Response and Use</td>
                <td>{!! Form::text('tst_response_use', null,['class'=>'form-control input-width-small']) !!}</td>
            </tr>
            <tr>
                <td class="text-left">Fear or Nervousness</td>
                <td>{!! Form::text('fear_nervous', null,['class'=>'form-control input-width-small']) !!}</td>
            </tr>
            <tr>
                <td class="text-left">Verbal Communication</td>
                <td>{!! Form::text('verbal', null,['class'=>'form-control input-width-small']) !!}</td>
            </tr>
            <tr>
                <td class="text-left">Non Verbal Communication</td>
                <td>{!! Form::text('non_verbal', null,['class'=>'form-control input-width-small']) !!}</td>
            </tr>
            <tr>
                <td class="text-left">Activity Level</td>
                <td>{!! Form::text('activity_level', null,['class'=>'form-control input-width-small']) !!}</td>
            </tr>
            <tr>
                <td class="text-left">Level and Consistency of Intellectual Response</td>
                <td>{!! Form::text('intellectual_response', null,['class'=>'form-control input-width-small']) !!}</td>
            </tr>
            <tr>
                <td class="text-left">General Impressions</td>
                <td>{!! Form::text('general_imperssions', null,['class'=>'form-control input-width-small']) !!}</td>
            </tr>
            <tr>
                <td class="text-left">Total score</td>
                <td>{!! Form::text('cars_total', null,['class'=>'form-control input-width-small', 'readonly']) !!}</td>
            </tr>
        </tbody>
    </table>
    {!! Form::hidden('cars_status') !!}
     <h5 class="mt-15 text-center"><b><span id="cars_status"></span></b></h5>
</div>