function dragStart(e){
 e.stopPropagation();
 var boxObj = this,
     dataObj = this.text;
 boxObj.className = boxObj.className + " is-dragged";
 e.dataTransfer.effectAllowed = 'copy';
 e.dataTransfer.setData('text', dataObj); 
}

function dragEnd(e){
 e.stopPropagation();
 var boxObj = this;
 boxObj.className = boxObj.className.replace('is-dragged',''); 
}

function dragEnter(e){
  if (e.stopPropagation) e.stopPropagation();
  this.className = this.className + " dropover";
}

function dragLeave(e){
  if (e.stopPropagation) e.stopPropagation();
  this.className = this.className.replace('dropover','');
}

function dragOver(e){
  if (e.stopPropagation) e.stopPropagation();
  e.preventDefault();
  e.dataTransfer.dropEffect = 'copy';
  return false; 
}

function drop(e){
  if (e.stopPropagation) e.stopPropagation();
  var removeEl = e.dataTransfer.getData('text'),
      boxes = document.getElementsByClassName('box'),
      dropZone = document.getElementById('dropzone');
  
  for( var i=0; i<boxes.length; i++ ){
    
    if( boxes[i].text == removeEl ){
      boxes[i].parentNode.removeChild(boxes[i]);
     
      if( boxes.length <= 0 ){
        
        var a = document.createElement('a'),
            h3 = document.createElement('h3'),
            boxWrapper = document.getElementsByClassName('drop-boxes');
        h3.innerHTML = "Hooray! You removed all the boxes.";
        a.setAttribute('href','#');
        a.setAttribute('id','restartLink');
        a.addEventListener('click',restartLink,false);
        
        a.className = 'show';
        a.innerHTML = 'Click me to restart.';
        
        boxWrapper[0].appendChild(h3);
        boxWrapper[0].appendChild(a);
        dropZone.className = 'hide';
      }
    }
  }
  
  this.className = this.className.replace('dropover','');
  return false;
}

function restartLink(e){
  e.preventDefault();
  var h3 = document.getElementsByTagName('h3')[0],
      dropBoxes = document.getElementsByClassName('drop-boxes')[0],
      dropZone = document.getElementById('dropzone');
  this.className = this.className.replace('show','') + 'hide';
  dropZone.className = dropZone.className.replace('hide','show');
  h3.parentNode.removeChild(document.getElementsByTagName('h3')[0]);

  for( var i=0,box=''; i<4; i++ ){
    box = document.createElement('a');
    box.className = 'box';
    box.setAttribute('href','#');
    box.setAttribute('draggable','true');
    switch(i){
      case 0: box.text = 'One';
              break;
      case 1: box.text = 'Two';
              break;
      case 2: box.text = 'Three';
              break;
      case 3: box.text = 'Four';
              break;
    }
    dropBoxes.appendChild(box);
  }
  this.parentNode.removeChild(this);
  init();
}

function init(){
  
  var boxes = document.querySelectorAll('.box'),
      dropZone = document.getElementById('dropzone');
  
  for( var i=0,len=boxes.length; i<len; i++ ){
    boxes[i].addEventListener('dragstart', dragStart, false);
    boxes[i].addEventListener('dragend', dragEnd, false);
  }
  
  dropZone.addEventListener('dragenter', dragEnter, false);
  dropZone.addEventListener('dragleave', dragLeave, false);
  dropZone.addEventListener('dragover', dragOver, false);
  dropZone.addEventListener('drop', drop, false);
}

init();
