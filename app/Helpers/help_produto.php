<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class help_produto{
    public static function localizaProduto($nome)
    {
        dd($nome);
    }
    public static function ultimasEntradas($PR_COD)
    {
        $cfop = "'101','102'";
        $sql = "
            SELECT
                FIL.FI_RAZSOC
                , EN_NOM
                , NF.NFEN_DAT_ENTRAD_SAIDA
                , NFI.INFE_PR_COD
                , NFI.INFE_PR_NOM
                , NFI.INFE_QTD
                , NFI.INFE_VAL_UNIT
                , NFI.INFE_PER_ICMS
                , NFI.INFE_PER_PIS
                , NFI.INFE_PER_COFINS
                , UM_SIG_VENDA AS UND
            FROM NF_ENTID NF
            LEFT JOIN ITEM_NF_ENTID NFI ON NFI.EM_COD					= NF.EM_COD
                                        AND NFI.FI_COD					= NF.FI_COD
                                        AND NFI.EN_COD					= NF.EN_COD
                                        AND NFI.CTDF_MODELO_FORMUL		= NF.CTDF_MODELO_FORMUL
                                        AND NFI.CTDF_SERIE_FORMUL		= NF.CTDF_SERIE_FORMUL
                                        AND NFI.NFEN_NUM_NF				= NF.NFEN_NUM_NF
                                        AND NFI.NFEN_FLG_ENTRAD_SAIDA	= NF.NFEN_FLG_ENTRAD_SAIDA

            LEFT JOIN PRDUTO 	ON PRDUTO.PR_COD	= NFI.PR_COD
            LEFT JOIN ENTID 	ON ENTID.EN_COD 	= NF.EN_COD
            LEFT JOIN FILIAL 	ON FILIAL.FI_CNPJ	= ENTID.EN_CPF_CNPJ
            LEFT JOIN FILIAL FIL ON FIL.EM_COD	= NF.EM_COD
                            AND FIL.FI_COD	= NF.FI_COD

            WHERE 1=1
            AND NFI.PR_COD = $PR_COD
            AND NFI.NFEN_FLG_ENTRAD_SAIDA = 'E'
            AND FILIAL.EM_COD IS NULL
            AND SUBSTR(TRIM(NFI.NAOP_COD_INTERN),-3) IN ($cfop)

            ORDER BY NF.NFEN_DAT_ENTRAD_SAIDA DESC
            FETCH FIRST 3 ROWS ONLY
        ";
        $entrada = DB::connection('oracle')->select($sql);
        return $entrada;
    }
}
