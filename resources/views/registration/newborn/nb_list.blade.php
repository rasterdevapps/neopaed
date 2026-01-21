@extends('app')
@section('content')
<div class="temp-container">
	<div class="temp-row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Newborn Examination Listing<a class="pull-right" href="/newborn/create">Add New</a></div>
				<div class="panel-body">
                     <table class="table table-striped">
						<thead>
                        	<tr>
                            	<th>S.No.</th>
                            	<th>BabyName</th>
                            	<th>{{ Lang::get('home.mrn') }}</th>
                            	<th>Test Date</th>
                            	<th>Action</th>                                
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i <  @count($results); $i++)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{  $results[$i]->BabyName }}</td>
                                    <td>{{  $results[$i]->BMrNo }}</td>
                                    <td>{{  $results[$i]->TestDate }}</td>
                                    <td><a class="icon" href="/newborn/{!!  $results[$i]->NewBornId !!}/edit">Edit</a></td>
                                </tr>
                            @endfor
                        </tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
