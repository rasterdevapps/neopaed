<script type="text/javascript">
//var tagsarray = ['Background','CurrentProblems','PreviousProblems','Notes','Plan','OtherFindings'];
//
//$.each(tagsarray,function(index,values){
//    createTags(values);
//});
//function createTags(values){
//
//    $('#'+values).tagsinput({
//        typeahead: {
//           local: {!! ValuelistHelpers::autoSuggestionvalue(); !!},
//         },
//        allowDuplicates: true,
//        trimValue: true,
//        tagClass: 'big',
//        confirmKeys: [13],
//        splitOn: ':',
//   });
//
//}



$('input').on('beforeItemAdd', function(event) {
    event.item.replace('#',',');
});
</script>