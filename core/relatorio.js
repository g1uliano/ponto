function atualiza_relatorio() {
    $.ajax({
        type: "POST",
        url: 'core/relatorioatual.php',
        success: function(q){
            $('#relatorios_table').html(q);
        }
    });
}

$().ready(function() {
    radialgradient(['body','#9EE9F5','#268FAC','550','MC']);
    $(document).bind("keydown.cbox_close", function (e) {
        if (e.keyCode === 27) {
            e.preventDefault();
            cboxPublic.close();
        }
    });  
    atualiza_relatorio();
    $(this).bind("contextmenu", function(e) {
        e.preventDefault();
    }); //desabilita click com o botão direito do mouse.
    
    $('input[value=sair]').click(function() {
        $.ajax({       
            type: "GET",
            url: 'core/server-side.php?destroy=session',
            success: function(q){
                window.location.href = q;
            }
        });
    });
    $('select[name=mes_trabalhado]').change(function() {
        $.ajax({
            type: "GET",
            url: 'core/relatorioatual.php?mes='
                +$(this).val()+'&ano='
                +$('select[name=ano_trabalhado]').val()
                +'&id='+$('select[name=usuario_t]').val(),
            success: function(q){
                $('#relatorios_table').html(q);
            }
        });        
    });
    
    $('select[name=ano_trabalhado]').change(function() {
        $.ajax({
            type: "GET",
            url: 'core/relatorioatual.php?mes='
                +$('select[name=mes_trabalhado]').val()
                +'&ano='+$(this).val()
                +'&id='+$('select[name=usuario_t]').val(),
            success: function(q){
                $('#relatorios_table').html(q);
            }
        });        
    });
    $('select[name=usuario_t]').change(function() {
        $.ajax({
            type: "GET",
            url: 'core/relatorioatual.php?mes='
            +$('select[name=mes_trabalhado]').val()
            +'&ano='+$('select[name=ano_trabalhado]').val()
            +'&id='+$('select[name=usuario_t]').val(),
            success: function(q){
                $('#relatorios_table').html(q);
            }
        });        
    });
    
    $('input[class=registro_ponto]').click(function () {
        window.location.href = 'index.php';
    })        
});

