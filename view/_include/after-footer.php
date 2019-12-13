<?php
/**
 * Created by PhpStorm.
 * User: Vinicius
 * Date: 07/03/2019
 * Time: 11:51
 */?>

<script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" ></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" ></script>


<script src="https://cdn.jsdelivr.net/npm/pickadate@3.6.4/lib/picker.js"></script>
<script src="https://cdn.jsdelivr.net/npm/pickadate@3.6.4/lib/picker.date.js"></script>
<script src="https://cdn.jsdelivr.net/npm/pickadate@3.6.4/lib/picker.time.js"></script>

<script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<script src="<?=THEME_URI?>/_assets/js/app.js"></script>
<script src="<?=THEME_URI?>/_assets/js/functions.js"></script>




<script>
    $('.calendario').pickadate({
        container: 'body',
        monthsFull: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        monthsShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        weekdaysFull: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sabado'],
        weekdaysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
        showMonthsShort: false,
        showWeekdaysFull: false,
        today: 'Hoje',
        clear: 'Limpar',
        close: 'Fechar',
        labelMonthNext: 'Próximo Mês',
        labelMonthPrev: 'Mês Anterior',
        labelMonthSelect: 'Selecione um Mês',
        labelYearSelect: 'Selecione um Ano',
        format: 'dd/mm/yyyy',
        formatSubmit: 'yyyy-mm-dd',
        //hiddenPrefix: 'prefix__',
        hiddenSuffix: '_submit',
        selectYears: 70,
        max: true
    });

    $('.form_hora').pickatime({
        container: 'body',
        clear: 'Limpar',
        format: 'HH:i:00',
        hiddenSuffix: '_submit',
        formatSubmit: 'HH:i',
        formatLabel: "<b>H</b>:i:00 <!i><!s!m!a!l!l>!h!r(!s)</!s!m!a!l!l></!i>",
        interval: 60
    });



    $(".tel").inputmask({
        mask: ["(99) 9999-9999", "(99) 9 9999-9999"],
        keepStatic: true,
        showMaskOnHover: false
    });

    $('.cpf').inputmask({
        mask: ["999.999.999-99"],
        keepStatic: true,
        showMaskOnHover: false
    });


</script>
