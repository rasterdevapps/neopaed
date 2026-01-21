@foreach($daycareList as $daycareRecord)  
  <tr>          
	  <td class="flex-width-medium"> {!! $daycareRecord->BabyName !!} </td>                                    
	  <td class="flex-width-medium"> {!! $daycareRecord->baby_mrno !!} </td>  
  </tr>
@endforeach  	  