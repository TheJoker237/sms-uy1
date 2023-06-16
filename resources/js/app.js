import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

//Manage Filiere : Show , add and update

// $(function() {
//     // $('form select.faculty-field').val('Faculty Of Sciences');
//     // $('form select.faculty-field option[value="Faculty Of Sciences"]').prop('selected','true');
//     alert('ok');
//     $('.link-edit').click(function() {
//         var tr = $($($($(this).parent().get(0)).parent().get(0)).parent().get(0));
//         var id = $(tr.find('td.id')[0]).text();
//         var faculty = $(tr.find('td.filiere-faculty')[0]).text();
//         var filiere = $(tr.find('td.filiere-title')[0]).text(); 
//         $('#filiere-form select.faculty-field').val(faculty);
//         $('#filiere-form input.filiere-field').val(filiere);
//         var link = $('#filiere-form').attr('action');
//         link = link.replace('save','edit');
//         $('#filiere-form input[name="id"]').val(id);
//         // alert($('#filiere-form input[name="id"]').val());
//         $('#filiere-form').attr('action',link);
//         // var route = $('form').attr('action');
//         // alert(route);
//         // $('form').attr('action',{{ route('filiere/update') }});
//         // action="{{ route('filiere/update') }}"
//         // $('form select.faculty-field option[value='+faculty+']').prop('selected','true');
//         // var faculty_field = $('form').find("select.faculty-field")[0].val(faculty);
//         // var filiere_field = $('form').find("input.filiere-field")[0].val(filiere);
//         // ($($('form select.faculty-field option')[1]).prop('selected', true));
//         // alert($($('form select.faculty-field option').find('selected')).val());
//         // <td hidden class="id">{{ $list->id }}</td>
//         // name="id"
//         // <h5 class="form-title student-info">Filiere add
//     })
// });