<?php
/**
 * User model
 * Controls everything related to the users information
 */
class User extends DatabaseConnection {
    public function listAll(): array {}

    public function create(string $name, string $email, string $password, string $picture = 'añadir la por defecto aqui'): bool {}
   
    public function get(string $username): object {}

    public function edit(string $id): object {}

    public function delete(string $id): bool {}

    public function listTeam(string $id): bool {}

    public function resetTeam(string $id): bool {}
}
?>