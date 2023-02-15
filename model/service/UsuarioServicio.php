<?php

class UsuarioServicio {

   
    private IUsuarioRepository $userRepository;
   

    public function __construct() {
        $this->userRepository = new UsuarioRepository();
      
    }

    /* Get all notes */

    public function getUsuarios(): array {

        $usuarios = $this->userRepository->getUsuarios();

        return $usuarios;
    }

  
}

?>