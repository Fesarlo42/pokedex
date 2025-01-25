<?php
/**
 * Pokemon model
 * Controls everything related to the pokemon information
 */
class Pokemon extends DatabaseConnection {
    public function listAll(): array {}

    public function find(string $name): object {}

    public function add(int $id, string $name, string $type_1, string $type_2 = null, string $description): bool {}
    
    public function edit(int $id): object {}

    public function delete(int $id): bool {}

    public function addToTeam(int $id): bool {}

    public function removeFromTeam(int $id): bool {}

}
?>