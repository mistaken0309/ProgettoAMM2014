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
                                       <td>a</td>\n\
                                       <td>a</td>\n\
                                       <td>a</td>\n\
                                       <td>a</td>\n\
                                 </tr>");
                            /*if(i%2 == 0){
                                $("#row_" + i).addClass("alt-row");
                            }*/
                            
                            var colonne = $("#row_"+ i +" td");
                            $(colonne[0]).text(manga['titolo']);
                            $(colonne[1]).text(manga['volume']);
                            $(colonne[2]).text(manga['autore']);
                            $(colonne[3]).text(manga['prezzo']);
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
