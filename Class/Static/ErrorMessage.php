<?php

namespace Class\Static;

abstract class ErrorMessage {
    const ERROR_RECURSO_INEXISTENTE = 'El recurso solicitado no existe';
    const ERROR_RUTA_NO_DEFINIDA = 'La ruta no se encuentra definida en la api';
    const ERROR_METODO_NO_DEFINIDO = 'El metodo no esta definido en la api';
}

?>