
$(function() {

    
    manageFiliere();
    manageCourse();
    manageAcademicYear();
    manageDoyen();
    manageExamenFiliere();
    // manageExamenCourse();
    
});


function manageFiliere()
{
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
}

function manageCourse()
{
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
}

function manageAcademicYear()
{
    $($('.academicYear-add')[0]).hide();
     $('.academicYear-edit').click(function() {
         var tr = $($($($(this).parent().get(0)).parent().get(0)).parent().get(0));
         var $id = $(tr).children('.id')[0];
         $id = $($id).text();
         shortYear = $(tr.find('td.year')[0]).text();
        //  var year = new Date($(tr.find('td.year')[0]).text());
        //  var shortYear = year.getDay() + '-' + year.getMonth() + '-' + year.getFullYear();
         var formId ='#academicYear-form';
         $(formId + ' input.year-filed').val(shortYear);
         $(formId + ' input[name="id"]').val($id);
         var link = $(formId).attr('action');
         if(/save/.test(link)){
             link = link.replace('save','edit');
         }
         $(formId).attr('action',link);
         $($('.academicYear-info')[0]).text('Academic Year Edit');
         $($('.academicYear-add')[0]).show();
         
     });
 
     // Add Academic Year
     $('.academicYear-add').click(function() {
        var formId ='#academicYear-form';
        var link = $(formId).attr('action');
        if(/edit/.test(link)){
            link = link.replace(/edit/,'save');
    }
        $(formId).attr('action',link);
        $($('.academicYear-info')[0]).text('Academic Year Create');
        $($(this)[0]).hide();
        
        //Reset Form Records
        $(formId + ' input.year-field').val('');
     });
}

function manageDoyen()
{
    // ! Check if Doyen already exist
    if($('.doyen-set')[0] != null)
    {
       var formId ='#doyen-form';
       $($('.doyen-info')[0]).text('List Teacher');
       $($('.doyen-submit')[0]).hide();
       // ! If the link has previously changed we restore it
       var formId ='#doyen-form';
       var link = $(formId).attr('action');
       if(/\/doyen\/change/.test(link)){
           link = link.replace(/\/doyen\/change/,'/doyen/set');
       }
       $(formId).attr('action',link);
       
    }
    $('.doyen-edit').click(function() {
        var tr = $($($($(this).parent().get(0)).parent().get(0)).parent().get(0));
        var $id = $(tr).children('.id-teacher')[0];
        $idTeacher = $($id).text();
       //  doyen = $(tr.find('td a.doyen')[0]).text();
        $(formId + ' select.doyen-field').val($idTeacher);
        $(formId + ' input[name="id"]').val($idTeacher);
        var link = $(formId).attr('action');
        if(/\/doyen\/set/.test(link)){
            link = link.replace('/doyen/set','/doyen/change');
        }
        $(formId).attr('action',link);
        $($('.doyen-info')[0]).text('Doyen Change');
        $($('.doyen-submit')[0]).show();
        
    });

    // Doyen reset after Submit
    $('.doyen-submit').click(function() {
       // ? Reset Form Records
       $(formId + ' input.doyen-field').val('');
    });
}

function manageExamenFiliere()
{
    var defaultSelect = "<option disabled>Select Filiere</option>";
    var formId ='#examen-form';
    //Toggle Exam Type
    $('#examen-form select[name="session"]').prop('disabled','true');
    
    $('#examen-form select[name="type"]').change(function(){
        if($(this).val() == "Session Normale")
            $('#examen-form select[name="session"]').prop('disabled','');
        else{
            $('#examen-form select[name="session"]').prop('disabled','true');
        }
    });

    $(formId + ' select[name="faculte[]"]').change(function(){
        if ($(this).val() != ""){
            /**
             * % Ajax Request
             */
            // CREATE
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            var formData = {
                facultes: $(this).val(),
            };
            var type = "POST";
            var ajaxurl = "http://127.0.0.1:8000/examen/manage-filiere";
            $.ajax({
                type: type,
                url: ajaxurl,
                data: formData,
                dataType: 'json',
                success: function (data) {
                    $('#filiere').empty();
                    $('#filiere').append(defaultSelect);
                    data.forEach(element => {
                        var opt = "<option value="+element['id']+">"+element['title']+"</option>";
                        $('#filiere').append(opt);
                    });
                    manageExamenCourse();
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
        else
        {
            $('#filiere').empty();
            $('#filiere').append(defaultSelect);
        }
    });

}
function manageExamenCourse()
{
    var defaultSelect = "<option disabled>Select Course</option>";
    var formId ='#examen-form';

    $(formId + ' select[name="filiere[]"]').change(function(){
        if ($(this).val() != ""){
            /**
             * % Ajax Request
             */
            // CREATE
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            var formData = {
                Idfilieres: $(this).val(),
            };
            var type = "POST";
            var ajaxurl = "http://127.0.0.1:8000/examen/manage-course";
            $.ajax({
                type: type,
                url: ajaxurl,
                data: formData,
                dataType: 'json',
                success: function (data) {
                    $('#course').empty();
                    $('#course').append(defaultSelect);
                    data.forEach(element => {
                        var opt = "<option value="+element['id']+">"+element['title']+"</option>";
                        $('#course').append(opt);
                    });
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
        else
        {
            $('#course').empty();
            $('#course').append(defaultSelect);
        }
    });

}

