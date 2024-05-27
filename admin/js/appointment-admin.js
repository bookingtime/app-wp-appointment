jQuery( document ).ready(function() {
   BT.formUnsaved();
});

let BT = {
	lang : jQuery('html').attr('lang'),
   formUnsaved: function() {
      if(jQuery('#unsavedFormModal').length > 0) {
         let formAtStart = jQuery('form.form').serialize();
         let modalUnsavedForm = new bootstrap.Modal(document.getElementById('unsavedFormModal'))
         jQuery('.backButton').on('click',function(event) {
            let formAtEnd = jQuery('form.form').serialize();
            if(formAtStart !== formAtEnd) {
               event.preventDefault();
               modalUnsavedForm.show();
            }
         });
      }
   },
}
