
CKEDITOR.editorConfig = function( config )
{

   config.skins = 'office2007';


    config.toolbar =
    [
        ['Cut','Copy','Paste','SpellChecker','Underline','Subscript','Superscript','Timestamp'],
        ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat','Table','HorizontalRule','Smiley'],      
        ['SpecialChar', 'Maximize','Styles','Format','Font','FontSize', 'Bold','Italic','Strike','NumberedList','BulletedList','Outdent','Indent','Blockquote', 'TextColor','BGColor'],
	['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
    ];


    config.fillEmptyBlocks = false;
   // config.forceEnterMode  = CKEDITOR.ENTER_BR;
    config.ignoreEmptyParagraph = true;
    config.autoParagraph = false;


   // config.toolbar =
   // [
   //    ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
   //    ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
   //    ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
   //    '/',
   //    ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
   //    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
   //    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
   //    ['Link','Unlink','Anchor'],
   //    ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar'],
   //    '/',
   //    ['Styles','Format','Font','FontSize'],
   //    ['TextColor','BGColor'],
   //    ['Maximize', 'ShowBlocks']
   // ];



};
