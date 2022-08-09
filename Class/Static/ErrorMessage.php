<?php

namespace Class\Static;

abstract class ErrorMessage {

    const ERROR_ID_NO_PROPORCIONADO = 'Necesita introducir un id en el cuerpo de la solicitud';
    const ERROR_KEYS_INVALIDAS = 'Las claves proporcionadas son invalidas';
    const ERROR_RUTA_NO_DEFINIDA = 'La ruta no se encuentra definida en la api';
    const ERROR_METODO_NO_DEFINIDO = 'El metodo no esta definido en la api';

    //Mensajes de error para el metodo GET
    const ERROR_GET_RECURSO_INEXISTENTE = 'El recurso solicitado no existe';

    //Mensajes de error para el metodo UPDATE
    const ERROR_UPDATE_RECURSO_INEXISTENTE = 'El recurso que desea actualizar no se encuentra en la base de datos';

    ////Mensajes de error para el metodo DELETE
    const ERROR_DELETE_RECURSO_INEXISTENTE = 'El recurso que desea eliminar no se encuentra en la base de datos';

    
}

?>