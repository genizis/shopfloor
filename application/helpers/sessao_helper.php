<?php

    function getDadosUsuarioLogado()
    {
        $ci =& get_instance();

        $dadosUsuario = $ci->session->userdata('usuario');
        return $dadosUsuario;

    }

    function usuarioLogado()
    {
        $ci =& get_instance();

        return !empty($ci->session->userdata('usuario'));
    }