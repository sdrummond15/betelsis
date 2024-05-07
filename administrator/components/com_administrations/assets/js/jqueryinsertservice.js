jQuery(document).ready(function(){
    jQuery("#insertserv").click(function () {
        var qtd = jQuery('#qtd').val();
        var valor = jQuery('#valor').val();
        var serv = jQuery('#servico').val();
        var desc = jQuery('#desc').val();
        var soma = jQuery('#soma').val();
        var garantia = jQuery('#garantia').val();
        var desconto = jQuery('#jform_desconto').val();
        var id = jQuery('#jform_id').val();
        jQuery.post("../administrator/components/com_administrations/models/ajaxinsertserv.php?id=" + id + "&qtd=" + qtd + "&soma=" + soma + "&valor=" + valor + "&serv=" + serv + "&desc=" + desc + "&garantia=" + garantia + "&desconto=" + desconto, {
        }, function (response) {
            jQuery('#results').html(jQuery(response).fadeIn('hide'));
            jQuery('.listaserv').css('display','none');
            jQuery('#servico').val('0');
            jQuery('#qtd').val('');
            jQuery('#desc').val('');
            jQuery('#garantia').val('');
            jQuery('#valor').val('');
            jQuery('#soma').val('');
        });
    });
    
    jQuery(document).on('click', '.deletaserv', function () {
        var deletar = jQuery(this).attr('name');
        var iddelete = jQuery('#jform_id').val();
        jQuery.post("../administrator/components/com_administrations/models/ajaxinsertserv.php?id=" + iddelete + "&deletaid=" + deletar , {
        }, function (response) {
            jQuery('#results').html(jQuery(response).fadeIn('hide'));
            jQuery('.listaserv').css('display','none');
        });

    });
    
    jQuery(".clienteorcserv").change(function () {
        var cliente = jQuery(".clienteorcserv").val();
        if (cliente > 0){
        var url = "../administrator/components/com_administrations/models/ajaxcompletinput.php?idcliente=" + cliente;	 
	    jQuery.ajax({
	        url: url,
	        cache: false,
	        dataType: "json",
	        success: function(retorno) {
                    jQuery('#jform_contato').val(retorno[0].contato);
                    jQuery('#jform_cnpjcpf').val(retorno[0].cnpjcpf);
                    jQuery('#jform_insc_est').val(retorno[0].insc_est);
                    jQuery('#jform_insc_mun').val(retorno[0].insc_mun);
                    jQuery('#jform_endereco').val(retorno[0].endereco);
                    jQuery('#jform_numero').val(retorno[0].numero);
                    jQuery('#jform_complemento').val(retorno[0].complemento);
                    jQuery('#jform_cep').val(retorno[0].cep);
                    jQuery('#jform_id_bairro').val(retorno[0].id_bairro);
                    jQuery('#jform_id_cidade').val(retorno[0].id_cidade);
                    jQuery('#jform_fone').val(retorno[0].fone);
                    jQuery('#jform_fone_comercial').val(retorno[0].fone_comercial);
                    jQuery('#jform_celular').val(retorno[0].celular);
                    jQuery('#jform_celular2').val(retorno[0].celular2);
                    jQuery('#jform_email').val(retorno[0].email);
                    jQuery('#jform_email2').val(retorno[0].email2);
                    jQuery('#jform_published').val(retorno[0].published);
                },
		error: function (error) {
			console.log(error);
		}
        });
        }else{
            alert ('Selecione um Cliente!');
        }
    });
    

});
