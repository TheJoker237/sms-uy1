
$(function() {
    // Manage Filiere : Show , add and update
    $($('.filiere-add')[0]).hide();
    $('.filiere-edit').click(function() {
        var tr = $($($($(this).parent().get(0)).parent().get(0)).parent().get(0));
        var $id = $(tr).children('.id')[0];
        $id = $($id).text();
        var faculty = $(tr.find('td.filiere-faculty')[0]).text();
        var filiere = $(tr.find('td.filiere-title')[0]).text(); 
        var formId ='#filiere-form';
        $(formId + ' select.faculty-field').val(faculty);
        $(formId + ' input.filiere-field').val(filiere);
        $(formId + ' input[name="id"]').val($id);
        var link = $(formId).attr('action');
        if(/save/.test(link)){
            link = link.replace('save','edit');
        }
        $(formId).attr('action',link);
        $($('.filiere-info')[0]).text('Filiere Edit');
        $($('.filiere-add')[0]).show();
        
    });

    // Add Filiere
    $('.filiere-add').click(function() {
        var formId ='#filiere-form';
        var link = $(formId).attr('action');
        if(/edit/.test(link)){
            link = link.replace(/edit\/\d*/,'save');
        }
        $(formId).attr('action',link);
        $($('.filiere-info')[0]).text('Filiere Save');
        $($(this)[0]).hide();

        //Reset Form Records
        $(formId + ' select.faculty-field').val("Select Faculty");
        $(formId + ' input.filiere-field').val('');
       
    });

     // Manage Course : Show , add and update
     $($('.course-add')[0]).hide();
     $('.course-edit').click(function() {
         var tr = $($($($(this).parent().get(0)).parent().get(0)).parent().get(0));
         var $id = $(tr).children('.id')[0];
         $id = $($id).text();
         var filiere = $(tr.find('td.filiere')[0]).text();
         var code = $(tr.find('td.course-code')[0]).text();
         var title = $(tr.find('td.course-title')[0]).text();
         var formId ='#course-form';
         $(formId + ' select.filiere-field').val(filiere);
         $(formId + ' input.code-field').val(code);
         $(formId + ' input.title-field').val(title);
         $(formId + ' input[name="id"]').val($id);
         var link = $(formId).attr('action');
         if(/save/.test(link)){
             link = link.replace('save','edit');
         }
         $(formId).attr('action',link);
         $($('.course-info')[0]).text('Course Update');
         $($('.course-add')[0]).show();
         
     });
 
     // Add Course
     $('.course-add').click(function() {
        var formId ='#course-form';
        var link = $(formId).attr('action');
        if(/edit/.test(link)){
            link = link.replace(/edit/,'save');
    }
        $(formId).attr('action',link);
        $($('.course-info')[0]).text('Course Create');
        $($(this)[0]).hide();
        
        //Reset Form Records
        $(formId + ' select.filiere-field').val('Select Filiere');
        $(formId + ' input.code-field').val('');
        $(formId + ' input.title-field').val('');
     });
});