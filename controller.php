<?php
include_once 'model.php';
session_start();

if (!isset($_SESSION['initialized'])) {
    $_SESSION['types'] = [
        new Type(1, "Electric", "Strong vs Water", "Weak vs Ground"),
        new Type(2, "Fire", "Strong vs Grass", "Weak vs Water"),
        new Type(3, "Grass", "Strong vs Water", "Weak vs Fire")
    ];

    $_SESSION['pokemons'] = [
        new Pokemon(1, "Pikachu", 6.0, "Mouse", 1),
        new Pokemon(2, "Charmander", 8.5, "Lizard", 2),
        new Pokemon(3, "Bulbasaur", 6.9, "Seed", 3),
        new Pokemon(4, "Eevee", 6.5, "Evolution", null)
    ];

    $_SESSION['initialized'] = true;
}

function getNextPokemonId()
{
    $ids = array_map(fn($p) => $p->toArray()['id'], $_SESSION['pokemons']);
    sort($ids);
    $expected = 1;
    foreach ($ids as $id) {
        if ($id != $expected) return $expected;
        $expected++;
    }
    return $expected;
}

function addPokemon($name, $weight, $species)
{
    $id = getNextPokemonId();
    $p = new Pokemon($id, trim($name), floatval($weight), trim($species), null);
    $_SESSION['pokemons'][] = $p;
}

function updatePokemon($id, $name, $weight, $species)
{
    foreach ($_SESSION['pokemons'] as $key => $p) {
        if ($p->toArray()['id'] == (int)$id) {
            $pokemon = $p->toArray();
            $_SESSION['pokemons'][$key] = new Pokemon(
                (int)$id,
                trim($name),
                floatval($weight),
                trim($species),
                $pokemon['type_id']
            );
            break;
        }
    }
}

function deletePokemon($id)
{
    foreach ($_SESSION['pokemons'] as $k => $p) {
        if ($p->toArray()['id'] == (int)$id) {
            unset($_SESSION['pokemons'][$k]);
        }
    }
    $_SESSION['pokemons'] = array_values($_SESSION['pokemons']);
}

function addRelation($pokemon_id, $type_id)
{
    $foundP = false;
    $foundT = false;
    foreach ($_SESSION['pokemons'] as $p) if ($p->toArray()['id'] == (int)$pokemon_id) $foundP = true;
    foreach ($_SESSION['types'] as $t) if ($t->toArray()['id'] == (int)$type_id) $foundT = true;

    if ($foundP && $foundT) {
        foreach ($_SESSION['pokemons'] as $key => $p) {
            if ($p->toArray()['id'] == (int)$pokemon_id) {
                $pokemon = $p->toArray();
                $_SESSION['pokemons'][$key] = new Pokemon(
                    $pokemon['id'],
                    $pokemon['name'],
                    $pokemon['weight'],
                    $pokemon['species'],
                    (int)$type_id
                );
                break;
            }
        }
        return true;
    }
    return false;
}

function updateRelation($pokemon_id, $type_id)
{
    return addRelation($pokemon_id, $type_id);
}

function deleteRelation($pokemon_id)
{
    foreach ($_SESSION['pokemons'] as $key => $p) {
        if ($p->toArray()['id'] == (int)$pokemon_id) {
            $pokemon = $p->toArray();
            $_SESSION['pokemons'][$key] = new Pokemon(
                $pokemon['id'],
                $pokemon['name'],
                $pokemon['weight'],
                $pokemon['species'],
                null
            );
            break;
        }
    }
}

function getPokemonData()
{
    return array_map(function ($pokemon) {
        return $pokemon->toArray();
    }, $_SESSION['pokemons']);
}

function getRelationsData()
{
    $relations = [];
    $types = $_SESSION['types'] ?? [];

    foreach ($_SESSION['pokemons'] as $pokemon) {
        $pokemonData = $pokemon->toArray();
        if ($pokemonData['type_id'] === null) continue;

        $typeData = null;
        foreach ($types as $type) {
            if ($type->toArray()['id'] == $pokemonData['type_id']) {
                $typeData = $type->toArray();
                break;
            }
        }

        if ($typeData) {
            $relations[] = array_merge($pokemonData, [
                'type_name' => $typeData['name'],
                'type_pro' => $typeData['pro'],
                'type_contra' => $typeData['contra']
            ]);
        }
    }
    return $relations;
}

function getAvailablePokemonsForRelation()
{
    $available = [];
    foreach ($_SESSION['pokemons'] as $pokemon) {
        $data = $pokemon->toArray();
        if ($data['type_id'] === null) {
            $available[] = $data;
        }
    }
    return $available;
}

function getAllTypes()
{
    return array_map(function ($type) {
        return $type->toArray();
    }, $_SESSION['types'] ?? []);
}

function getPokemonById($id)
{
    foreach ($_SESSION['pokemons'] as $pokemon) {
        if ($pokemon->toArray()['id'] == (int)$id) {
            return $pokemon->toArray();
        }
    }
    return null;
}

function getPokemonRelationData($id)
{
    $pokemon = getPokemonById($id);
    if (!$pokemon) {
        return null;
    }

    if ($pokemon['type_id'] !== null) {
        foreach ($_SESSION['types'] as $type) {
            if ($type->toArray()['id'] == $pokemon['type_id']) {
                $typeData = $type->toArray();
                return array_merge($pokemon, [
                    'type_name' => $typeData['name'],
                    'type_pro' => $typeData['pro'],
                    'type_contra' => $typeData['contra']
                ]);
            }
        }
    }

    return $pokemon;
}

// Handle POST and GET requests
if (isset($_POST['add_pokemon'])) {
    addPokemon($_POST['name'] ?? '', $_POST['weight'] ?? 0, $_POST['species'] ?? '');
    header("Location: view_pokemon.php");
    exit;
}

if (isset($_POST['update_pokemon'])) {
    updatePokemon((int)($_POST['id'] ?? 0), $_POST['name'] ?? '', $_POST['weight'] ?? 0, $_POST['species'] ?? '');
    header("Location: view_pokemon.php");
    exit;
}

if (isset($_GET['delete_id'])) {
    deletePokemon((int)$_GET['delete_id']);
    header("Location: view_pokemon.php");
    exit;
}

if (isset($_POST['add_relation'])) {
    addRelation((int)($_POST['pokemon_id'] ?? 0), (int)($_POST['type_id'] ?? 0));
    header("Location: view_relation.php");
    exit;
}

if (isset($_POST['update_relation'])) {
    updateRelation((int)($_POST['pokemon_id'] ?? 0), (int)($_POST['type_id'] ?? 0));
    header("Location: view_relation.php");
    exit;
}

if (isset($_GET['delete_rel_id'])) {
    deleteRelation((int)$_GET['delete_rel_id']);
    header("Location: view_relation.php");
    exit;
}
