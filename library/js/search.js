// $(document).ready(function(){
//     $('.search_box input[type="text"]').on("keyup input", function(){
//         /* Get input value on change */
//         var inputVal = $(this).val();
//         var resultDropdown = $(this).siblings(".result_cari_obat");
//         if(inputVal.length){
//             $.get("/apotek/cek/cari_dataobat.php", {term: inputVal}).done(function(data){
//                 // Display the returned data in browser
//                 resultDropdown.html(data);
//             });
//         } else{
//             resultDropdown.empty();
//         }
//     });
    
//     // Set search input value on click of result item
//     $(document).on("click", ".result p", function(){
//         $(this).parents(".search_box").find('input[type="text"]').val($(this).text());
//         $(this).parent(".result_cari_obat").empty();
//     });

// });

$(document).ready(function(){

    // Inisialisasi select2
    $("#select-cariobat").select2();

});