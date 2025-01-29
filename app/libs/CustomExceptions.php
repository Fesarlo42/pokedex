<?php

class UserNotFoundException extends Exception {
    protected $message = 'Usuario no encontrado';
}

class IncorrectPasswordException extends Exception {
    protected $message = 'Contraseña incorrecta';
}

class PokemonNotFoundException extends Exception {
    protected $message = 'Pokémon no encontrado';
}
