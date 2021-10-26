function atualiza_horario() {
    $.ajax({
        type: "POST",
        url: 'core/horaatual.php',
        success: function(q){
            $('#horario').html(q);
        }
    });
    setTimeout('atualiza_horario()', 1000); // a cada 1 segundo atualiza a lista na tela.
}

$().ready(function() {
    setTimeout('atualiza_horario()', 0);
    radialgradient(['body','#9EE9F5','#268FAC','550','MC']);
    $(document).bind("keydown.cbox_close", function (e) {
        if (e.keyCode === 27) {
            e.preventDefault();
            cboxPublic.close();
        }
    });  
    
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
    
    $('input[class=relatorios]').click(function () {
        window.location.href = 'relatorio.php';
    })
        
    $('#registrar_ponto').click(function() {
      if (window.confirm('Deseja realmente registrar o seu ponto?')) {
        $.ajax({       
            type: "GET",
            url: 'core/server-side.php?registrar=ponto',
            success: function(q){       
                if (q==1) {
                    $('#registrar_ponto').remove();
                    window.alert('Saída registrada com sucesso.');
                } 
                if (q==2) {
                    window.alert('Entrada registrada com sucesso.');
                }
                if (q==0) {
                    window.alert('Erro ao tentar registrar o ponto.');
                }
            }
        });
	}
    });
});

