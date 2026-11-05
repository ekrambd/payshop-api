$(document).ready(function(){
	$.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
   });

	$('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    }) 
  

   $('.dropify').dropify();


   $('#description').summernote(
      {
        height: 100,
        focus: false
      }
    );

   function isValidNumber(value) {
    return /^\d*\.?\d{0,4}$/.test(value);
}

$(document).on('input', '.numericInput', function () {
    let enteredValue = $(this).val();

    if (!isValidNumber(enteredValue)) {
        $(this).val(enteredValue.slice(0, -1));
    }
});
  
  $(document).on('click', '.reset-filter', function(e){
        if(confirm('Do you want to reset?'))
        {
            window.location.reload();
        }
   });

});

