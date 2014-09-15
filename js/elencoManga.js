/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    
    $(".error").hide();
    //$("#table_manga").hide();
    $("#nessuno").hide();
    
    $('#filtra').click(function(e){
        // impedisco il submit
        e.preventDefault(); 
        var _autore = $( "#autore option:selected" ).attr('value');
        if(_autore === 'qualsiasi'){
            _autore = '';
        }
        
        var par = {
            autore : _autore
        };
        $.ajax({
            url: 'acquirente/filtra_manga',
            data : par,
            dataType: 'json',
            success: function (data, state) {
                if(data['errori'].length === 0){
                    // nessun errore
                    $(".error").hide();
                    if(data['mangas'].length === 0){
                        // mostro il messaggio per nessun elemento
                        $("#nessuno").show();
                       
                        // nascondo la tabella
                        $("#table_manga").hide();
                    }else{
                        // nascondo il messaggio per nessun elemento
                        $("#nessuno").hide();
                        $("#table_manga").show();
                        //cancello tutti gli elementi dalla tabella
                        $("#table_manga tbody").empty();
                       
                        // aggingo le righe
                        var i = 0;
                        for(var key in data['mangas']){
                            var manga = data['mangas'][key];
        
                            $("#table_manga tbody").append(
                                "<tr id=\"row_" + i + "\" >\n\
                                        <td id=\"1_\"><a href=\"acquirente/manga?param="+ manga['id'] + "\">a</a></td>\n\
                                        <td id=\"2_\">a</td>\n\
                                        <td id=\"3_\"><a href=\"acquirente/lista_per_autore?param="+ manga['autore_id'] +"\">a</a></td>\n\
                                        <td id=\"4_\">a</td>\n\
                                 </tr>");
                            /*if(i%2 == 0){
                                $("#row_" + i).addClass("alt-row");
                            }*/
                            
                            
                            var colonna2 = $("#row_"+ i +" td#2_");
                            var colonna4 = $("#row_"+ i +" td#4_");
                            colonna2.text(manga['volume']);
                            colonna4.text(manga['prezzo']);
                            
                            var colonna1 = $("#row_"+ i +" td#1_ a");
                            var colonna3 = $("#row_"+ i +" td#3_ a");
                            colonna1.text(manga['titolo']);
                            colonna3.text(manga['autore']);
                            
                            
                            
                            i++;
                            
                           
                        }
                    }
                }else{
                    $(".error").show();
                    $(".error ul").empty();
                    for(var k in data['errori']){
                        $(".error ul").append("<li>"+ data['errori'][k] + "<\li>");
                    }
                }
               
            },
            error: function (data, state) {
            }
        
        });
        
    })
});
