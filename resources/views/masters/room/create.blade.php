@extends('app')
@section('content')
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
		<li><a href="{{ action('Masters\RoomManagementController@index') }}">Room Management</a></li>       
		<li class="current"><a>Create</a></li>                                                 
	</ul>
</div>
<style type="text/css">
.components-list {
	

}
.component-list-rows {
	border: 1px solid #d9d9d9;
	padding: 1em;
	cursor: move;
}

.base-layout {
	border: 1px solid #d9d9d9;
	border-radius: 12px;
	width: 100%;
	min-height: 800px;
	margin: 5px 5px;
	background-color: #ddd;
}
.bed-image-size {
	width: 20px;
	height: 20px;
}

.path-way{
	background-image: url('../public/bed-image/path_way_image.jpg');
	background-size: 100px 100px;
	height: 100px;
	width: 100px;
	background-repeat: no-repeat;
	border: 1px solid;
}
	
</style>

<div class="row row-spacing">
    <div class="col-md-9 tab-view-shadow">
    	<div class="base-layout" id="base-layout-id">
    		<div class="path-way layout-components" id="resizeDiv">
    		</div>
    	</div>
    </div>
    <div class="fields-search-list-sidebar">
        <div role="tabpanel" class="tabbable tabbable-custom">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#components" role="tab" data-toggle="tab">
                          Components
                    </a>
                </li>
                <li role="presentation">
                    <a href="#components_properties" role="tab" data-toggle="tab">
                          Components properties
                    </a>
                </li>
            </ul> 
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="components">
                 <div class="components-list list-group">
                 	<div draggable="true" class="component-list-rows drag-components" id="bed-move-icons">
                 		<img  class="bed-image-size " src="{{ url('public/bed-image/baby_warmer.png') }}">
                 		<span class="font-medium"> Bed </span>
                 	</div>
                 	<div draggable="true" class="component-list-rows drag-components" id="pathway-move-icons">
                 		<img  class="bed-image-size"  src="{{ url('public/bed-image/path_way.png') }}">
                 		<span class="font-medium"> Path </span>
                 	</div>

                 </div>
                </div>

                <div role="tabpanel" class="tab-pane" id="components_properties">
                    <button class="btn form-control" id="resize-property"> Resize</button>
                    <button class="btn form-control" id="move-property"> move</button>
                </div>
            </div> 	
        </div>   

	</div>
</div>    

@endsection
@section('scripts')
<script type="text/javascript">




	/* restricte the droping object  */
    function wardrestricteDrop(e) {

     e.preventDefault();
    }

   /* set the draging object into the events */
    function wardDragComponent(e) {
         
     e.dataTransfer.setData("target-text", e.target.id);
     e.dataTransfer.setData("target-y", e.clientY);

    }

    function findParentNodeClass(el,className) {

      className = className.toLowerCase();

      while (el && el.parentElement) {
        el = el.parentElement;
        if (el.classList.contains(className)) {
          return el;
        }
      }
      return null;

    }
	//add event listner for basic components 
   function wardComponentListner(componentId) {

       var  basicComponent = document.getElementById(componentId);
            basicComponent.addEventListener('dragstart',wardDragComponent,false);
            basicComponent.addEventListener('drop',wardrestricteDrop,false);
   }

   //add event listner for basic components 
   function wardLayoutListner(containerId) {
      var  baseContainer =  document.getElementById(containerId);
           baseContainer.addEventListener('dragover',wardrestricteDrop,false);
           baseContainer.addEventListener('drop',getdropbed,false);

   }

       //restirct event listner for basic components 
   function wardrestrictComponentListner(componentId) {

       var  basicComponent = document.getElementById(componentId);
            basicComponent.addEventListener('dragstart',wardrestricteDrop,false);
            basicComponent.addEventListener('drop',wardrestricteDrop,false);
   }

   function getdropbed(e) {

   	   e.preventDefault();
       var dragingComponent         = e.dataTransfer.getData("target-text");
       var dragComId                = document.getElementById(dragingComponent);
       var dropPosition             = document.elementFromPoint(e.clientX,e.clientY);
       var sourceYaxis              = e.dataTransfer.getData("target-y");
       var sourceContainer          = dragComId.parentNode;
       
       $('#'+dragComId.id).css('left',e.clientX).css('position', 'relative');


       if (dragComId.id == 'pathway-move-icons') {
       	   console.log(dropPosition);
       }
       //console.log(dragComId);
   }


   $('#move-property').click(function() {
   	  var activeId = $('.active-components').attr('id');
   	      $('#'+activeId).attr('draggable', true);
   		  wardComponentListner(activeId);
   });

   	$('#resize-property').click(function() {
   		var activeId = $('.active-components').attr('id');
   	 	$('#'+activeId).resizable({maxWidth: 30});
		$('#'+activeId).resize(function() {
			$(this).css('background-size', $(this).width()+'px '+$(this).height()+'px');		  
		});
   	});
   
   	$(document).dblclick(function() {
   		var activeId = $('.active-components').attr('id');
		    $('#'+activeId).resizable('destroy');
	});

	$('.layout-components').dblclick(function() {

   	   $(this).addClass('active-components');
	   $('a[href="#components"]').removeClass('active');
	   $('#components').removeClass('active');
	   $('a[href="#components_properties"]').addClass('active');
	   $('#components_properties').addClass('active');
   });

	$(document).ready(function() {

   	  $('.drag-components').each(function() {
   		   wardComponentListner($(this).attr('id'));
   	  });
   	       wardLayoutListner('base-layout-id');
   	    
   });






</script>
@endsection
