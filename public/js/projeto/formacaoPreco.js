
// Utilitário para parse de números no formato brasileiro ("1.234,56" -> 1234.56)
function parseBRNumber(value) {
    if (value === null || value === undefined) return 0;
    if (typeof value === 'number') return value;
    const v = String(value).replaceAll('.', '').replaceAll(',', '.');
    const n = parseFloat(v);
    return isNaN(n) ? 0 : n;
}

// Utilitário para formatar moeda BR sem "R$" e sem espaços
function formatCurrencyNumber(num) {
    const formCurrency = new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    });
        return formCurrency.format(num).replace('R$', '').replace(/\s/g, '');
}

/**
 * Calcula preço de venda com base nos parâmetros.
 * Todos os argumentos aceitam string com formato BR ("1.234,56") ou número.
 */
function precoVendaCalcular({
    custo,            // total custo (BR)
    imposto_custo,    // % sobre custo (BR)
    imposto_venda,    // % de imposto na venda (BR)
    difal,            // % (BR)
    ir_csll,          // % (BR)
    outros,           // % (BR)
    comissao,         // % (BR)
    frete,            // % (BR)
    despesa_fixa,     // % (BR)
    margem,           // % (BR)
    qtd,              // quantidade
    prazoMedio,       // dias
    taxa_financeira,  // % ao mês
    vlrVendaUntInicial, // valor unitário existente (opcional, BR)
    vlrVendaInicial,    // valor total existente (opcional, BR)
    total_edital        // total de edital (BR)
}) {
  // Parse de entradas
    let _custo           = parseBRNumber(custo);
    let _imposto_custo   = parseBRNumber(imposto_custo) / 100;
    let _imposto_venda   = parseBRNumber(imposto_venda) / 100;
    let _difal           = parseBRNumber(difal) / 100;
    let _ir_csll         = parseBRNumber(ir_csll) / 100;
    let _outros          = parseBRNumber(outros) / 100;
    let _comissao        = parseBRNumber(comissao) / 100;
    let _frete           = parseBRNumber(frete) / 100;
    let _despesa_fixa    = parseBRNumber(despesa_fixa) / 100;
    let _margem          = parseBRNumber(margem) / 100;
    let _qtd             = parseBRNumber(qtd);
    let _prazoMedio      = parseFloat(prazoMedio) || 0;
    let _taxa_financeira = parseFloat(taxa_financeira) || 0;
    let _vlrVendaUnt     = parseBRNumber(vlrVendaUntInicial);
    let _vlrVenda        = parseBRNumber(vlrVendaInicial);
    let _total_edital    = parseBRNumber(total_edital);

    // Equivalência financeira
    let equivalencia = Math.pow((_taxa_financeira / 100 + 1), (_prazoMedio / 30));
    if (isNaN(equivalencia) || equivalencia <= 0) equivalencia = 1;

  // Ajustes de custo
    _custo = _custo * (( _imposto_custo - 1 ) * -1); // mesma lógica original
    const custo_unt = _qtd > 0 ? _custo / _qtd : 0;

  // Cálculo de markup e preço
    let vlr_venda_unt = 0;
    let vlr_venda_calc = 0;

    if (_margem >= 0) {
        const markup_ir_csl = 1 - (_ir_csll * equivalencia);
        const markup = (((1 - (_margem / markup_ir_csl)) / (equivalencia))
                        - _imposto_venda - _frete - _comissao - _despesa_fixa - _difal - _outros);
        vlr_venda_unt = markup !== 0 ? (custo_unt / markup) : 0;
        vlr_venda_calc = vlr_venda_unt * _qtd;
    }

    // Recalcula unitário a partir do total
    const vlrVendaUntFromTotal = _qtd > 0 ? (vlr_venda_calc / _qtd) : 0;

    // Saídas (numéricas e formatadas)
    const vlrVendaFormatado    = formatCurrencyNumber(vlr_venda_calc);
    const vlrVendaUntFormatado = formatCurrencyNumber(vlrVendaUntFromTotal);

    return {
        equivalencia,
        custoAjustado: _custo,
        custoUnitario: custo_unt,
        vlrVendaTotal: vlr_venda_calc,
        vlrVendaUnitario: vlrVendaUntFromTotal,
        vlrVendaTotalFormatado: vlrVendaFormatado,
        vlrVendaUnitarioFormatado: vlrVendaUntFormatado,
        total_edital: _total_edital,
        // campos auxiliares (se quiser depurar):
        impostos: {
            venda: _imposto_venda, custo: _imposto_custo, difal: _difal,
            ir_csll: _ir_csll, outros: _outros, comissao: _comissao,
            frete: _frete, despesa_fixa: _despesa_fixa, margem: _margem
        },
        qtd: _qtd
    };
}
