<?php

abstract class Matematica
{
    public static $fatores = [0, 0];
    public static $precisao = 6;
    public static $round = 1;

    public static function somar()
    {
        $_precisao = (int) self::$precisao;

        $resultado = 0;

        foreach (self::$fatores as $key => $value)
        {
            $fator = (float) $value;

            if ($resultado == 0 && $key == 0)
            {
                $resultado = $fator;
            }
            else
            {
                $_resultado = (float) bcadd($resultado, $fator, $_precisao);
                $resultado = (float) $_resultado;
            }
        }

        $resultado = (float) (self::$round == 1 ? round($resultado, 2) : $resultado);

        self::__destruct();
        return (float) $resultado;
    }

    public static function subtrair()
    {
        $_precisao = (int) self::$precisao;

        $resultado = 0;

        foreach (self::$fatores as $key => $value)
        {
            $fator = (float) $value;

            if ($resultado == 0 && $key == 0)
            {
                $resultado = $fator;
            }
            else
            {
                $_resultado = (float) bcsub($resultado, $fator, $_precisao);
                $resultado = (float) $_resultado;
            }
        }

        $resultado = (float) (self::$round == 1 ? round($resultado, 2) : $resultado);

        self::__destruct();
        return (float) $resultado;
    }

    public static function dividir()
    {
        $_precisao = (int) self::$precisao;

        $resultado = 0;

        foreach (self::$fatores as $key => $value)
        {
            $fator = (float) $value;

            if ($resultado == 0 && $key == 0)
            {
                $resultado = $fator;
            }
            else
            {
                $_resultado = (float) bcdiv($resultado, $fator, $_precisao);
                $resultado = (float) $_resultado;
            }
        }

        $resultado = (float) (self::$round == 1 ? round($resultado, 2) : $resultado);

        self::__destruct();
        return (float) $resultado;
    }

    public static function multiplicar()
    {
        $_precisao = (int) self::$precisao;

        $resultado = 0;

        foreach (self::$fatores as $key => $value)
        {
            $fator = (float) $value;

            if ($resultado == 0 && $key == 0)
            {
                $resultado = $fator;
            }
            else
            {
                $_resultado = (float) bcmul($resultado, $fator, $_precisao);
                $resultado = (float) $_resultado;
            }
        }

        $resultado = (float) (self::$round == 1 ? round($resultado, 2) : $resultado);

        self::__destruct();
        return (float) $resultado;
    }

    public static function modular()
    {
        $resultado = 0;

        if (count(self::$fatores) == 2)
        {
            $numero = (float) self::$fatores[0];
            $fator = (int) self::$fatores[1];

            $resultado = ($numero % $fator);
        }

        self::__destruct();
        return (int) $resultado;
    }

    function __destruct()
    {
        self::$fatores = array(0, 0);
        self::$precisao = 6;
        self::$round = 1;
    }
}
